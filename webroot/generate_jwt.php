<?php
require '../vendor/autoload.php';

use Firebase\JWT\JWT;

// 🔐 Replace with your secret key used in CakePHP controller
$secretKey = 'NLPS59003PYO'; // keep it same as used in UsersController

// 📄 Token payload
$payload = [
    'iss' => 'nat.tiuconsulting.us',       // issuer: your app domain or name
    'sub' => 'api_user_123',      // subject: custom user ID or identifier
    'iat' => time(),              // issued at
    'exp' => time() + 36000        // expires in 10 hour
];

// 🔐 Generate JWT
$jwt = JWT::encode($payload, $secretKey, 'HS256');

echo "Generated JWT Token:\n";
echo $jwt . "\n";
