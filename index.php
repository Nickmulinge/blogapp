<?php
include 'db.php';

// Add a post
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    $conn->query($sql);
    header('location: index.php');
}

// Edit a post
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
    $conn->query($sql);
    header('location: index.php');
}

// Delete a post
if (isset($_GET['del_post'])) {
    $id = $_GET['del_post'];
    $sql = "DELETE FROM posts WHERE id=$id";
    $conn->query($sql);
    header('location: index.php');
}

// Fetch posts
$posts = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>My Blog</h1>

        <form method="post" action="index.php" class="post-form">
            <input type="text" name="title" placeholder="Post Title" required>
            <textarea name="content" placeholder="Write your post here..." required></textarea>
            <button type="submit" name="add">Add Post</button>
        </form>

        <div class="posts">
            <?php while ($row = $posts->fetch_assoc()) { ?>
                <div class="post">
                    <h2><?php echo $row['title']; ?></h2>
                    <p><?php echo nl2br($row['content']); ?></p>
                    <span><?php echo $row['created_at']; ?></span>
                    <form method="post" action="index.php" class="edit-form">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="title" value="<?php echo $row['title']; ?>" required>
                        <textarea name="content" required><?php echo $row['content']; ?></textarea>
                        <button type="submit" name="edit">Edit Post</button>
                    </form>
                    <a href="index.php?del_post=<?php echo $row['id']; ?>" class="delete-btn">Delete</a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
