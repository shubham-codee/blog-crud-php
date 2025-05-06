<?php
require_once("functions.php");
include("header.php");
?>
<div class="container py-5">
    <div class="col-lg-8 mx-auto shadow-lg p-4 bg-white rounded-4">
        <h2 class="mb-4 text-center fw-bold">Add a New Post</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Post Title</label>
                <input type="text" class="form-control" id="title" placeholder="Enter your post title" name="title">
            </div>
            <div class="mb-4">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" rows="8" placeholder="Write your post content..." name="content"></textarea>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Publish Post</button>
            </div>
        </form>
    </div>
</div>

<?php
include("footer.php");
?>