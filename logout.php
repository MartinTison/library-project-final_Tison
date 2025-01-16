<?php
// Spustenie session na manipuláciu s prihlasovacími údajmi
session_start();

// Ukončenie aktuálnej session (odhlásenie používateľa)
session_destroy();

// Presmerovanie používateľa späť na hlavnú stránku
header("Location: index.php");
exit;