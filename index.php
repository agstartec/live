<?php session_start();

// Verifica se há uma sessão ativa
    if (isset($_SESSION['senha'])) {
        // Se houver uma sessão ativa, inclui o arquivo do dashboard
        include './payvideo.php';
    } else {
        // Se não houver uma sessão ativa, renderiza o formulário de login
        include './loginUser.php';
    }

