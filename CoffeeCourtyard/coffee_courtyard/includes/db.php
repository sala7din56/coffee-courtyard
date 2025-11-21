<?php
/**
 * Database Connection Class
 * Coffee CourtYard Website
 *
 * Handles all database operations with prepared statements
 * for SQL injection protection
 */

require_once 'config.php';

class Database {
    private $conn;

    /**
     * Constructor - Establishes database connection
     */
    public function __construct() {
        try {
            $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }

            // Set charset to UTF-8
            $this->conn->set_charset("utf8mb4");

        } catch (Exception $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }

    /**
     * Get database connection
     * @return mysqli
     */
    public function getConnection() {
        return $this->conn;
    }

    /**
     * Prepare SQL statement
     * @param string $query
     * @return mysqli_stmt
     */
    public function prepare($query) {
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }
        return $stmt;
    }

    /**
     * Execute a query and return results
     * @param string $query
     * @return mysqli_result|bool
     */
    public function query($query) {
        return $this->conn->query($query);
    }

    /**
     * Escape string for SQL
     * @param string $str
     * @return string
     */
    public function escapeString($str) {
        return $this->conn->real_escape_string($str);
    }

    /**
     * Get last insert ID
     * @return int
     */
    public function lastInsertId() {
        return $this->conn->insert_id;
    }

    /**
     * Begin transaction
     */
    public function beginTransaction() {
        $this->conn->begin_transaction();
    }

    /**
     * Commit transaction
     */
    public function commit() {
        $this->conn->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback() {
        $this->conn->rollback();
    }

    /**
     * Close database connection
     */
    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    /**
     * Destructor - Closes connection
     */
    public function __destruct() {
        $this->close();
    }
}
?>
