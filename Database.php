<?php

// Trieda na spracovanie pripojenia k databáze
class Database
{
    // Konfigurácia pripojenia k databáze
    private $host = 'localhost'; // Adresa servera
    private $db   = 'library';   // Názov databázy
    private $user = 'root';      // Užívateľské meno
    private $pass = '';          // Heslo (prázdne, ak nebolo zmenené)
    private $charset = 'utf8mb4'; // Kódovanie pre správne zobrazenie znakov

    // PDO inštancia
    private $pdo;

    // Konštruktor na vytvorenie pripojenia
    public function __construct()
    {
        // DSN (Data Source Name) na vytvorenie spojenia s databázou
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";

        try {
            // Vytvorenie nového PDO objektu
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            // Nastavenie režimu chýb (chyby budú vyhadzované ako výnimky)
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Ak sa nepodarí pripojiť, vypíše chybu a ukončí skript
            die("Chyba pri pripojení k databáze: " . $e->getMessage());
        }
    }

    // Funkcia na získanie PDO pripojenia
    public function getConnection()
    {
        return $this->pdo;
    }
}