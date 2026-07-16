<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['filename'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'No filename provided']);
    exit;
}

$filename = basename($input['filename']);
$filepath = __DIR__ . '/file/' . $filename;

if (file_exists($filepath)) {
    unlink($filepath);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'File not found']);
}
?>
