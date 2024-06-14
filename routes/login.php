<?php
require '../Environment.php';
Environment::load();
$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'],$_ENV['DB_DATABASE']);
// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do corpo da requisição POST
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true); // Decodifica os dados JSON em um array associativo

    // Verifica se os dados de login foram fornecidos
    if (isset($data['usuario']) && isset($data['senha'])) {
        // Aqui você pode realizar a lógica de autenticação
        // Protege contra SQL injection
        $usuario = $conn->real_escape_string($data['usuario']);
        $senha = $data['senha']; // Não precisa escapar pois será usada na verificação após o fetch

        // Consulta para verificar se o usuário existe
        $result = $conn->query("SELECT * FROM users WHERE usuario='$usuario'");
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verifica se a senha está correta (substitua por password_verify() se a senha estiver hashada)
            if ($senha == $user['senha']) { // Se estiver usando hashes, use: password_verify($senha, $user['senha'])
                // Inicia a sessão
                session_start();
                // Armazena informações do usuário na sessão
                $_SESSION['usuario'] = $usuario;

                // Por enquanto, vamos apenas retornar os dados recebidos para fins de demonstração
                $responseData = [
                    'usuario' => $usuario,
                    'mensagem' => 'Login bem-sucedido' // Adicione uma mensagem de acordo com o resultado da autenticação
                ];

                // Retorna os dados como JSON
                header('Content-Type: application/json');
                echo json_encode($responseData);
            } else {
                http_response_code(401);
                echo json_encode(['mensagem' => 'Senha incorreta']);
            }
        } else {
            http_response_code(404);
            echo json_encode(['mensagem' => 'Usuário não encontrado']);
        }
       
    } else {
        // Se os dados de login não foram fornecidos, retorna um erro
        http_response_code(400);
        echo json_encode(['mensagem' => 'Dados de login não fornecidos']);
    }
} else {
    // Se a requisição não for do tipo POST, retorna um erro
    http_response_code(405);
    echo json_encode(['mensagem' => 'Método não permitido']);
}
