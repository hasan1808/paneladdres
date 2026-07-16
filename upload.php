<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$uploadDir = __DIR__ . '/file/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (!isset($_FILES['ovpn_file'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'No file uploaded']);
    exit;
}

$file = $_FILES['ovpn_file'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Upload error: ' . $file['error']]);
    exit;
}

$originalName = $file['name'];

if (pathinfo($originalName, PATHINFO_EXTENSION) !== 'ovpn') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Only .ovpn files are allowed']);
    exit;
}

$destination = $uploadDir . $originalName;

if (move_uploaded_file($file['tmp_name'], $destination)) {
    echo json_encode(['success' => true, 'filename' => $originalName]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to save file']);
}
?>
