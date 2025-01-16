<?php

// Načítanie triedy na pripojenie k databáze
require_once 'Database.php';

// Trieda Book na manipuláciu s tabuľkou 'books' v databáze
class Book
{
    // PDO pripojenie
    private $pdo;

    // Konštruktor - vytvorí pripojenie k databáze pri inicializácii triedy
    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    // Získanie všetkých kníh podľa filtrovania
    public function getAll($search = '', $genre = '', $year = '')
    {
        // SQL dotaz na získanie všetkých kníh s možnosťou filtrov
        $sql = "SELECT * FROM books WHERE 1"; // WHERE 1 slúži na jednoduché pridávanie podmienok
        $params = [];

        // Pridanie filtra podľa názvu alebo autora
        if (!empty($search)) {
            $sql .= " AND (title LIKE :search OR author LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        // Pridanie filtra podľa žánru
        if (!empty($genre)) {
            $sql .= " AND genre = :genre";
            $params[':genre'] = $genre;
        }

        // Pridanie filtra podľa roku vydania
        if (!empty($year)) {
            $sql .= " AND year = :year";
            $params[':year'] = $year;
        }

        // Príprava a vykonanie dotazu
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        // Vrátenie výsledkov ako asociatívne pole
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Získanie jednej knihy podľa ID
    public function getById($id)
    {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Vrátenie výsledku ako asociatívne pole
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Pridanie novej knihy do databázy
    public function create($title, $author, $genre, $year, $description)
    {
        $sql = "INSERT INTO books (title, author, genre, year, description) 
                VALUES (:title, :author, :genre, :year, :description)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':genre' => $genre,
            ':year' => $year,
            ':description' => $description,
        ]);
    }

    // Aktualizácia údajov existujúcej knihy
    public function update($id, $title, $author, $genre, $year, $description)
    {
        $sql = "UPDATE books 
                SET title = :title, author = :author, genre = :genre, 
                    year = :year, description = :description 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':genre' => $genre,
            ':year' => $year,
            ':description' => $description,
        ]);
    }

    // Vymazanie knihy podľa ID
    public function delete($id)
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}