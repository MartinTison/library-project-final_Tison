<?php

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
    <h1>Zoznam kníh</h1>
    
    <a href="add_book.php">Pridať novú knihu</a>
    
    <hr>

    <?php if ($books && count($books) > 0): ?>
        <ul>
            <?php foreach ($books as $book): ?>
                <li>
                    <strong>Názov:</strong> <?php echo $book['title']; ?><br>
                    <strong>Autor:</strong> <?php echo $book['author']; ?><br>
                    <strong>Žáner:</strong> <?php echo $book['genre']; ?><br>
                    <strong>Rok:</strong> <?php echo $book['year']; ?><br>
                    <strong>Popis:</strong> <?php echo $book['description']; ?>
                    <br><br>
                    <a href="edit_book.php?id=<?php echo $book['id']; ?>">Upraviť</a> |
                    <a href="delete_book.php?id=<?php echo $book['id']; ?>"
                       onclick="return confirm('Naozaj chcete vymazať túto knihu?');">
                       Vymazať
                    </a>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Zatiaľ žiadne knihy v databáze.</p>
    <?php endif; ?>
</body>
</html>
