<?php

// used to get mysql database connection
class Config {
    private const DBHOST = 'localhost';
    private const DBPORT = 32768;
    private const DBUSER = 'root';
    private const DBPASS = 'root';
    private const DBNAME = 'levartech_test';
    // Data Source Network
    private $dsn = 'pgsql:host=' . self::DBHOST . ';port='. self::DBPORT. ';dbname=' . self::DBNAME . '';
    // conn variable
    protected $conn = null;

    // Constructor Function
    public function __construct() {
        try {
            $this->conn = new PDO($this->dsn, self::DBUSER, self::DBPASS);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Connectionn Failed : ' . $e->getMessage());
        }
        return $this->conn;
    }

    // Sanitize Inputs
    public function test_input($data) {
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        $data = trim($data);
        return $data;
    }

    // JSON Format Converter Function
    public function message($content, $status, $data = []) {
        return json_encode(['message' => $content, 'data' => $data, 'error' => $status]);
    }

}
?>