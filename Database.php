<?php
class Database {
    private $host = "localhost";
    private $db_name = "db_restoran"; 
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Kita gunakan error_log agar pesan error tidak merusak output JSON
            error_log("Koneksi Gagal: " . $exception->getMessage());
        }
        return $this->conn;
    }
}
?>