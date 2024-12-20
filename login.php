<?php
session_start();
require_once 'Database.php';

if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    
    $db = new Database();
    $pdo = $db->getConnection();

    
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        
        if (password_verify($password, $user['password'])) {
            // Úspešné prihlásenie
            $_SESSION['admin'] = true;
            
            header("Location: index.php");
            exit;
        } else {
            $error = "Nesprávne heslo.";
        }
    } else {
        $error = "Používateľ neexistuje.";
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Prihlásenie - Admin</title>
</head>
<body>
    <h1>Prihlásenie do administrácie</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label for="username">Používateľské meno:</label><br>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Heslo:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Prihlásiť sa</button>
    </form>
    <p><a href="index.php">Späť na hlavnú stránku</a></p>
</body>
</html>
