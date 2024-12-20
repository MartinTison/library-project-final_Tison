<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once 'Book.php';

if (!isset($_GET['id'])) {
    die("ID knihy nie je zadané.");
}

$id = $_GET['id'];

$bookObj = new Book();
$bookObj->delete($id);

header("Location: index.php");
exit;
