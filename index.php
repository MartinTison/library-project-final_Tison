<?php
session_start();
require_once 'Book.php';

$bookObj = new Book();
$books = $bookObj->getAll();
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Zoznam kníh</title>
</head>
<body>

<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
    <!-- Admin sekcia -->
    <p>Ste prihlásený ako admin.</p>
    <a href="add_book.php">Pridať novú knihu</a> |
    <a href="logout.php">Odhlásiť sa</a>
<?php else: ?>
    <!-- Verejná sekcia -->
    <a href="login.php">Prihlásiť sa</a>
<?php endif; ?>

<hr>

<h1>Zoznam kníh</h1>

<ul>
    <?php foreach ($books as $book): ?>
        <li>
            <strong>Názov:</strong> <?php echo $book['title']; ?><br>
            <strong>Autor:</strong> <?php echo $book['author']; ?><br>
            <strong>Žáner:</strong> <?php echo $book['genre']; ?><br>
            <strong>Rok:</strong> <?php echo $book['year']; ?><br>
            <strong>Popis:</strong> <?php echo $book['description']; ?><br><br>

            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
                <!-- Admin odkazy -->
                <a href="edit_book.php?id=<?php echo $book['id']; ?>">Upraviť</a> |
                <a href="delete_book.php?id=<?php echo $book['id']; ?>"
                   onclick="return confirm('Naozaj chcete vymazať túto knihu?');">
                   Vymazať
                </a>
            <?php endif; ?>
        </li>
        <hr>
    <?php endforeach; ?>
</ul>

</body>
</html>
