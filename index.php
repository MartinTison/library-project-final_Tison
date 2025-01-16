<?php
// Spustenie session na overenie prihlásenia používateľa
session_start();

// Načítanie triedy Book pre manipuláciu s databázou
require_once 'Book.php';

// Vytvorenie inštancie triedy Book
$bookObj = new Book();

// Načítanie filtračných údajov z GET parametrov
$search = $_GET['search'] ?? ''; // Hľadanie podľa názvu alebo autora
$genre = $_GET['genre'] ?? '';   // Filtrovanie podľa žánru
$year = $_GET['year'] ?? '';     // Filtrovanie podľa roku vydania

// Získanie zoznamu kníh podľa filtrov
$books = $bookObj->getAll($search, $genre, $year);

// Načítanie unikátnych žánrov pre zobrazenie v selekte
$genres = array_unique(array_column($bookObj->getAll(), 'genre'));

// Kontrola, či je používateľ prihlásený ako admin
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

// Nastavenie CSS súboru podľa roly používateľa (admin alebo bežný používateľ)
$cssFile = $isAdmin ? 'css/admin.css' : 'css/main.css';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knižnica</title>
    <!-- Dynamické načítanie CSS súboru -->
    <link rel="stylesheet" href="<?php echo $cssFile; ?>">
</head>
<body>
<div class="container">
    <h1>Zoznam kníh</h1>

    <!-- Zobrazenie akcií pre admina alebo možnosť prihlásenia -->
    <?php if ($isAdmin): ?>
        <p>Ste prihlásený ako admin.</p>
        <a href="add_book.php" class="btn btn-success">Pridať novú knihu</a>
        <a href="logout.php" class="btn btn-secondary">Odhlásiť sa</a>
    <?php else: ?>
        <a href="login.php" class="btn btn-primary">Prihlásiť sa</a>
    <?php endif; ?>

    <hr>

    <!-- Formulár na filtrovanie kníh -->
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

        <!-- Tlačidlo na odoslanie filtra -->
        <button type="submit" class="btn btn-primary">Filtrovať</button>
    </form>

    <!-- Tabuľka na zobrazenie zoznamu kníh -->
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
                        <!-- Akcie dostupné len pre admina -->
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