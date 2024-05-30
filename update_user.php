<?php
header("Content-Type: application/json");
include 'db_config.php';


if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['tglLahir'])) {
    die(json_encode(['success' => false, "message" => "Invalid input"]));
}

$id = $koneksi->real_escape_string($_POST['id']);
$name = $koneksi->real_escape_string($_POST['name']);
$email = $koneksi->real_escape_string($_POST['email']);
$tglLahir = $koneksi->real_escape_string($_POST['tglLahir']);

if(!isset($_FILES['photo'])){
    $sql = "UPDATE users SET name='$name', email='$email', tglLahir='$tglLahir' WHERE id=$id";
    if ($koneksi->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => 'User updated successfully']);
    } else {
        echo json_encode(['success' => false, "message" => $koneksi->error]);
    }
    $koneksi->close();
    return;
} else {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["photo"]["name"]);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
        $filePath = $koneksi->real_escape_string($targetFile);

        $sql = "UPDATE users SET name='$name', email='$email', tglLahir='$tglLahir', photo_path = '$filePath' WHERE id=$id";

        if ($koneksi->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => 'User updated successfully']);
        } else {
            echo json_encode(['success' => false, "message" => $koneksi->error]);
        }
    }else {
        echo json_encode(['success' => false, "message" => 'Sorry, there was an error uploading your photo."']);
    }
}


$koneksi->close();