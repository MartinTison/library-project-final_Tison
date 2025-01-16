<?php
// Spustenie session pre overenie administrátora
session_start();

// Overenie, či je používateľ prihlásený ako admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Ak nie je admin, presmeruje na prihlasovaciu stránku
    header('Location: login.php');
    exit;
}

// Načítanie súboru s triedou Book
require_once 'Book.php';

// Vytvorenie inštancie triedy Book pre manipuláciu s databázou
$bookObj = new Book();

// Kontrola, či bol formulár odoslaný metódou POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Získanie údajov z formulára
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $description = $_POST['description'];

    // Pridanie novej knihy do databázy
    $bookObj->create($title, $author, $genre, $year, $description);

    // Presmerovanie späť na hlavnú stránku po pridaní
    header('Location: index.php');
    exit;
}

// Cesta k CSS súboru pre admina
$cssFile = 'css/admin.css';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pridať knihu</title>
    <link rel="stylesheet" href="<?php echo $cssFile; ?>">
</head>
<body>
<div class="container">
    <h1>Pridať novú knihu</h1>
    <!-- Odkaz späť na hlavnú stránku -->
    <a href="index.php" class="btn btn-secondary">Späť na hlavnú stránku</a>

    <!-- Formulár na pridanie novej knihy -->
    <form action="add_book.php" method="POST">
        <label for="title">Názov:</label>
        <input type="text" name="title" id="title" required>

        <label for="author">Autor:</label>
        <input type="text" name="author" id="author" required>

        <label for="genre">Žáner:</label>
        <input type="text" name="genre" id="genre" required>

        <label for="year">Rok vydania:</label>
        <input type="number" name="year" id="year" required>

        <label for="description">Popis:</label>
        <textarea name="description" id="description" rows="4" required style="width: 100%;"></textarea>

        <!-- Tlačidlo na odoslanie formulára -->
        <button type="submit" class="btn btn-success">Pridať</button>
    </form>
</div>
</body>
</html>