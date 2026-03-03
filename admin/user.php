<?php
session_start();
// Incluir o arquivo de conexão com o banco
require_once "conexao.php";
require_once "menu.php";
// Variáveis para mensagens
$sucesso = "";
$erro = "";
$editando = NULL;
if (isset($_GET["excluir"])) {
    $id = $_GET["excluir"];
    $sql = "DELETE FROM usuarios WHERE id = '$id'";
    $res = mysqli_query($conexao, $sql);
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $nome  = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $tipo = $_POST["tipo"];
    // Verificar se o email já existe
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0 && $editando !== NULL) {
        $erro = "Este email já está cadastrado.";
    } else {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        if ($id) {
            $sql = "UPDATE usuarios SET 
                    nome = '$nome',
                    email = '$email',
                    WHERE id = $id";
            $sucesso = "Usuário atualizado com sucesso!";
        } else {
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senhaHash')";
            $sucesso = "Usuário cadastrado com sucesso!";
        }
        if (!mysqli_query($conexao, $sql)) {
            $erro = "Erro ao cadastrar usuário.";
        }
    }
}
// Buscar todos os usuários para listar
$sql = "SELECT id, nome, email, criado_em FROM usuarios  ORDER BY id DESC";
$usuarios = mysqli_query($conexao, $sql);
?>
