<?php
require_once "functions.php";
include 'header.php';
?>

<div class="container">
    <div class="row">
        <?php
        $particular_content = show_data();
        if (!empty($particular_content)) {
            echo '
            <div class="container py-5">
                <div class="col-lg-8 mx-auto shadow-lg p-4 bg-white rounded-4">
                    <h2 class="mb-4 text-center fw-bold">Edit Post</h2>
                    <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $particular_content["id"] . '">
                        <div class="mb-3">
                            <label for="title" class="form-label">Post Title</label>
                            <input type="text" class="form-control" id="title" placeholder="Enter your post title" name="update_title" value="' . $particular_content["title"] . '">
                        </div>
                        <div class="mb-4">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" rows="8" placeholder="Write your post content..." name="update_content">' . $particular_content["content"] . '</textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Edit Post</button>
                        </div>
                    </form>
                </div>
            </div>
            ';
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>