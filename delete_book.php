<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'Book.php';

$bookObj = new Book();


$id = $_GET['id'] ?? null;
if ($id) {
    $bookObj->delete($id);
}


header('Location: index.php');
exit;
?>
