<?php
/**
 * Simple custom router for Laravel in Replit environment
 * This script allows running Laravel without using artisan serve
 * by directly processing requests and bootstrapping the application.
 */

// Define the document root
$documentRoot = __DIR__ . '/public';

// Get the requested URI
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Set working directory to public folder
chdir($documentRoot);

// If the file exists, serve directly
if ($uri !== '/' && file_exists($documentRoot . $uri)) {
    // Determine the file's MIME type
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg', 
        'png' => 'image/png',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
        'json' => 'application/json',
        'pdf' => 'application/pdf',
        'zip' => 'application/zip',
    ];
    
    $extension = pathinfo($uri, PATHINFO_EXTENSION);
    if (isset($mimeTypes[$extension])) {
        header('Content-Type: ' . $mimeTypes[$extension]);
    }
    
    readfile($documentRoot . $uri);
    return;
}

// Otherwise, include the index.php file
require_once $documentRoot . '/index.php';