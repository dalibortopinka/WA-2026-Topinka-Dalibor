<?php

class Cleat {
    // Definice, že proměnná $db musí být vždy instancí třídy PDO
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    // Přidání nového inzerátu kopaček do databáze (přijímá i ID prodejce)
    public function create(
        int $userId,
        string $title,
        string $brand,
        string $size,
        string $cleatType,
        float $price,
        string $description,
        array $images
    ): bool {
        $sql = "INSERT INTO cleats (user_id, title, brand, size, cleat_type, price, description, images)
                VALUES (:user_id, :title, :brand, :size, :cleat_type, :price, :description, :images)";
        
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':user_id' => $userId,
            ':title' => $title,
            ':brand' => $brand,
            ':size' => $size,
            ':cleat_type' => $cleatType,
            ':price' => $price,
            ':description' => $description,
            ':images' => json_encode($images)
        ]);
    }

    // Získání všech inzerátů kopaček z databáze včetně informací o prodejci
    public function getAll($filters = []) {
    // Základní SQL dotaz (přidali jsme WHERE 1=1 pro snadné a bezpečné řetězení podmínek AND)
    $sql = "SELECT cleats.*, users.username, users.nickname 
            FROM cleats 
            JOIN users ON cleats.user_id = users.id 
            WHERE 1=1";
            
    $params = [];

    // 1. Filtr podle značky (Adidas, Nike...)
    if (!empty($filters['brand'])) {
        $sql .= " AND cleats.brand = :brand";
        $params['brand'] = $filters['brand'];
    }

    // 2. Filtr podle typu podrážky (FG, SG, AG, TF)
    if (!empty($filters['cleat_type'])) {
        $sql .= " AND cleats.cleat_type = :cleat_type";
        $params['cleat_type'] = $filters['cleat_type'];
    }

    // 3. Filtr podle velikosti (využijeme LIKE, aby zadání "45" našlo i "45.5")
    if (!empty($filters['size'])) {
        $sql .= " AND cleats.size LIKE :size";
        $params['size'] = '%' . $filters['size'] . '%';
    }
    
// IMPLEMENTACE: Bezpečné řazení (Whitelist ochrana)
    $sort = $filters['sort'] ?? '';
    switch ($sort) {
        case 'price_asc':
            $sql .= " ORDER BY cleats.price ASC";
            break;
        case 'price_desc':
            $sql .= " ORDER BY cleats.price DESC";
            break;
        default:
            $sql .= " ORDER BY cleats.id DESC"; // Výchozí: od nejnovějšího
            break;
    }

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Získání jednoho konkrétního inzerátu podle jeho ID včetně informací o prodejci
    public function getById($id) {
        $sql = "SELECT cleats.*, users.username, users.nickname 
                FROM cleats 
                JOIN users ON cleats.user_id = users.id 
                WHERE cleats.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        // Vrátí asociativní pole s daty inzerátu, nebo false, pokud inzerát neexistuje.
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Aktualizace existujícího inzerátu
    public function update(
        $id, $title, $brand, $size, $cleatType, $price, $description, $images = []
    ) {
        $sql = "UPDATE cleats 
                SET title = :title, 
                    brand = :brand, 
                    size = :size, 
                    cleat_type = :cleat_type, 
                    price = :price, 
                    description = :description, 
                    images = :images
                WHERE id = :id";
                
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':brand' => $brand,
            ':size' => $size,
            ':cleat_type' => $cleatType,
            ':price' => $price,
            ':description' => $description,
            ':images' => json_encode($images)
        ]);
    }

    // Trvalé smazání inzerátu z databáze
    public function delete($id) {
        $sql = "DELETE FROM cleats WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        // Vrací true při úspěchu, false při chybě
        return $stmt->execute([':id' => $id]);
    }
    
}