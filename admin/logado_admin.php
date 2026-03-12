<?php
// admin/logado_admin.php
session_start();

// Verifica se está logado E se é admin
if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_tipo"] !== "admin") {
    header("Location: ../login.php");
    exit;
}
require_once "../conexao.php";
?>