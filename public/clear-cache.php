<?php

$cachePath = __DIR__ . '/../bootstrap/cache/';
$files = [
    'routes-v7.php',
    'config.php',
    'events.php',
    'packages.php',
    'services.php'
];

echo "<body style='font-family: sans-serif; padding: 40px; background: #f4f6f8; color: #333;'>";
echo "<div style='max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);'>";
echo "<h1 style='color: #4CAF93; margin-top: 0;'>Laravel Cache & Diagnostics</h1>";

// 1. Check if public/berita directory exists
$publicBeritaPath = __DIR__ . '/berita';
echo "<h2 style='color: #1a2332;'>Diagnostic: public/berita Directory</h2>";
if (is_dir($publicBeritaPath)) {
    echo "<p style='color: #c62828;'><strong>WARNING:</strong> A physical directory <code>public/berita</code> exists on the server! Nginx is bypassing Laravel and trying to serve this directory directly, which causes the 404 Not Found error.</p>";
    
    // Let's attempt to rename it to public/berita_backup
    $backupPath = __DIR__ . '/berita_backup';
    if (rename($publicBeritaPath, $backupPath)) {
        echo "<p style='color: #2e7d32;'><strong>SUCCESS:</strong> Automatically renamed physical directory <code>public/berita</code> to <code>public/berita_backup</code> to free up the URL path for Laravel!</p>";
    } else {
        echo "<p style='color: #c62828;'><strong>ERROR:</strong> Failed to rename <code>public/berita</code> (Permission denied). Please delete or rename it manually on the server.</p>";
    }
} else {
    echo "<p style='color: #2e7d32;'><strong>OK:</strong> No physical <code>public/berita</code> directory exists to block Laravel.</p>";
}

// 2. Clear Laravel bootstrap cache files from disk...
echo "<h2 style='color: #1a2332; margin-top: 30px;'>Clearing Cache Files</h2>";
echo "<ul style='padding-left: 20px; line-height: 1.6;'>";
foreach ($files as $file) {
    $filePath = $cachePath . $file;
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo "<li style='color: #2e7d32;'><strong>Success:</strong> Deleted <code>$file</code></li>";
        } else {
            echo "<li style='color: #c62828;'><strong>Error:</strong> Failed to delete <code>$file</code> (Permission denied)</li>";
        }
    } else {
        echo "<li style='color: #757575;'><strong>Skip:</strong> <code>$file</code> does not exist</li>";
    }
}
echo "</ul>";

// 3. Try executing artisan optimize:clear via shell
echo "<h2 style='color: #1a2332; margin-top: 30px;'>Running Artisan optimize:clear...</h2>";
$artisanPath = __DIR__ . '/../artisan';
$output = shell_exec("php $artisanPath optimize:clear 2>&1");
echo "<pre style='background: #f5f5f5; padding: 15px; border-radius: 8px; border: 1px solid #ddd; overflow-x: auto; font-size: 13px;'>" . htmlspecialchars($output) . "</pre>";

echo "<p style='margin-top: 20px; font-size: 12px; color: #888;'>Run by user: " . htmlspecialchars(get_current_user()) . " / " . htmlspecialchars(exec('whoami')) . "</p>";
echo "</div>";
echo "</body>";
