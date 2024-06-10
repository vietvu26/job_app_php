<?php
require_once("config.php");

class Model {
    private $dbserver;
    private $dbuser;
    private $dbpass;
    private $dbname;
    private $conn;
    private $table;

    public function __construct($dbserver, $dbuser, $dbpass, $dbname, $table) {
        $this->dbserver = $dbserver;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
        $this->dbname = $dbname;
        $this->table = $table;
        $this->connect();
    }

    private function connect() {
        $this->conn = mysqli_connect($this->dbserver, $this->dbuser, $this->dbpass, $this->dbname);
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function getAll($limit = 10, $start = 0) {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT $start, $limit";
        $result = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return null;
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = $id";
        $result = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        return null;
    }

    public function insert($data) {
        $fields = implode(',', array_keys($data));
        $values = implode("','", array_map([$this, 'escapeString'], array_values($data)));
        $values = "'$values'";
        $sql = "INSERT INTO {$this->table} ($fields) VALUES ($values)";
        return mysqli_query($this->conn, $sql);
    }

    public function update($data) {
        $id = $data['id'];
        unset($data['id']);
        $set = '';
        foreach ($data as $field => $value) {
            $set .= "$field = '" . $this->escapeString($value) . "', ";
        }
        $set = rtrim($set, ', ');
    
        // Start transaction
        mysqli_autocommit($this->conn, false);
    
        $sql = "UPDATE {$this->table} SET $set WHERE id = $id";
        $result = mysqli_query($this->conn, $sql);
    
        if ($result) {
            // Commit transaction if update is successful
            mysqli_commit($this->conn);
            mysqli_autocommit($this->conn, true);
            return true;
        } else {
            // Rollback transaction if update fails
            mysqli_rollback($this->conn);
            mysqli_autocommit($this->conn, true);
            return false;
        }
    }
    public function exe_query($sql) {
        $result = mysqli_query($this->conn, $sql);
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return null;
    }
    
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = $id";
        return mysqli_query($this->conn, $sql);
    }
    
    private function escapeString($value) {
        return mysqli_real_escape_string($this->conn, $value);
    }

    public function __destruct() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
?>
