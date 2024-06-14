<?php require '../api/web.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Login</title>
</head>
<div class="container">
    <p class="title">Login</p>
    <div class="login">
        <label for="username">
            <p>Usuário</p>
            <input type="text" id="username">
        </label>
        <label for="password">
            <p>Senha</p>
            <input type="password" id="password">
        </label>
        <button onclick="login()">Entrar</button>
    </div>
</div>
<script>
function login() {
    // Obtém os valores do usuário e senha
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // Dados a serem enviados
    var data = {
        usuario: username,
        senha: password
    };

    // Faz a requisição POST para a rota /login
    fetch('http://localhost:8080/live/routes/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        // Verifica se a resposta da requisição foi bem-sucedida
        if (!response.ok) {
            throw new Error('Erro ao fazer login');
        }
        return response.json();
    })
    .then(data => {
        // Exibe a mensagem de sucesso ou qualquer outra ação desejada
       window.location.href = "http://localhost:8080/live/admin/";
    })
    .catch(error => {
        // Exibe o erro caso ocorra algum problema
        console.error('Erro:', error);
        alert('Erro ao fazer login');
    });
}
</script>
</html>