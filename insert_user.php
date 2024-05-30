<?php
header("Content-Type: application/json");
include 'db_config.php';

if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_FILES['photo']) || !isset($_POST['tglLahir'])) {
    die(json_encode(["success" => false, "message" => "Invalid input"]));
}

$name = $koneksi->real_escape_string($_POST['name']);
$email = $koneksi->real_escape_string($_POST['email']);
$tglLahir = $koneksi->real_escape_string($_POST['tglLahir']);

$targetDir = "uploads/";
$targetFile = $targetDir . basename($_FILES["photo"]["name"]);

if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {

    $filePath = $koneksi->real_escape_string($targetFile);
    $sql = "INSERT INTO users (name, email, photo_path, tglLahir) VALUES ('$name', '$email', '$filePath', '$tglLahir')";
    
    if ($koneksi->query($sql) === TRUE) {
        echo json_encode(["success" => true, 'message' => 'User added successfully']);
    } else {
        echo json_encode(['success' => false, "message" => $koneksi->error]);
    }
} else {
    echo json_encode(['success' => false, "message" => "Sorry, there was an error uploading your file."]);
}

$koneksi->close();
?>
