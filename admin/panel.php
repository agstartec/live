<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/admin.css">
    <title>Admin</title>
</head>
<body>
    <section class="content">
        <div class="navbar">
            <div class="config">
                <h2>Gerador de senha</h2>
                <button onclick="OpenModalGerarSenha()">GERAR NOVA SENHA</button>
            </div>
            <div class="list">
                <div class="lista-content">
                    <div class="lista-content-item">
                       
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="ModalCadastroCliente">
        <div>
        <h2>Cadastrar</h2>
        <label for="">
            <p>Cliente</p>
            <input type="text" name="nome" id="nome">
        </label>
        <button onclick="CadastrarCliente()">CADASTRAR</button>
        </div>
    </section>
    <script>
        function DeleteCliente(id){
            fetch('http://localhost:8080/live/routes/deletarCliente.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body:JSON.stringify({
                    'id':id
                })
            }).then(response => response.json())
            .then((response)=>{
                console.log(response);
                window.location.href = "/live/admin/"
            })   
        }
        function OpenModalGerarSenha(){
            document.getElementById('ModalCadastroCliente').style.display = "flex"
        }
        function CadastrarCliente(){
            fetch('http://localhost:8080/live/routes/cadastrarClient.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body:JSON.stringify({
                    'nome':document.getElementById('nome').value
                })
            }).then(response => response.json())
            .then((response)=>{
                console.log(response);
                window.location.href = "/live/admin/"
            })
        }
        function GetClients(){
            fetch('http://localhost:8080/live/routes/clients.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                // Verifica se a resposta da requisição foi bem-sucedida
                if (!response.ok) {
                   document.querySelector('.lista-content-item').innerHTML = 'Nenhum cliente Ativo'
                }
                return response.json();
            })
            .then(data => {
               console.log(data)
               let listagem = document.querySelector(".lista-content-item")
               if (listagem.innerHTML == '') {
                    listagem.innerHTML = ` <div>
                            <p>Cliente</p>
                            <p>Senha</p>
                            <p>Opções</p>
                        </div>`
               }                       
               data.forEach(element => {
                    listagem.innerHTML += `<div>
                            <input type="hidden" name="id" value="${element.id}">
                            <p>${element.nome}</p>
                            <p>${element.senha}</p>
                            <p><button onclick="DeleteCliente(${element.id})" class="delete-btn">DELETAR</button></p>
                        </div>`
               });
               
            })
            .catch(error => {
                console.error('Erro:', error);  
                //alert('Erro ao fazer login');
            });
        }
        GetClients();
    </script>
</body>
</html>