<?php
// Spustenie session na uloženie informácií o prihlásení
session_start();

// Spracovanie údajov z prihlasovacieho formulára
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // Získanie používateľského mena
    $password = $_POST['password']; // Získanie hesla

    // Overenie prihlasovacích údajov
    if ($username === 'admin' && password_verify($password, '$2y$10$nadrWOViF.iHnK0mx0ie/ueRBGAmCni5UxtU4MY37WH60i8/hrrgu')) {
        // Prihlásenie administrátora
        $_SESSION['admin'] = true;

        // Presmerovanie na hlavnú stránku
        header('Location: index.php');
        exit;
    } else {
        // Chybová hláška pri nesprávnych údajoch
        $error = "Nesprávne prihlasovacie údaje.";
    }
}

// Nastavenie cesty k CSS pre štandardných používateľov
$cssFile = 'css/main.css';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prihlásenie</title>
    <link rel="stylesheet" href="<?php echo $cssFile; ?>">
</head>
<body>
<div class="container">
    <h1>Prihlásenie</h1>

    <!-- Zobrazenie chybovej hlášky, ak sú nesprávne údaje -->
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <!-- Formulár na prihlásenie -->
    <form action="login.php" method="POST">
        <label for="username">Používateľské meno:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password" required>

        <!-- Tlačidlo na odoslanie formulára -->
        <button type="submit" class="btn btn-primary">Prihlásiť sa</button>
    </form>

    <!-- Odkaz späť na hlavnú stránku -->
    <a href="index.php" class="btn btn-secondary">Späť na hlavnú stránku</a>
</div>
</body>
</html>