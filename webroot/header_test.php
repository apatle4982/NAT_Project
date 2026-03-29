<?php
/* header('Content-Type: application/json');

// Print all headers
$headers = getallheaders();

print_r($headers);exit;
echo json_encode([
    'received_headers' => $headers,
    'authorization' => $headers['Authorization'] ?? '(not received)',
]); */

header('Content-Type: application/json');
echo json_encode([
    'all_headers' => getallheaders(),
    'authorization_header' => $_SERVER['HTTP_AUTHORIZATION'] ?? '(not set)',
    'env_auth' => getenv('HTTP_AUTHORIZATION'),
], JSON_PRETTY_PRINT);