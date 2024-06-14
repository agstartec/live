<?php
require '../Environment.php';
Environment::load();
$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'],$_ENV['DB_DATABASE']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do corpo da requisição POST
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    // Verifica se os dados necessários foram fornecidos
    if (isset($data['nome'])) {
        // Protege contra SQL injection
        $nome = $conn->real_escape_string($data['nome']);
        $comprimentoDaSenha = 8; // você pode alterar o valor conforme necessário
        $senha = gerarSenhaAleatoria($comprimentoDaSenha);

        // Insere o novo cliente na tabela
        $sql = "INSERT INTO clients (nome, senha) VALUES ('$nome', '$senha')";

        if ($conn->query($sql) === TRUE) {
            http_response_code(201);
            echo json_encode(['mensagem' => 'Cliente cadastrado com sucesso']);
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
    // Defina os caracteres que você deseja incluir na senha
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    // Embaralha os caracteres
    $caracteresEmbaralhados = str_shuffle($caracteres);
    
    // Gera a senha aleatória
    $senha = substr($caracteresEmbaralhados, 0, $comprimento);
    
    return $senha;
}