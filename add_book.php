<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'Book.php';

$bookObj = new Book();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $description = $_POST['description'];

    $bookObj->create($title, $author, $genre, $year, $description);
    header('Location: index.php');
    exit;
}


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
<a href="index.php" class="btn btn-secondary">Späť na hlavnú stránku</a>
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

        <button type="submit" class="btn btn-success">Pridať</button>
    </form>
</div>
</body>
</html>
