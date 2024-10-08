<?php

function debug(array $data): void
{
    echo '<pre>' . print_r($data, true) . '</pre>';
}
function registers(): bool
{
    global $pdo;

    $login = !empty($_POST['email']) ? trim($_POST['email']) : '';
    $pass = !empty($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($login) || empty($pass)) {
        $_SESSION['errors'] = 'İstifadəçi adı ve Sifre bos ola bilmez!';
        return false;
    }

    $res = $pdo->prepare("SELECT COUNT(*) FROM users WHERE login = ?");


    $res->execute([$login]);

    if ($res->fetchColumn()) {
        $_SESSION['errors'] = 'İstifadəçi adı Sistemde Movcudur!';
        return false;
    }


    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $res = $pdo->prepare("INSERT INTO  users (login,pass) VALUES (?,?)");
    if ($res->execute([$login, $pass])) {
        $_SESSION["success"] = 'İstifadəçi əlavə edildi';
        return true;
    } else {
        $_SESSION["errors"] = 'Xəta baş verdi!';
        return false;
    }
}

function logins(): bool
{
    global $pdo;

    $login = !empty($_POST['username']) ? trim($_POST['username']) : '';
    $pass = !empty($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($login) || empty($pass)) {
        $_SESSION['errors'] = 'İstifadəçi adı və ya şifrə boş ola bilməz!';
        return false;
    }

    $res = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $res->execute([$login]);
    $user = $res->fetch();
    if (!$user) {
        $_SESSION["errors"] = 'İstifadəçi adı və ya şifrə yanlışdır!';
        return false;
    }

    if (!password_verify($pass, $user['pass'])) {
        $_SESSION["errors"] = 'İstifadəçi adı və ya şifrə yanlışdır!';
        return false;
    } else {
        $_SESSION["user"]["name"] = $user['login'];
        $_SESSION["user"]["id"] = $user['id'];
        return true;
    }
}
function save_message(): bool
{

    global $pdo;

    $message = !empty($_POST['messaj']) ? trim($_POST['messaj']) : '';

    if (empty($message)) {
        $_SESSION['errors'] = 'Mesaj boş ola bilməz!';
        return false;
    }

    $res = $pdo->prepare("INSERT INTO messages (name,message) VALUES (?,?)");
    if ($res->execute([$_SESSION["user"]["name"], $message])) {
        $_SESSION['success'] = 'Mesaj əlavə edildi';
        return true;
    } else {
        $_SESSION['errors'] = 'Xəta baş verdi!';
        return false;
    }
}

function get_messages(): array
{
    global $pdo;
    $res = $pdo->query("SELECT * FROM messages ORDER BY id DESC");
    return $res->fetchAll();
}

function delete_message(): bool
{
    global $pdo;
    $messageId = $_GET['id'];
    $res = $pdo->prepare("DELETE FROM messages WHERE id= ?");

    if ($res->execute([$messageId])) {
        $_SESSION['success'] = 'Mesaj Silindi';
        return true;
    } else {
        $_SESSION['errors'] = 'Xeta Bas Verdi';
        return false;
    }

}

function edit_message(): array
{
    global $pdo;
    $messageId = $_GET['id'];

    $res = $pdo->prepare("SELECT * FROM messages WHERE id = ?");
    if ($res->execute([$messageId])) {
        return $res->fetch();



    } else {
        return [];

    }
}

function update_message(): bool
{

    global $pdo;
    $message = !empty($_POST['commentText']) ? trim($_POST['commentText']) : '';
    $messageId = $_GET['id'];

    if (empty($message)) {
        $_SESSION['errors'] = 'Mesaj boş ola bilməz!';
        return false;
    }

    $res = $pdo->prepare("UPDATE messages SET message = ? WHERE id = ?");

    if ($res->execute([$message, $messageId])) {
        $_SESSION['success'] = 'Redakte Edildi!';

        return true;
    } else {
        $_SESSION['errors'] = 'Redakte Edildi!';

        return false;
    }



}

