<?php
error_reporting(0);
session_start();

require_once __DIR__ . '/pdo.php';
require_once __DIR__ . '/funcist.php';

// Handle form submission to add a comment
if (isset($_POST['add'])) {
    save_message();
    header('Location: index.php');
    die;
}

// Handle user logout
if (isset($_GET['do']) && $_GET['do'] == 'exit') {
    unset($_SESSION['user']['name']);
    header('Location: login.php');
    die;
}

// Handle deleting a message
if (isset($_GET['do']) && $_GET['do'] == 'delete') {
    delete_message();
    header('Location: index.php');
    die;
}

// Redirect to edit page if ID is set
if (isset($_GET['id'])) {
    header('Location: edit.php?id=' . $_GET['id']);
    die;
}

// Fetch all messages
$messages = get_messages();
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yorumlar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-fw"></i>&nbsp;
                            <?= htmlspecialchars($_SESSION['user']['name']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="?do=exit"><i class="fas fa-sign-out-alt"></i> Çıkış</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Yorumlar</h2>

        <!-- Comment form -->
        <form class="mb-4" action="" method="post">
            <div class="mb-3">
                <label for="commentInput" class="form-label">Yorumunuzu Yazın:</label>
                <textarea id="commentInput" name="messaj" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" name="add" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Yorum
                Gönder</button>
        </form>

        <!-- Session messages for success or errors -->
        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['errors'];
                unset($_SESSION['errors']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success'];
                unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Display messages -->
        <div id="commentsSection">
            <h4>Yorumlar</h4>
            <ul class="list-group" id="commentsList">
                <?php foreach ($messages as $message): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= htmlspecialchars($message['name']) ?>:</strong>
                            <?= htmlspecialchars($message['message']) ?>
                            <div class="text-muted" style="font-size: 0.9em;">
                                <?= htmlspecialchars($message['created_at']) ?>
                            </div>
                        </div>
                        <div>
                            <a href="?id=<?= $message['id']; ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Düzenle
                            </a>
                            <a href="?do=delete&id=<?= $message['id']; ?>"
                                onclick="return confirm('Silmek istediğinizden emin misiniz?');"
                                class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Sil
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>