<?php

class Comment {
    // Definice instanční proměnné pro připojení k databázi
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    // 1. Přidání nového komentáře/dotazu k inzerátu
    public function create(int $cleatId, int $userId, string $text): bool {
        $sql = "INSERT INTO comments (cleat_id, user_id, text)
                VALUES (:cleat_id, :user_id, :text)";
        
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':cleat_id' => $cleatId,
            ':user_id' => $userId,
            ':text' => $text
        ]);
    }

    // 2. Získání všech komentářů pro konkrétní inzerát (včetně autorů komentářů)
    public function getByCleatId(int $cleatId) {
        $sql = "SELECT comments.*, users.username, users.nickname 
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE comments.cleat_id = :cleat_id 
                ORDER BY comments.id ASC"; // Řadíme od nejstaršího po nejnovější
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':cleat_id' => $cleatId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Získání jednoho konkrétního komentáře podle ID (pro kontrolu práv před úpravou/smazáním)
    public function getById(int $id) {
        $sql = "SELECT * FROM comments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 4. Úprava textu existujícího komentáře
    public function update(int $id, string $text): bool {
        $sql = "UPDATE comments 
                SET text = :text 
                WHERE id = :id";
                
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':text' => $text
        ]);
    }

    // 5. Smazání komentáře z databáze
    public function delete(int $id): bool {
        $sql = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([':id' => $id]);
    }
}