<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 * Shared Hosting / cPanel Root Forwarder
 *
 * This forwarder ensures that when the site is placed directly
 * in public_html, root directory hits properly boot Laravel.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? ''
);

// If the requested URI is an existing static asset inside public/, let server handle it
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

require_once __DIR__ . '/public/index.php';
