<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    if ($username === 'admin' && password_verify($password, '$2y$10$nadrWOViF.iHnK0mx0ie/ueRBGAmCni5UxtU4MY37WH60i8/hrrgu')) {
        $_SESSION['admin'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = "Nesprávne prihlasovacie údaje.";
    }
}

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
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="username">Používateľské meno:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit" class="btn btn-primary">Prihlásiť sa</button>
    </form>
    <a href="index.php" class="btn btn-secondary">Späť na hlavnú stránku</a>
</div>
</body>
</html>
