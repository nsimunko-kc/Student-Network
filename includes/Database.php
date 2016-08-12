<?php
require_once("includes/config.php");

class Database {

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

    // return id of last insert
    public function insertNewUser($username, $email, $password, $description = null) {

        $sql = "INSERT INTO users (username, email, password, salt, profile_img_path, joined, last_login, bio)";
        $sql .= " VALUES (?,?,?,?,?,?,?,?)";

        $stmt = mysqli_prepare($this->connection, $sql);

        $salt = sha1($username);
        $password = sha1($password . $salt);
        $profileImgPath = null;
        $joined = date('Y-m-d');
        $lastLogin = $joined;

        mysqli_stmt_bind_param($stmt, "ssssssss", $username, $email, $password,
                                $salt, $profileImgPath, $joined, $lastLogin, $description);

        mysqli_stmt_execute($stmt);

        if(mysqli_stmt_affected_rows($stmt) == 1) {
            return $this->lastInsertId();
        }

        return 0;
    }

    // return id of last post insert
    public function insertNewPost($userId, $postContent) {

        $sql = "INSERT INTO posts (user_id, num_of_likes, post_timestamp, content) ";
        $sql .= "VALUES (?,?,?,?)";

        $stmt = mysqli_prepare($this->connection, $sql);

        $numOfLikes = 0;
        $postTimestamp = date('Y-m-d H:i:s');

        mysqli_stmt_bind_param($stmt, "iiss", $userId, $numOfLikes, $postTimestamp, $postContent);

        mysqli_stmt_execute($stmt);

        if(mysqli_stmt_affected_rows($stmt) == 1) {
            return $this->lastInsertId();
        }

        return 0;
    }

    public function lastInsertId() {
        return mysqli_insert_id($this->connection);
    }

    public function checkUserLogin($username, $password) {

        // take username, get salt, run hash with salt on password
        $sql = 'SELECT * FROM users WHERE username = ? AND password = SHA1(CONCAT(?, salt))';

        $stmt = mysqli_prepare($this->connection, $sql);

        mysqli_stmt_bind_param($stmt, "ss", $username, $password);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if($result == false) {
            return false;
        }
        else {
            // user found
            $row = mysqli_fetch_assoc($result);
            return $row['id'];
        }

    }
}

?>