<?php
session_start();
define('BASE_URL', '../');
require_once '../includes/config.php';
require_once '../includes/auth_check.php';
$db = getDB();
$id = (int)($_GET['id']??0);
if ($id) $db->query("DELETE FROM courses WHERE id=$id");
$db->close();
header("Location: index.php?success=deleted");
exit();
?>
