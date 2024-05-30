<?php
header("Content-Type: application/json");
include 'db_config.php';

if (!isset($_POST['id'])) {
    die(json_encode(['success' => false, "message" => "Invalid input"]));
}

$id = intval(($koneksi->real_escape_string($_POST['id'])));

$sql = "DELETE FROM users WHERE id= '" . $id . "'";
if ($koneksi->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => 'User deleted successfully']);
} else {
    echo json_encode(['success' => false, "message" => $koneksi->error]);
}
$koneksi->close();
?>