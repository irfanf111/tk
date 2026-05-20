#!/bin/bash

# ==============================================================================
# AUTOMATED DEPLOYMENT SCRIPT - TK PUSPITASARI
# Target Server: irfan@10.0.2.253
# Target Directory on Server: /home/irfan/tk-puspitasari
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
SERVER_IP="10.0.2.253"
SERVER_PATH="/home/irfan/tk-puspitasari"
BARE_REPO_PATH="/home/irfan/tk-puspitasari.git"
LOCAL_BRANCH="main"

echo -e "${BLUE}======================================================================${NC}"
echo -e "${GREEN}       STARTING AUTOMATED DEPLOYMENT TO SERVER: ${SERVER_IP}${NC}"
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
ssh -o StrictHostKeyChecking=no ${SERVER_USER}@${SERVER_IP} << EOF
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
    echo -e "${GREEN}Added new remote 'production' linking to ${SERVER_USER}@${SERVER_IP}:${BARE_REPO_PATH}${NC}"
fi

# 4. Push Code to Remote Server
echo -e "\n${BLUE}[4/5] Pushing active branch (${LOCAL_BRANCH}) to server...${NC}"
git push production ${LOCAL_BRANCH}:main --force

# 5. Initialize & Configure Project on Server
echo -e "\n${BLUE}[5/5] Performing Initial Setup on Server...${NC}"
ssh -o StrictHostKeyChecking=no ${SERVER_USER}@${SERVER_IP} << EOF
    # Force checkout files from bare repository to target folder
    echo -e "${GREEN}--> Ensuring files are checked out from Git...${NC}"
    git --git-dir=${BARE_REPO_PATH} --work-tree=${SERVER_PATH} checkout -f main

    cd ${SERVER_PATH}
    echo -e "${GREEN}--> Switched to project folder: \$(pwd)${NC}"

    # Setup environment file if not exists
    if [ ! -f ".env" ]; then
        echo -e "${YELLOW}--> .env file not found. Copying .env.example...${NC}"
        cp .env.example .env
        
        # Configure SQLite database file inside .env
        sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/g' .env
        sed -i 's/DB_DATABASE=laravel/DB_DATABASE=\/home\/irfan\/tk-puspitasari\/database\/database.sqlite/g' .env
        
        echo -e "${GREEN}--> .env configured with SQLite.${NC}"
    else
        echo -e "${YELLOW}--> .env already exists. Skipping copy.${NC}"
    fi

    # Create SQLite database file if not exists
    mkdir -p database
    touch database/database.sqlite
    chmod 775 database/database.sqlite
    chmod 775 database
    echo -e "${GREEN}--> SQLite database file verified at database/database.sqlite${NC}"

    # Install Composer dependencies
    if command -v composer &> /dev/null; then
        echo -e "${GREEN}--> Installing Composer dependencies...${NC}"
        composer install --no-dev --optimize-autoloader --ignore-platform-reqs
    else
        echo -e "${RED}Warning: composer is not installed on the server! Please install it.${NC}"
    fi

    # Generate App Key if empty
    if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=base64:$" .env || ! grep -q "APP_KEY=" .env; then
        echo -e "${GREEN}--> Generating application key...${NC}"
        php artisan key:generate
    fi

    # Run Database Migrations
    echo -e "${GREEN}--> Running database migrations...${NC}"
    php artisan migrate --force

    # Create storage symlink
    echo -e "${GREEN}--> Creating storage symlink...${NC}"
    php artisan storage:link --force

    # Install NPM dependencies & build assets
    if command -v npm &> /dev/null; then
        echo -e "${GREEN}--> Installing NPM dependencies & building production assets...${NC}"
        npm install
        npm run build
    else
        echo -e "${YELLOW}Warning: npm/nodejs is not installed on the server! Skipping asset compilation.${NC}"
    fi

    echo -e "${GREEN}--> Adjusting storage & bootstrap/cache permissions...${NC}"
    chmod -R 775 storage bootstrap/cache
    
    echo -e "${GREEN}--> Clearing optimization caches...${NC}"
    php artisan optimize:clear
EOF

echo -e "\n${BLUE}======================================================================${NC}"
echo -e "${GREEN}    🎉 SUCCESS! DEPLOYMENT TO 10.0.2.253 COMPLETED SUCCESSFULLY! 🎉  ${NC}"
echo -e "${BLUE}======================================================================${NC}"
echo -e "You can now push future updates anytime simply by running:"
echo -e "${YELLOW}git push production main${NC}\n"
