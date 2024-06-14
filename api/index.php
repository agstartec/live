<?php

// Carrega o arquivo de rota
require_once '../routes/login.php';

// Obtém a URI da requisição
$requestUri = $_SERVER['REQUEST_URI'];

// Define a rota para a URI recebida
switch ($requestUri) {
    case '/login':
        //login();
        break;
    default:
        http_response_code(404);
        echo 'Rota não encontrada';
        break;
}

// Função de login
