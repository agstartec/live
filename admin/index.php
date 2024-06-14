<?php session_start();

// Verifica se há uma sessão ativa
    if (isset($_SESSION['usuario'])) {
        // Se houver uma sessão ativa, inclui o arquivo do dashboard
        include './panel.php';
    } else {
        // Se não houver uma sessão ativa, renderiza o formulário de login
        include './login.php';
    }