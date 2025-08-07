<?php
// -----------------------------------------------------------------------------
//  Fallback front-controller for shared hosts where the document-root points
//  to the project root instead of /public and mod_rewrite is disabled.
//  If /public/index.php exists we simply include it.
// -----------------------------------------------------------------------------
$publicIndex = __DIR__ . '/public/index.php';

if (file_exists($publicIndex)) {
    require $publicIndex;
    return;
}

// If we reach here something is mis-configured. Display a short message that’s
// still safe for production.
header('HTTP/1.1 503 Service Unavailable', true, 503);
header('Content-Type: text/plain; charset=utf-8');
echo "Laravel installation is incomplete: /public/index.php not found.";
