<?php
class Post {

    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    // returns mysqli result set
    public function getPosts($page = 'home', $pid = 0) : mysqli_result {

        $sql = null;

        if($page == 'profile') {
            $sql  = "SELECT posts.*, users.username, users.profile_img_path FROM posts ";
            $sql .= "JOIN users ON posts.user_id = users.id ";
            $sql .= "HAVING posts.user_id = " . $pid;
            $sql .= " ORDER BY post_timestamp DESC";

            return $this->db->query($sql);
        }
        else {
            $pid = $_SESSION['user_id'];

            $sql  = "SELECT posts.*, users.username, users.profile_img_path, followers.follower, followers.following FROM posts ";
            $sql .= "JOIN users ON posts.user_id = users.id ";
            $sql .= "JOIN followers ON followers.following = posts.user_id ";
            $sql .= "WHERE followers.follower = ". $pid . " ";
            $sql .= "OR posts.user_id = ". $pid ." ";
            $sql .= "GROUP BY posts.id ";
            $sql .= "ORDER BY posts.post_timestamp DESC";

            return $this->db->query($sql);
        }

    }

}