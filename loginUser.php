<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <p class="title">Login</p>
        <div class="login">
            <label for="">
                <p>Senha de acesso</p>
                <input type="password" id="password">
            </label>
            <button onclick="LoginUser()">Entrar</button>
        </div>
        
    </div>
    <script>
        
        function LoginUser(){
            var password = document.getElementById('password').value;

            // Dados a serem enviados
            var data = {
                senha: password
            };
            fetch('http://localhost:8080/live/routes/loginUser.php', {
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
            window.location.href = "http://localhost:8080/live";
            })
            .catch(error => {
                // Exibe o erro caso ocorra algum problema
                console.error('Erro:', error);
                alert('Erro ao fazer login');
            });
        }
    </script>
</body>
</html>