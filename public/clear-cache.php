<?php

echo "<body style='font-family: sans-serif; padding: 40px; background: #f4f6f8; color: #333;'>";
echo "<div style='max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);'>";
echo "<h1 style='color: #4CAF93; margin-top: 0;'>Route Diagnostics</h1>";

$artisanPath = __DIR__ . '/../artisan';

// 1. Run optimize:clear
echo "<h2 style='color: #1a2332;'>1. Clearing Cache</h2>";
$outClear = shell_exec("php $artisanPath optimize:clear 2>&1");
echo "<pre style='background: #f5f5f5; padding: 15px; border-radius: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($outClear) . "</pre>";

// 2. List all 'berita' routes
echo "<h2 style='color: #1a2332; margin-top: 30px;'>2. Route List for 'berita'</h2>";
$outRoutes = shell_exec("php $artisanPath route:list --path=berita 2>&1");
echo "<pre style='background: #f5f5f5; padding: 15px; border-radius: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($outRoutes) . "</pre>";

// 3. Test HTTP locally
echo "<h2 style='color: #1a2332; margin-top: 30px;'>3. Local HTTP Test</h2>";
$ch = curl_init("http://127.0.0.1:8081/berita");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<p><strong>HTTP Status Code:</strong> $httpCode</p>";
$headers = substr($response, 0, strpos($response, "\r\n\r\n"));
echo "<pre style='background: #f5f5f5; padding: 15px; border-radius: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($headers) . "</pre>";

echo "</div></body>";
