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
                    <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                        <div class="card shadow-sm border-0 rounded-4">
                        
                            <img src="no_image.png" class="card-img-top rounded-top-4 img-fluid w-50 mx-auto d-block" alt="Post Image">

                            <div class="card-body">
                                <h2 class="card-title mb-3 text-dark">' . $particular_content["title"] . '</h2>
                                <p class="card-text text-secondary fs-6" style="text-align: justify;">
                                ' . $particular_content["content"] . '
                                </p>

                                <div class="d-flex justify-content-around align-items-center ">
                                    <a class="btn btn-warning fw-bold" href="edit.php?id=' . $particular_content["id"] . '" role="button">Edit</a>
                                    <a class="btn btn-danger fw-bold" href="delete.php?id=' . $particular_content["id"] . '" role="button">Delete</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
                </div>
            ';
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>