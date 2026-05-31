<?php

class Database {
    private $host = "localhost";
    private $db_name = "wa_2026_kopacka"; // Změna názvu databáze pro tvůj bazar
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        
        $this->conn = null;
        
        try {
            // PDO (PHP Data Objects) – Bezpečné a univerzální připojení k databázi
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Z důvodu bezpečnosti a správného fungování přesměrování (header) 
            // zde nesmí být žádný echo výpis.
            
        } catch (PDOException $exception) {
            echo "Chyba připojení: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// Pozor: Testovací spouštění na konci souboru bylo kompletně odstraněno, 
// aby framework mohl správně pracovat se Session a přesměrováním.