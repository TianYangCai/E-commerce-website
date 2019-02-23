<?php
session_start();
session_destroy();
$redir = "index.php";
header('Location: ' . $redir);
?>
