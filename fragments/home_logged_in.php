<?php
$user = mysqli_fetch_assoc($db->query('SELECT * FROM users WHERE id = ' . $_SESSION['user_id']));

$memberSince = substr($user['joined'], 8, 2).'.'
                .substr($user['joined'], 5, 2).'.'
                .substr($user['joined'], 0, 4).'.';

$postCount = mysqli_fetch_assoc($db->query('SELECT COUNT(*) AS post_count FROM posts WHERE user_id = ' . $_SESSION['user_id']));

$commentCount = mysqli_fetch_assoc($db->query('SELECT COUNT(*) AS comm_count FROM comments WHERE user_id = ' . $_SESSION['user_id']));

?>

<div class="container">
    <aside class="left-aside">
        <div>
            <img src="images/profile_images/<?= ($user['profile_img_path'] == null ? 'default_profile.jpg' : $user['profile_img_path']) ?>" alt="Profile image">
            <a href="profile.php?pid=<?=$_SESSION['user_id']?>"><?= $user['username'] ?></a>
            <p><span><?=$postCount['post_count']?></span> objava</p>
            <p><span><?=$commentCount['comm_count']?></span> komentara</p>
            <p>Član od:</p>
            <p><span><?=$memberSince?></span></p>
            <p>Kratki opis:</p>
            <p><?=$user['bio']?></p>
        </div>
    </aside>
    <section class="post-section">
        <?php include("fragments/new_post_div.php"); ?>
        <div class="post-timeline-div">
            <?php
            $result = $postHandler->getPosts();

            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <article class="post" data-id="<?=$row['id']?>">
                        <div>
                            <div>
                                <img src="images/profile_images/<?=$row['profile_img_path']?>" alt="<?=$row['username']?>">
                            </div>
                            <div>
                                <p><a href="profile.php?pid=<?=$row['user_id']?>"><?=$row['username']?></a></p>
                                <p><?=$row['post_timestamp']?></p>
                            </div>
                            <div class="clear"></div>
                            <p class="post-content"><?=$row['content']?></p>
                            <?php
                            if($row['image_path'] != null) {
                                echo "<img src='images/posted_images/{$row['image_path']}'>";
                            }
                            ?>
                            <a href="javascript:void(0);" class="left like-btn" onclick="ajaxLike(<?=$row['id']?>);">Sviđa mi se (<?=$row['num_of_likes']?>)</a>
                            <?php if($row['user_id'] == $_SESSION['user_id']) {
                                echo "<a href='javascript:void(0);' class='right' onclick='ajaxDelete({$row['id']});'>Obriši</a>";
                            } ?>
                            <div class="clear"></div>
                        </div>
                    </article>
                    <hr data-id="<?=$row['id']?>" />
                    <?php
                }
            }
            ?>

        </div>
    </section>
    <aside class="right-aside">
        <?php include('fragments/friend_suggestions.php'); ?>
    </aside>
    <div class="clear"></div>
</div>