<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Ulvis\EncurtadorUrl;

// CORS headers para aceitar requisições de outro domínio/porta (como do Vue)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Preflight request (CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Apenas permitir método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Retornar erro de Método não permitido
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

// Pega o JSON do corpo da requisição do frontend
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['url']) || empty($input['url'])) {
    http_response_code(400);
    echo json_encode(['error' => 'URL não informada']);
    exit;
}

try {
    // Chama a função para encurtar a url
    $short = EncurtadorUrl::encurtar($input['url']);

    echo json_encode([
        'original' => $input['url'],
        'short' => $short
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao encurtar URL']);
}