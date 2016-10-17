<?php 
$root = $_SERVER['DOCUMENT_ROOT'];
$file = $root . "/pdf/".$_REQUEST["file"];
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($file).'"');
header('Content-Length: ' . filesize($file));
readfile($file);
?>
