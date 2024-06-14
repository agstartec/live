<?php
require '../Environment.php';
Environment::load();
$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'],$_ENV['DB_DATABASE']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    if (isset($data['id'])) {
        $id = $conn->real_escape_string($data['id']);
        $comprimentoDaSenha = 8;
        $senha = gerarSenhaAleatoria($comprimentoDaSenha);

        // Insere o novo cliente na tabela
        $sql = "DELETE FROM clients WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            http_response_code(201);
            echo json_encode(['mensagem' => 'Deletado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro ao cadastrar cliente: ' . $conn->error]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['mensagem' => 'Dados do cliente não fornecidos']);
    }
}

function gerarSenhaAleatoria($comprimento = 12) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $caracteresEmbaralhados = str_shuffle($caracteres);
    $senha = substr($caracteresEmbaralhados, 0, $comprimento);  
    return $senha;
}