<?php

require_once 'Database.php';

class Book
{
    private $pdo;

    public function __construct()
    {
        
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    
    public function getAll($search = '', $genre = '', $year = '')
    {
        $sql = "SELECT * FROM books WHERE 1"; // WHERE 1 umožňuje dynamické podmienky
        $params = [];

        
        if (!empty($search)) {
            $sql .= " AND (title LIKE :search OR author LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        
        if (!empty($genre)) {
            $sql .= " AND genre = :genre";
            $params[':genre'] = $genre;
        }

        
        if (!empty($year)) {
            $sql .= " AND year = :year";
            $params[':year'] = $year;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getById($id)
    {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
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

    
    public function delete($id)
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }			
}
