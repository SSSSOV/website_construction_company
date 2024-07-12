<?php
require 'connect_database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $pdo->prepare('DELETE FROM vacancies WHERE id = ?');
    $stmt->execute([$id]);
    
    echo "Vacancy deleted successfully!";
    header('Location: add.php'); // Redirect back to the main page after deletion
    exit;
} else {
    echo "No ID specified!";
}
?>
