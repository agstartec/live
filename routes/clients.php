<?php
require '../Environment.php';
Environment::load();
$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'],$_ENV['DB_DATABASE']);
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM clients");
     if ($result->num_rows > 0) {
        $clients = [];

        // Fetch all clients into an array
        while($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($clients);
           
     } else {
        http_response_code(404);
        echo json_encode(['mensagem' => 'Nenhum cliente ativo']);
    }
} else {
    http_response_code(405);
    echo json_encode(['mensagem' => 'Método não permitido']);
}