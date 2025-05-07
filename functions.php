<?php
require_once("connection.php");
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//retrieve data
function get_all_data()
{
    try {
        global $conn;
        $result = mysqli_query($conn, "SELECT * FROM posts");

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="col-12 pt-5"><h1>All Posts</h2></div>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                    <div class="col-md-4">
                        <a class="text-secondary text-decoration-none" href="show.php?id=' . $row["id"] . '">
                            <div class="card mb-4 shadow">
                                <img src="./no_image.png" class="card-img-top" alt="no image available">
                                    <div class="card-body">
                                        <h4 class="text-secondary">' . $row["title"] . '</h4>
                                        <p class="card-text">' . htmlspecialchars_decode(substr($row["content"], 0, 45)) . '...</p>
                                    </div>
                            </div>
                        </a>
                    </div>
            ';
            }
        } else {
            echo '
            <div class="mt-3 d-flex flex-column justify-content-center align-items-center bg-light text-center p-4 border rounded shadow-sm w-100" style="min-height: 200px;">
                <h4 class="text-dark mb-2">No Posts Available</h4>
                <p class="text-muted mb-0">There’s nothing to show right now. Please check back later or try refreshing the page.</p>
            </div>
        ';
        }
    } catch (mysqli_sql_exception $ex) {
        $error_message = '[' . date("Y-m-d H:i:s") . ']' . ' SQL Error: ' . $ex->getMessage() . PHP_EOL;
        error_log($error_message, 3, "error.txt");
        echo '
            <script>
                window.location.href = "error.php";
            </script>
        ';
    }
}

//insert post
try {
    if (isset($_POST["title"]) && isset($_POST["content"])) {
        if (!empty($_POST["title"]) && !empty($_POST["content"])) {
            $title = htmlspecialchars($_POST["title"]);
            $content = htmlspecialchars($_POST["content"]);

            $insert_query = mysqli_query($conn, "INSERT INTO posts(title, content) VALUES('$title', '$content')");

            if ($insert_query) {
                echo '
                <script>
                    alert("Data inserted");
                    window.location.href = "index.php";
                </script>
            ';
            } else {
                echo '
                <div class="col-12 col-md-8 col-lg-6 mx-auto mt-4">
                    <div class="alert alert-danger d-flex align-items-center shadow-sm rounded-3" role="alert">
                        <i class="bi bi-x-circle-fill me-2 fs-4"></i>
                        <div class="fs-6">
                        Data was <strong>not inserted</strong>. Please try again.
                        </div>
                    </div>
                </div>
            ';
            }
        } else {
            echo '
            <div class="col-12 col-md-8 col-lg-6 mx-auto mt-4">
                <div class="alert alert-dismissible fade show alert-warning d-flex align-items-center shadow-sm rounded-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                    <div class="fs-6">
                    <strong>Warning:</strong> Please fill out all the required fields before submitting.
                    <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        ';
        }
    }
} catch (mysqli_sql_exception $ex) {
    $error_message = '[' . date("Y-m-d H:i:s") . ']' . ' SQL Error: ' . $ex->getMessage() . PHP_EOL;
    error_log($error_message, 3, "error.txt");
    echo '
            <script>
                window.location.href = "error.php";
            </script>
        ';
}

//show post
function show_data()
{
    try {
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            global $conn;
            $id = $_GET["id"];

            $update_result = mysqli_query($conn, "SELECT * FROM posts WHERE id = $id");

            if (mysqli_num_rows($update_result) == 1) {
                $particular_content = mysqli_fetch_assoc($update_result);
                return $particular_content;
            } else {
                echo '
                <div class="container py-5">
                    <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">

                        <!-- Error Message Alert -->
                        <div class="alert alert-warning text-center p-4 shadow-sm rounded-4" role="alert">
                        <h3 class="alert-heading text-danger mb-3">
                            <i class="bi bi-exclamation-triangle-fill"></i> Oops! Post Not Found
                        </h3>
                        <p class="fs-5 text-muted">
                            The post you are looking for does not exist or has been removed. Please check the URL or return to the <a href="index.php" class="text-primary">posts list</a>.
                        </p>
                        </div>

                    </div>
                    </div>
                </div>
            ';
            }
        }
    } catch (mysqli_sql_exception $ex) {
        $error_message = '[' . date("Y-m-d H:i:s") . ']' . ' SQL Error: ' . $ex->getMessage() . PHP_EOL;
        error_log($error_message, 3, "error.txt");
        echo '
            <script>
                window.location.href = "error.php";
            </script>
        ';
    }
}


//delete post
function delete_data()
{
    try {
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            global $conn;
            $id = $_GET["id"];
            $result = mysqli_query($conn, "DELETE FROM posts WHERE id = $id");

            if (mysqli_affected_rows($conn) == 1) {
                echo '
                <script>
                    alert("Data deleted");
                    window.location.href = "index.php"; 
                </script>
            ';
            } else {
                echo '
                <div class="container py-5">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8 col-lg-6">

                            <!-- Error Message Alert -->
                            <div class="alert alert-warning text-center p-4 shadow-sm rounded-4" role="alert">
                                <h3 class="alert-heading text-danger mb-3">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Oops! Post Not Found
                                </h3>
                                <p class="fs-5 text-muted">
                                    The post you are looking for does not exist or has been removed. Please check the URL or return to the <a href="index.php" class="text-primary">posts list</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            ';
            }
        }
    } catch (mysqli_sql_exception $ex) {
        $error_message = '[' . date("Y-m-d H:i:s") . ']' . ' SQL Error: ' . $ex->getMessage() . PHP_EOL;
        error_log($error_message, 3, "error.txt");
        echo '
            <script>
                window.location.href = "error.php";
            </script>
        ';
    }
}


//update post
try {
    if (isset($_POST["update_title"]) && isset($_POST["update_content"])) {
        if (!empty($_POST["update_title"]) && !empty($_POST["update_content"])) {
            $title = htmlspecialchars($_POST["update_title"]);
            $content = htmlspecialchars($_POST["update_content"]);
            $id = $_GET["id"];

            $update_query = mysqli_query($conn, "UPDATE posts SET title='$title', content='$content' WHERE id=$id");

            if (mysqli_affected_rows($conn) == 1) {
                echo '
                <script>
                    alert("Data updated");
                    window.location.href = "index.php"; 
                </script>
            ';
            } else {
                echo '
                <div class="col-12 col-md-8 col-lg-6 mx-auto mt-4">
                    <div class="alert alert-danger d-flex align-items-center shadow-sm rounded-3" role="alert">
                        <i class="bi bi-x-circle-fill me-2 fs-4"></i>
                        <div class="fs-6">
                        Data was <strong>not inserted</strong>. Please try again.
                        </div>
                    </div>
                </div>
            ';
            }
        } else {
            echo '
            <div class="col-12 col-md-8 col-lg-6 mx-auto mt-4">
                <div class="alert alert-dismissible fade show alert-warning d-flex align-items-center shadow-sm rounded-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                    <div class="fs-6">
                    <strong>Warning:</strong> Please fill out all the required fields before submitting.
                    <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        ';
        }
    }
} catch (mysqli_sql_exception $ex) {
    $error_message = '[' . date("Y-m-d H:i:s") . ']' . ' SQL Error: ' . $ex->getMessage() . PHP_EOL;
    error_log($error_message, 3, "error.txt");
    echo '
            <script>
                window.location.href = "error.php";
            </script>
        ';
}

try {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if (!empty($_POST["username"]) && !empty($_POST["password"])) {

            global $conn;

            $username = $_POST["username"];
            $user_data = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

            if (mysqli_num_rows($user_data) == 1) {
                while ($row = mysqli_fetch_assoc($user_data)) {
                    $hash = $row["password"];
                    if (password_verify($_POST["password"], $hash)) {
                        $_SESSION["user"]["id"] = $row["id"];
                        $_SESSION["user"]["username"] = $row["username"];
                        echo $_SESSION["user"]["id"] . ' ' . $_SESSION["user"]["username"];
                        header("Location: index.php");
                    } else {
                        echo '
                            <div class="container py-5">
                                <div class="row justify-content-center">
                                <div class="col-12 col-md-8 col-lg-6">
                
                                    <!-- Error Message Alert -->
                                    <div class="alert alert-warning text-center p-4 shadow-sm rounded-4" role="alert">
                                        <h3 class="alert-heading text-danger mb-3">
                                            <i class="bi bi-exclamation-triangle-fill"></i> Oops! Wrong password..
                                        </h3>
                                    </div>
                
                                </div>
                                </div>
                            </div>
                        ';
                    }
                }
            } else {
                echo '
                    <div class="container py-5">
                        <div class="row justify-content-center">
                        <div class="col-12 col-md-8 col-lg-6">

                            <!-- Error Message Alert -->
                            <div class="alert alert-warning text-center p-4 shadow-sm rounded-4" role="alert">
                                <h3 class="alert-heading text-danger mb-3">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Oops! User does not exist.
                                </h3>
                            </div>

                        </div>
                        </div>
                    </div>
        ';
            }
        } else {
            echo '
                <div class="col-12 col-md-8 col-lg-6 mx-auto mt-4">
                    <div class="alert alert-dismissible fade show alert-warning d-flex align-items-center shadow-sm rounded-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                        <div class="fs-6">
                        <strong>Warning:</strong> Please fill out all the required fields before submitting.
                        <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
        ';
        }
    }
} catch (mysqli_sql_exception $ex) {
    $error_message = '[' . date("Y-m-d H:i:s") . ']' . ' SQL Error: ' . $ex->getMessage() . PHP_EOL;
    error_log($error_message, 3, "error.txt");
    echo '
            <script>
                window.location.href = "error.php";
            </script>
        ';
}

function log_out(){
    unset($_SESSION["user"]);
}