<?php

class Database
{
    private $host = 'localhost';
    private $db   = 'library';  // Názov DB
    private $user = 'root';     // Užívateľ
    private $pass = '';         // Heslo
    private $charset = 'utf8mb4';

    private $pdo;

    public function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Chyba pri pripojení k databáze: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
