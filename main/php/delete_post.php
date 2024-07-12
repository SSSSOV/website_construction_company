<?php
require 'connect_database.php';

$id = $_GET['id'];

$stmt = $pdo->prepare('DELETE FROM posts WHERE id = ?');
$stmt->execute([$id]);

header('Location: add.php');
exit;
?>