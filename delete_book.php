<?php
// Spustenie session pre overenie administrátora
session_start();

// Overenie, či je používateľ prihlásený ako admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Ak nie je admin, presmeruje na prihlasovaciu stránku
    header('Location: login.php');
    exit;
}

// Načítanie triedy Book pre manipuláciu s knihami
require_once 'Book.php';

// Vytvorenie inštancie triedy Book
$bookObj = new Book();

// Získanie ID knihy z GET parametru
$id = $_GET['id'] ?? null;

// Ak ID existuje, kniha sa vymaže z databázy
if ($id) {
    $bookObj->delete($id);
}

// Presmerovanie späť na hlavnú stránku po vymazaní
header('Location: index.php');
exit;
?>