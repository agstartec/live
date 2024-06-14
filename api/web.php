<?php
require '../Environment.php';
Environment::load();
$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
$database = $_ENV['DB_DATABASE'];
$result = $conn->query("SELECT * FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'");

if ($result->num_rows == 0) {
    $sql = "CREATE DATABASE $database";
    if ($conn->query($sql) === TRUE) {
        echo "Banco de dados criado com sucesso!";
    } else {
        echo "Erro ao criar banco de dados: " . $conn->error;
    }
} else {
    $conn->close();

    $conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'],$_ENV['DB_DATABASE']);
    $fields = [
        'usuario' => 'VARCHAR(50)',
        'senha' => 'VARCHAR(255)'
    ];
    $clientFields = [
        'nome' => 'VARCHAR(50)',
        'senha' => 'VARCHAR(255)'
        
    ];
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
    $tableExists = $conn->query("SHOW TABLES LIKE 'users'")->num_rows > 0;
    if (!$tableExists) {
        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        foreach ($fields as $fieldName => $fieldType) {
            $sql .= ", $fieldName $fieldType";
        }

        $sql .= ");";

        if ($conn->query($sql) === TRUE) {
            echo "Tabela 'users' criada com sucesso!";
        } else {
            echo "Erro ao criar tabela: " . $conn->error;
        }
    } else {
    }
    $tableExists = $conn->query("SHOW TABLES LIKE 'clients'")->num_rows > 0;
    if (!$tableExists) {
        $sql = "CREATE TABLE clients (
            id INT AUTO_INCREMENT PRIMARY KEY,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        foreach ($clientFields as $fieldName => $fieldType) {
            $sql .= ", $fieldName $fieldType";
        }

        $sql .= ");";

        if ($conn->query($sql) === TRUE) {
            echo "Tabela 'clients' criada com sucesso!";
        } else {
            echo "Erro ao criar tabela: " . $conn->error;
        }
    } else {
    }

}
$conn->close();
?>