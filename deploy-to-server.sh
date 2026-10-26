#!/bin/bash

# ==============================================================================
# AUTOMATED DEPLOYMENT SCRIPT - TK PUSPITASARI (PROXMOX DOCKER)
# Target Server: irfan@10.0.5.2
# Target Directory on Server: /home/irfan/tk
# ==============================================================================

# Exit immediately if a command exits with a non-zero status
set -e

# Stylized Console Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

SERVER_USER="irfan"
SERVER_PATH="/home/irfan/tk"
BARE_REPO_PATH="/home/irfan/tk.git"
LOCAL_BRANCH="main"
SSH_KEY="$HOME/.ssh/id_ed25519_tk"
SSH_OPTS="-o StrictHostKeyChecking=no -i ${SSH_KEY}"

# Auto-detect IP address or accept as CLI argument
SERVER_IP=""
if [ -n "$1" ]; then
    SERVER_IP="$1"
    echo -e "${GREEN}Using IP from command line: ${SERVER_IP}${NC}"
else
    CANDIDATES=("10.0.5.2" "10.0.2.253" "100.69.187.125" "192.168.21.128")
    echo -n "Auto-detecting server IP... "
    for ip in "${CANDIDATES[@]}"; do
        if ssh -o ConnectTimeout=2 -o StrictHostKeyChecking=no -o BatchMode=yes -i "${SSH_KEY}" "${SERVER_USER}@${ip}" "exit" &>/dev/null; then
            SERVER_IP="$ip"
            echo -e "${GREEN}Detected ${SERVER_IP}${NC}"
            break
        fi
    done
    if [ -z "$SERVER_IP" ]; then
        echo -e "${RED}Failed!${NC}"
        echo -e "${RED}Error: None of the candidate server IPs are reachable (${CANDIDATES[*]}).${NC}"
        echo -e "Please check your network connection or specify the IP as an argument: ./deploy-to-server.sh <IP>"
        exit 1
    fi
fi

echo -e "${BLUE}======================================================================${NC}"
echo -e "${GREEN}        STARTING AUTOMATED DEPLOYMENT TO SERVER: ${SERVER_IP}${NC}"
echo -e "${BLUE}======================================================================${NC}"

# 1. Verification of Local Git
echo -e "\n${BLUE}[1/5] Verifying Local Repository...${NC}"
if [ ! -d ".git" ]; then
    echo -e "${RED}Error: This script must be run from the root of your Git repository.${NC}"
    exit 1
fi

# Determine current branch
CURRENT_BRANCH=$(git branch --show-current)
echo -e "Current local branch is: ${YELLOW}${CURRENT_BRANCH}${NC}"
if [ "$CURRENT_BRANCH" != "$LOCAL_BRANCH" ]; then
    echo -e "${YELLOW}Warning: You are not on the '${LOCAL_BRANCH}' branch. We will deploy the '${CURRENT_BRANCH}' branch instead.${NC}"
    LOCAL_BRANCH=$CURRENT_BRANCH
fi

# 2. Setup Bare Repository and Hook on Remote Server via SSH
echo -e "\n${BLUE}[2/5] Creating Git Bare Repository & Hook on Remote Server...${NC}"
ssh ${SSH_OPTS} ${SERVER_USER}@${SERVER_IP} << EOF
    set -e
    echo -e "${GREEN}--> Connected to server as \$(whoami)${NC}"
    
    # Create target deployment folder
    mkdir -p ${SERVER_PATH}
    
    # Create bare git repository
    mkdir -p ${BARE_REPO_PATH}
    cd ${BARE_REPO_PATH}
    if [ ! -d "hooks" ]; then
        git init --bare
        git symbolic-ref HEAD refs/heads/main
        echo -e "${GREEN}--> Bare Git repository initialized at ${BARE_REPO_PATH}${NC}"
    else
        git symbolic-ref HEAD refs/heads/main
        echo -e "${YELLOW}--> Bare Git repository already exists. Setting HEAD to main.${NC}"
    fi

    # Create post-receive hook
    echo -e "${GREEN}--> Writing post-receive hook...${NC}"
    cat << 'HOOK' > hooks/post-receive
#!/bin/bash
TARGET="${SERVER_PATH}"
GIT_DIR="${BARE_REPO_PATH}"

echo -e "\033[0;32m[Server Hook] Checking out files to target directory...\033[0m"
git --work-tree=\$TARGET --git-dir=\$GIT_DIR checkout -f main

echo -e "\033[0;32m[Server Hook] Checkout completed successfully!\033[0m"
HOOK

    # Make hook executable
    chmod +x hooks/post-receive
    echo -e "${GREEN}--> Hook is now executable.${NC}"
EOF

# 3. Add Remote Target Locally if Not Exists
echo -e "\n${BLUE}[3/5] Configuring Local Git Remote...${NC}"
if git remote | grep -q "production"; then
    echo -e "${YELLOW}Remote 'production' already exists. Updating URL...${NC}"
    git remote set-url production ${SERVER_USER}@${SERVER_IP}:${BARE_REPO_PATH}
else
    git remote add production ${SERVER_USER}@${SERVER_IP}:${BARE_REPO_PATH}
fi

# Configure SSH command for git to use our key
export GIT_SSH_COMMAND="ssh -i ${SSH_KEY} -o StrictHostKeyChecking=no"

# 4. Push Code to Remote Server
echo -e "\n${BLUE}[4/5] Pushing active branch (${LOCAL_BRANCH}) to server...${NC}"
git push production ${LOCAL_BRANCH}:main --force

# 5. Performing Setup inside Docker Container
echo -e "\n${BLUE}[5/5] Performing Initial Setup on Server...${NC}"
ssh ${SSH_OPTS} ${SERVER_USER}@${SERVER_IP} << EOF
    set -e

    # Backup critical files before deployment
    echo -e "${GREEN}--> Checking for critical files to backup...${NC}"
    BACKUP_DIR="/home/irfan/tk-backups"
    mkdir -p \${BACKUP_DIR}
    TIMESTAMP=\$(date +%Y%m%d_%H%M%S)

    if [ -d "${SERVER_PATH}" ]; then
        if [ -f "${SERVER_PATH}/.env" ]; then
            cp "${SERVER_PATH}/.env" "\${BACKUP_DIR}/.env_\${TIMESTAMP}"
            echo -e "${GREEN}    * Backed up .env to \${BACKUP_DIR}/.env_\${TIMESTAMP}${NC}"
        fi
        (cd \${BACKUP_DIR} && ls -t | tail -n +16 | xargs rm -f 2>/dev/null || true)
    fi

    # Create Nginx compatibility symlink if it doesn't exist
    if [ ! -e "/home/irfan/tk-puspitasari" ]; then
        echo -e "${GREEN}--> Creating symlink from /home/irfan/tk-puspitasari to ${SERVER_PATH} for Nginx compatibility...${NC}"
        ln -s ${SERVER_PATH} /home/irfan/tk-puspitasari
    fi

    # Force checkout files from bare repository to target folder
    echo -e "${GREEN}--> Ensuring files are checked out from Git...${NC}"
    git --git-dir=${BARE_REPO_PATH} --work-tree=${SERVER_PATH} checkout -f main

    cd ${SERVER_PATH}
    echo -e "${GREEN}--> Switched to project folder: \$(pwd)${NC}"

    # Force clean .env configuration for MariaDB Docker
    echo -e "${GREEN}--> Setting up clean .env file for MariaDB...${NC}"
    if [ -f ".env.example" ]; then
        cp .env.example .env
    fi

    sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env 2>/dev/null || echo "DB_CONNECTION=mysql" >> .env
    sed -i 's/^DB_HOST=.*/DB_HOST=tk-puspitasari-db-1/' .env 2>/dev/null || echo "DB_HOST=tk-puspitasari-db-1" >> .env
    sed -i 's/^DB_PORT=.*/DB_PORT=3306/' .env 2>/dev/null || echo "DB_PORT=3306" >> .env
    sed -i 's/^DB_DATABASE=.*/DB_DATABASE=tk_puspitasari/' .env 2>/dev/null || echo "DB_DATABASE=tk_puspitasari" >> .env
    sed -i 's/^DB_USERNAME=.*/DB_USERNAME=root/' .env 2>/dev/null || echo "DB_USERNAME=root" >> .env
    sed -i 's/^DB_PASSWORD=.*/DB_PASSWORD=rootpassword/' .env 2>/dev/null || echo "DB_PASSWORD=rootpassword" >> .env
    sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env 2>/dev/null || true
    sed -i 's/^CACHE_STORE=.*/CACHE_STORE=file/' .env 2>/dev/null || true
    sed -i 's/^CACHE_DRIVER=.*/CACHE_DRIVER=file/' .env 2>/dev/null || true
    sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env 2>/dev/null || true
    sed -i 's/^APP_DEBUG=.*/APP_DEBUG=false/' .env 2>/dev/null || true
    sed -i "s|^APP_URL=.*|APP_URL=https://tkpuspitasarikaliwatubumi.sch.id|" .env 2>/dev/null || true

    # Force generate Dockerfile (PHP 8.4 + intl extension for Filament)
    echo -e "${YELLOW}--> Generating Laravel Dockerfile (PHP 8.4)...${NC}"
    cat << 'DOCKERFILE' > Dockerfile
FROM php:8.4-apache
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql zip intl \
    && a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!\${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!\${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
DOCKERFILE

    # Generate docker-compose.yml
    echo -e "${YELLOW}--> Generating Compose configuration...${NC}"
    cat << 'DOCKERCOMPOSE' > docker-compose.yml
services:
  db:
    image: mariadb:10.11
    container_name: tk-puspitasari-db-1
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: tk_puspitasari
      MYSQL_USER: root
      MYSQL_PASSWORD: rootpassword
    volumes:
      - db_data:/var/lib/mysql

  app:
    build: .
    image: tk-puspitasari-app
    container_name: tk-puspitasari-app-1
    restart: unless-stopped
    ports:
      - "8188:80"
    environment:
      DB_HOST: tk-puspitasari-db-1
      DB_PORT: 3306
      DB_DATABASE: tk_puspitasari
      DB_USERNAME: root
      DB_PASSWORD: rootpassword
    volumes:
      - .:/var/www/html
    depends_on:
      - db

volumes:
  db_data:
DOCKERCOMPOSE

    # Spin up Docker containers using docker compose (--build forces rebuild with PHP 8.4)
    echo -e "${GREEN}--> Building & Starting Docker containers...${NC}"
    sudo docker compose up -d --build

    # Wait for container initialization
    sleep 3

    # Detect container name dynamically
    APP_CONTAINER=\$(sudo docker ps --format '{{.Names}}' | grep -E 'tk-puspitasari.*app|tk.*app-1' | head -n 1)
    if [ -z "\$APP_CONTAINER" ]; then
        APP_CONTAINER="tk-puspitasari-app-1"
    fi

    echo -e "${GREEN}--> Executing commands inside container: \$APP_CONTAINER${NC}"
    sudo docker exec \$APP_CONTAINER composer install --no-dev --optimize-autoloader || true
    sudo docker exec \$APP_CONTAINER php artisan key:generate --force || true
    sudo docker exec \$APP_CONTAINER php artisan migrate --force || true
    sudo docker exec \$APP_CONTAINER php artisan storage:link --force || true
    sudo docker exec \$APP_CONTAINER php artisan optimize:clear
    sudo docker exec \$APP_CONTAINER chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

    # Install NPM dependencies & build assets on host if available
    if command -v npm &> /dev/null; then
        echo -e "${GREEN}--> Building production assets...${NC}"
        npm install
        npm run build
    fi

    echo -e "${GREEN}--> Adjusting storage & bootstrap/cache permissions on host...${NC}"
    sudo chmod -R 777 storage bootstrap/cache 2>/dev/null || true
EOF

echo -e "\n${BLUE}======================================================================${NC}"
echo -e "${GREEN}    🎉 SUCCESS! DEPLOYMENT TO ${SERVER_IP} COMPLETED SUCCESSFULLY! 🎉  ${NC}"
echo -e "${BLUE}======================================================================${NC}"
echo -e "You can now push future updates anytime simply by running:"
echo -e "${YELLOW}git push production main${NC}\n"