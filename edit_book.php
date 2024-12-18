<?php

require_once 'Book.php';

if (!isset($_GET['id'])) {
    die("ID knihy nie je zadané.");
}

$id = $_GET['id'];


$bookObj = new Book();
$book = $bookObj->getById($id);

if (!$book) {
    die("Kniha s ID $id neexistuje.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = $_POST['title']       ?? '';
    $author      = $_POST['author']      ?? '';
    $genre       = $_POST['genre']       ?? '';
    $year        = $_POST['year']        ?? '';
    $description = $_POST['description'] ?? '';

    $bookObj->update($id, $title, $author, $genre, $year, $description);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Upraviť knihu</title>
</head>
<body>
    <h1>Upraviť knihu</h1>

    <form action="edit_book.php?id=<?php echo $id; ?>" method="POST">
        <label for="title">Názov knihy:</label><br>
        <input type="text" name="title" id="title"
               value="<?php echo htmlspecialchars($book['title']); ?>" required><br><br>

        <label for="author">Autor:</label><br>
        <input type="text" name="author" id="author"
               value="<?php echo htmlspecialchars($book['author']); ?>" required><br><br>

        <label for="genre">Žáner:</label><br>
        <input type="text" name="genre" id="genre"
               value="<?php echo htmlspecialchars($book['genre']); ?>" required><br><br>

        <label for="year">Rok vydania:</label><br>
        <input type="number" name="year" id="year"
               value="<?php echo htmlspecialchars($book['year']); ?>" required><br><br>

        <label for="description">Popis:</label><br>
        <textarea name="description" id="description"><?php echo htmlspecialchars($book['description']); ?></textarea><br><br>

        <button type="submit">Uložiť zmeny</button>
    </form>

    <p><a href="index.php">Späť na zoznam kníh</a></p>
</body>
</html>
