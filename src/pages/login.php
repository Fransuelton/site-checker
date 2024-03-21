<?php
include('connection.php');

if (isset($_POST['email']) || isset($_POST['senha'])) {

    if (strlen($_POST['email']) == 0) {
        echo "Preencha seu e-mail";
    } else if (strlen($_POST['senha']) == 0) {
        echo "Preencha sua senha";
    } else {

        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {

            $usuario = $sql_query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: dashboard.php");
        } else {
            echo "Falha ao logar! E-mail ou senha incorretos";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Checker | Login</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <main class="center">
        <header class="header">
            <a href="../../index.html">
                <img src="../images/site-checker-logo.png" alt="">
            </a>
        </header>
        <form action="" method="POST" class="form">
            <h1>Acesse sua conta</h1>
            <div>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="insira seu email">
            </div>
            <div>
                <label for="password">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Insira sua senha">
            </div>

            <button type="submit" class="login-btn">Entrar</button>
        </form>
    </main>
    <footer class="footer">
        <p>Site Checker &copy; 2024</p>
    </footer>
</body>

</html>