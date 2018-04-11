<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'].'/';

$thisHttpDir = dirname($_SERVER["SCRIPT_NAME"]);

$thisSiteDir = $protocol . str_replace("//", "/", $domainName . $thisHttpDir);

header("Location: {$thisSiteDir}/index.php");