<?php
error_reporting(0);
session_start();

require_once __DIR__ . '/pdo.php';
require_once __DIR__ . '/funcist.php';

if (isset($_POST['update'])) {
    update_message();
    header('Location:index.php');
}

if (isset($_GET['id'])) {
    $message = edit_message();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php
        echo $_SESSION['errors'];
        unset($_SESSION['errors']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php
        echo $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Yorumu Redakte Et</h2> <!-- Başlık ortalanmış ve alttaki boşluk eklenmiş -->
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <!-- Form oluşturuluyor -->
                        <form action="" method="POST">
                            <div class="mb-3">

                                <textarea class="form-control" name="commentText" id="commentText"
                                    rows="4"><?= $message['message'] ?></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <!-- Butona ikon ekleniyor ve stil düzenlemesi yapılıyor -->
                                <button type="submit" class="btn btn-success btn-lg btn-block" name="update"
                                    id="saveBtn">
                                    <i class="fas fa-save me-2"></i> Redakte Et <!-- İkon ve metin -->
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>