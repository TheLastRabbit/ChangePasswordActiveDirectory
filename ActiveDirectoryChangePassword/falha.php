<?php 

$file = 'img/falha.gif';

// Do whatever checks you want on permissions etc
header('Content-type: image/gif');
readfile($file);

?>
