<?php

function validation($keys)
{
    $errors = [];
    foreach ($keys as $key) {
        if ($key === 'profile') {
            if (empty($_FILES[$key]['name'])) {
                $errors[$key] = "$key field is required";
            }
        } else {
            if (empty($_POST[$key])) {
                $errors[$key] = "$key field is required";
            }
        }
    }
    return $errors;
}
function getUserDetails($connection)
{
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $sql = "SELECT name, email, profile FROM users WHERE id=?";
        $userQuery = $connection->prepare($sql);
        $userQuery->execute([$id]);
        return $userQuery->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}
function fileUpload($directory, $file)
{
    
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }
    $file = $_FILES['profile'];
    $name = $file['name'];
    $tmpName = $file['tmp_name'];

    $allowedExtensions = ['jpg', 'png', 'jpeg', 'gif'];
    $fileExtension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedExtensions)) {
        $newFileName = uniqid() . '_' . time() . '.' . $fileExtension;
        $destination = $directory . $newFileName;

        if (move_uploaded_file($tmpName, $destination)) {
            return $newFileName;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function auth()
{
    if (isset($_SESSION['id'])) {
        return true;
    }
    return false;
}


function view($view)
{
    header("location: $view");
    exit();
}

function route($path)
{
    return "http://localhost/final-project/" . $path;
}
