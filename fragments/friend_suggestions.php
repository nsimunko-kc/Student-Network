<p>Ljudi koje možda poznaješ:</p>

<?php

$sql  = 'SELECT id, username, profile_img_path FROM users ';
$sql .= 'WHERE id NOT IN ';
$sql .= '(SELECT following FROM followers WHERE follower = '.$_SESSION['user_id'].') ';
$sql .= 'AND id <> '. $_SESSION['user_id'];

$result = $db->query($sql);

if(mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="friend-suggestion" data-id="<?= $row['id'] ?>">
            <img src="images/profile_images/<?php echo ($row['profile_img_path'] == null ? 'default_profile.jpg' : $row['profile_img_path']); ?>">
            <a href="profile.php?pid=<?= $row['id'] ?>"><?= $row['username'] ?></a>
            <a href="javascript:void(0);" onclick="ajaxFollowFriend(<?= $row['id'].", '".$row['username']."'" ?>);">Prati</a>
        </div>
        <?php
    }
}
?>


