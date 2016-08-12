<?php
require_once("../includes/config.php");

class DatabaseAjax {

    private $connection;

    function __construct() {
        $this->openConnection();
    }

    public function openConnection() {
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        if(mysqli_connect_errno()) {
            die("Database connection failed: " . mysqli_error($this->connection));
        }

        $this->query("SET NAMES 'cp1250'");
        $this->query("SET CHARSET 'cp1250'");
    }

    public function closeConnection(){
        if(isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function query($sql) {
        $result = mysqli_query($this->connection, $sql);
        if(!$result) {
            die("Database query failed: " . mysqli_error($this->connection));
        }

        return $result;
    }

    public function mysqlPrep($value) {
        return mysqli_real_escape_string($this->connection, $value);
    }

    public function cleanInput($input) {
        return htmlspecialchars(stripslashes($input));
    }


    public function lastInsertId() {
        return mysqli_insert_id($this->connection);
    }

}

?>