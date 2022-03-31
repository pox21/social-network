<?php

session_start();
define('HOST', 'http://' . $_SERVER['HTTP_HOST']);

const DB_HOST = 'localhost';
const DB_NAME = 'social-network';
const DB_USER = 'root';
const DB_PASS = 'root';

function dbConnect() {

    $pdoOptions = [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    static $connect = null;

    if ($connect === null) {

        try {
            $connect = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS, $pdoOptions);
        } catch (PDOException $e) {
            die($e->getMessage());

        }
    }

    return $connect;
}

function dbQuery($sql, $params = [], $exec = false) {
    if (empty($sql)) return false;

    $query = dbConnect()->prepare($sql);
    $query->execute($params);
    if ($exec) {
        return true;
    }
    return $query;
}

function redirectTo($path) {
    header('Location: /' . $path);
    die;
}

function setFlashMessage($name, $message) {
    $_SESSION[$name] = $message;
    return null;
}

function displayFlashMessage($name) {
    if (isset($_SESSION[$name]) && !empty($_SESSION[$name])) {
        echo $_SESSION[$name];
        unset($_SESSION[$name]);
        return true;
    }

    return null;
}

function getUserByEmail($email) {
    $params = ['email' => $email];
    $sql = "SELECT * FROM `users` WHERE `email` = :email";
    return dbQuery($sql, $params)->fetch();
}

function getUserById($id) {
    $params = ['id' => $id];
    $sql = "SELECT * FROM `users` WHERE `id` = :id";
    return dbQuery($sql, $params)->fetch();
}

function getUserInfoById($id) {
    $params = ['id' => $id];
    $sql = "SELECT * FROM `users_profile` WHERE `user_id` = :id";
    return dbQuery($sql, $params)->fetch();
}

function addUser($email, $pass) {
    $params = [
        'email' => $email,
        'pass' => password_hash($pass, PASSWORD_DEFAULT),
    ];
    $userId = null;
    $sql = "INSERT INTO `users` (`email`, `password`) VALUES (:email, :pass)";

    if (dbQuery($sql, $params, true)) {
        $userId = getUserByEmail($email)["id"];
        $paramsId = [
            "user_id" => $userId,
        ];

        $sqlUserInfo = "INSERT INTO `users_profile` (`user_id`) VALUES (:user_id);";
        $sqlSocials = "INSERT INTO `socials` (`user_id`) VALUES (:user_id);";

        dbQuery($sqlUserInfo, $paramsId, true);
        dbQuery($sqlSocials, $paramsId, true);
    }
    return $userId;
}

function editCredentials($user_id, $email, $pass) {
    $user = getUserByEmail($email);
    if (!empty($user) && $user_id != $user['id'] ) {
        setFlashMessage("emailError", "Такой E-mail уже занят");
        return false;
    }

    $params = [
        'id' => $user_id,
        'email' => $email,
        'pass' => password_hash($pass, PASSWORD_DEFAULT),
    ];
    $sql = "UPDATE `users` SET `email` = :email, `password` = :pass WHERE `users`.`id` = :id;";

    return dbQuery($sql, $params, true);
}

function editUser($user_id, $username = '', $job = '', $phone = '', $addres = '') {
    $params = [
        'user_id' => $user_id,
        'username' => $username,
        'job' => $job,
        'phone' => $phone,
        'address' => $addres,
    ];

    $sql = "UPDATE `users_profile` SET `username` = :username, `job` = :job, `phone` = :phone, `address` = :address  WHERE `users_profile`.`user_id` = :user_id;";

    return dbQuery($sql, $params, true);
}

function addSocialLinks($user_id, $vk = '', $tg = '', $inst = '') {
    $params = [
        'user_id' => $user_id,
        'vk' => $vk,
        'tg' => $tg,
        'inst' => $inst,
    ];

    $sql = "UPDATE `socials` SET `vk` = :vk, `tg` = :tg, `inst` = :inst WHERE `socials`.`user_id` = :user_id;";

    return dbQuery($sql, $params, true);
}

function setStatus($user_id, $status) {
    $params = [
        'user_id' => $user_id,
        'status' => $status,
    ];
    $sql = "UPDATE `users` SET `status` = :status WHERE `users`.`id` = :user_id;";

    return dbQuery($sql, $params, true);;
}

function uploadAvatar($user_id, $image) {
    $params = [
        'user_id' => $user_id,
        'avatar' => $image,
    ];
    $sql = "UPDATE `users` SET `avatar` = :avatar WHERE `users`.`id` = :user_id;";
    dbQuery($sql, $params, true);

    return null;
}

function registerUser($authData) {
    if (empty($authData) ||
        !isset($authData['email']) || empty(trim($authData['email'])) ||
        !isset($authData['pass']) || empty(trim($authData['pass']))) return false;


    $user = getUserByEmail($authData['email']);
    if (!empty($user)) {
        setFlashMessage("errorRegister", "Пользователь " . $authData['email'] . " уже существует");
        return false;
    }

    $userId = addUser(trim($authData['email']), trim($authData['pass']));
    $_SESSION['email'] = $authData['email'];
    setFlashMessage("successRegister", "Пользователь " . $authData['email'] . " успешно зарегистрирован");

    if (isset($authData['username']) && !empty(trim($authData['username'])) ||
        isset($authData['job']) && !empty(trim($authData['job'])) ||
        isset($authData['phone']) && !empty(trim($authData['phone'])) ||
        isset($authData['address']) && !empty(trim($authData['address']))
    ) {
        editUser($userId, trim($authData['username']), trim($authData['job']), trim($authData['phone']), trim($authData['address']));
    }

    if (isset($authData['vk']) && !empty(trim($authData['vk'])) ||
        isset($authData['tg']) && !empty(trim($authData['tg'])) ||
        isset($authData['inst']) && !empty(trim($authData['inst']))
    ) {
        addSocialLinks($userId, trim($authData['vk']), trim($authData['tg']), trim($authData['inst']));
    }

    return $userId;
}

function login($authData) {

    if (empty($authData) || !isset($authData['email']) || empty(trim($authData['email'])) || !isset($authData['pass']) || empty(trim($authData['pass']))) {
        setFlashMessage("errorLogin", "заполните все поля");
        return false;
    }

    $user = getUserByEmail($authData['email']);

    if (empty($user) || !password_verify($authData['pass'], $user['password'])) {
        setFlashMessage("errorLogin", "Не верный логин или пароль");
        return false;
    }

    $_SESSION['login'] = $user['email'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['id'] = $user['id'];
    setStatus($user['id'], 'online');
    return true;
}

function loggedIn() {
    return isset($_SESSION['login']) && !empty($_SESSION['login']);
}

function isAdmin() {
    if (isset($_SESSION['role']) && !empty($_SESSION['role'])) {
        return $_SESSION['role'] === "admin";
    }
    return false;
}

function getUsers() {
    $sql = "SELECT `users`.`email`, `users`.`avatar`, `users`.`status`, `users_profile` . *  FROM `users` INNER JOIN `users_profile` ON `users` . `id` = `users_profile` . `user_id`";
    return dbQuery($sql)->fetchAll();
}


function phoneFormat($phone) {
    $phone = trim($phone);
    if (!$phone) return '';

    $number = trim(preg_replace('#[^0-9]#s', '', $phone));
    $length = strlen($number);
    if($length == 7) {
        $regex = '/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/';
        $replace = '$1-$2';
    } elseif($length == 10) {
        $regex = '/([0-9]{3})([0-9]{3})([0-9]{4})/';
        $replace = '$1-$2-$3';
    } elseif($length == 11) {
        $regex = '/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/';
        $replace = '$1 $2-$3-$4';
    } else {
        return $phone;
    }

    $formatted = preg_replace($regex, $replace, $number);

    return $formatted;
}

//function upload

//function uploadImg($imagePath) {
//    $params = [
//        'image' => $imagePath,
//    ];
//    $sql = "INSERT INTO `images` (`image`) VALUES (:image);";
//    return dbQuery($sql, $params, true);
//}
//
//function getImages() {
//    $sql = "SELECT * FROM `images`";
//    return dbQuery($sql)->fetchAll();
//}
//
//function removeImages($imageId) {
//    $params = [
//        'id' => $imageId,
//    ];
//    $sql = "DELETE FROM `images` WHERE `images` . `id` = :id";
//    dbQuery($sql, $params, true);
//    return true;
//}