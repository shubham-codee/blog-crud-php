<?php
require_once "functions.php";
include 'header.php';
?>

<div class="container">
    <div class="row">
        <form class="p-4 bg-white shadow rounded-4 mt-3" style="min-width: 300px;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>