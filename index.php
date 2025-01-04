<?php
session_start();
require_once 'Book.php';

$bookObj = new Book();

$search = $_GET['search'] ?? '';
$genre = $_GET['genre'] ?? '';
$year = $_GET['year'] ?? '';

$books = $bookObj->getAll($search, $genre, $year);

$genres = array_unique(array_column($bookObj->getAll(), 'genre'));

$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
$cssFile = $isAdmin ? 'css/admin.css' : 'css/main.css';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knižnica</title>
    <link rel="stylesheet" href="<?php echo $cssFile; ?>">
</head>
<body>
<div class="container">
    <h1>Zoznam kníh</h1>

    <?php if ($isAdmin): ?>
        <p>Ste prihlásený ako admin.</p>
        <a href="add_book.php" class="btn btn-success">Pridať novú knihu</a>
        <a href="logout.php" class="btn btn-secondary">Odhlásiť sa</a>
    <?php else: ?>
        <a href="login.php" class="btn btn-primary">Prihlásiť sa</a>
    <?php endif; ?>

    <hr>

    <!-- Filtrovanie -->
    <form action="index.php" method="GET">
        <label for="search">Hľadať podľa názvu alebo autora:</label>
        <input type="text" name="search" id="search" 
               value="<?php echo htmlspecialchars($search); ?>" placeholder="Zadajte text">

        <label for="genre">Vyberte žáner:</label>
        <select name="genre" id="genre">
            <option value="">Všetky žánre</option>
            <?php foreach ($genres as $g): ?>
                <option value="<?php echo htmlspecialchars($g); ?>" 
                    <?php echo ($g === $genre) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($g); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="year">Rok vydania:</label>
        <input type="number" name="year" id="year" 
               value="<?php echo htmlspecialchars($year); ?>" placeholder="Zadajte rok">

        <button type="submit" class="btn btn-primary">Filtrovať</button>
    </form>

    <!-- Tabuľka kníh -->
    <table>
        <thead>
            <tr>
                <th>Názov</th>
                <th>Autor</th>
                <th>Žáner</th>
                <th>Rok</th>
                <th>Popis</th>
                <?php if ($isAdmin): ?>
                    <th>Akcie</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo htmlspecialchars($book['genre']); ?></td>
                    <td><?php echo htmlspecialchars($book['year']); ?></td>
                    <td><?php echo htmlspecialchars($book['description']); ?></td>
                    <?php if ($isAdmin): ?>
                        <td>
                            <a href="edit_book.php?id=<?php echo $book['id']; ?>" class="btn btn-primary">Upraviť</a>
                            <a href="delete_book.php?id=<?php echo $book['id']; ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Naozaj chcete vymazať túto knihu?');">
                               Vymazať
                            </a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
