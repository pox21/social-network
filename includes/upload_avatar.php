<?php

include_once "functions.php";
$uploadDir = '../img/demo/avatars/';

function fileRename($name) {
    return basename($name);
}

function uplodFile($fileTmpName, $uploadDir, $fileName, $id) {
    $name = fileRename($fileName);
    if(move_uploaded_file($fileTmpName, $uploadDir . $name)) {
        uploadAvatar($id, str_replace('../', '', $uploadDir . $name));
        return true;
    }

    return  false;
}

function sizeValid($size) {
    if ($size > 219000) {
        setFlashMessage('fileError', 'Размер файла не долже превышать 220кб');
        redirectTo('media.php?id=' . $_POST['id']);
    }

    return true;
}

if (isset($_FILES['avatar']['error'])) {
    if (sizeValid($_FILES['avatar']['size'])) {
        $tmpName = $_FILES['avatar']['tmp_name'];
        $nameFile = $_FILES['avatar']['name'];
        uplodFile($tmpName, $uploadDir, $nameFile, $_POST['id']);
        unlink("../" . $_POST['old_avatar']);
        setFlashMessage('updateData', 'Аватарка успешно обновлена');
    }
}

redirectTo('users.php');