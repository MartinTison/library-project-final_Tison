<?php
// Spustenie session pre overenie administrátora
session_start();

// Overenie, či je používateľ prihlásený ako admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Ak nie je admin, presmeruje na prihlasovaciu stránku
    header('Location: login.php');
    exit;
}

// Načítanie triedy Book pre manipuláciu s knihami
require_once 'Book.php';

// Vytvorenie inštancie triedy Book
$bookObj = new Book();

// Spracovanie formulára na úpravu knihy
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Získanie údajov z formulára
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $description = $_POST['description'];

    // Aktualizácia knihy v databáze
    $bookObj->update($id, $title, $author, $genre, $year, $description);

    // Presmerovanie späť na hlavnú stránku po úprave
    header('Location: index.php');
    exit;
}

// Získanie ID knihy na úpravu z GET parametra
$id = $_GET['id'] ?? null;

// Ak ID nie je zadané, presmeruje späť na hlavnú stránku
if (!$id) {
    header('Location: index.php');
    exit;
}

// Načítanie údajov o knihe podľa ID
$book = $bookObj->getById($id);

// Ak kniha neexistuje, presmeruje späť na hlavnú stránku
if (!$book) {
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
    <title>Upraviť knihu</title>
    <link rel="stylesheet" href="<?php echo $cssFile; ?>">
</head>
<body>
<div class="container">
    <h1>Upraviť knihu</h1>
    <!-- Odkaz späť na hlavnú stránku -->
    <a href="index.php" class="btn btn-secondary">Späť na hlavnú stránku</a>
    
    <!-- Formulár na úpravu knihy -->
    <form action="edit_book.php" method="POST">
        <!-- Skryté pole na ID knihy -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($book['id']); ?>">

        <label for="title">Názov:</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>

        <label for="author">Autor:</label>
        <input type="text" name="author" id="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>

        <label for="genre">Žáner:</label>
        <input type="text" name="genre" id="genre" value="<?php echo htmlspecialchars($book['genre']); ?>" required>

        <label for="year">Rok vydania:</label>
        <input type="number" name="year" id="year" value="<?php echo htmlspecialchars($book['year']); ?>" required>

        <label for="description">Popis:</label>
        <textarea name="description" id="description" rows="4" required style="width: 100%;"><?php echo htmlspecialchars($book['description']); ?></textarea>

        <!-- Tlačidlo na uloženie zmien -->
        <button type="submit" class="btn btn-primary">Uložiť zmeny</button>
    </form>
</div>
</body>
</html>