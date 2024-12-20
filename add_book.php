<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once 'Book.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = $_POST['title']       ?? '';
    $author      = $_POST['author']      ?? '';
    $genre       = $_POST['genre']       ?? '';
    $year        = $_POST['year']        ?? '';
    $description = $_POST['description'] ?? '';

    $bookObj = new Book();
    $bookObj->create($title, $author, $genre, $year, $description);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Pridať novú knihu</title>
</head>
<body>
<h1>Pridať novú knihu</h1>

<form action="add_book.php" method="POST">
    <label for="title">Názov knihy:</label><br>
    <input type="text" name="title" id="title" required><br><br>

    <label for="author">Autor:</label><br>
    <input type="text" name="author" id="author" required><br><br>

    <label for="genre">Žáner:</label><br>
    <input type="text" name="genre" id="genre" required><br><br>

    <label for="year">Rok vydania:</label><br>
    <input type="number" name="year" id="year" required><br><br>

    <label for="description">Popis:</label><br>
    <textarea name="description" id="description"></textarea><br><br>

    <button type="submit">Pridať knihu</button>
</form>

<p><a href="index.php">Späť na zoznam kníh</a></p>
</body>
</html>
