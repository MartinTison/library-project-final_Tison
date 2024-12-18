<?php

require_once 'Book.php';

if (!isset($_GET['id'])) {
    die("ID knihy nie je zadané.");
}

$id = $_GET['id'];

$bookObj = new Book();
$bookObj->delete($id);

header("Location: index.php");
exit;
