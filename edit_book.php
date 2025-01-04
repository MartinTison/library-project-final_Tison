<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'Book.php';

$bookObj = new Book();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $description = $_POST['description'];

    $bookObj->update($id, $title, $author, $genre, $year, $description);
    header('Location: index.php');
    exit;
}


$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$book = $bookObj->getById($id);
if (!$book) {
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
    <title>Upraviť knihu</title>
    <link rel="stylesheet" href="<?php echo $cssFile; ?>">
</head>
<body>
<div class="container">
    <h1>Upraviť knihu</h1>
    <a href="index.php" class="btn btn-secondary">Späť na hlavnú stránku</a>
    <form action="edit_book.php" method="POST">
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
        <textarea name="description" id="description" rows="4" required style="width: 100%;">
        <?php echo htmlspecialchars($book['description']); ?></textarea>

        <button type="submit" class="btn btn-primary">Uložiť zmeny</button>
    </form>
</div>
</body>
</html>
