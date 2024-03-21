<?php

include('protect.php');

// Inicia a sessão se não estiver iniciada
if (!isset($_SESSION)) {
    session_start();
}

function checkWebSite($url)
{
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return '<p class="status offline">❌ offline</p>';
    }

    if (!function_exists('curl_init')) {
        return '<p class="status offline">❌ offline</p>';
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($response === false || $httpCode >= 400) {
        return '<p class="status offline">❌ offline</p>';
    } else {
        return '<p class="status online">✅ online</p>';
    }
}

// Inicializa a variável $resultado_html se ainda não estiver definida na sessão
if (!isset($_SESSION['resultado_html'])) {
    $_SESSION['resultado_html'] = '';
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $site = $_GET['site'];
    $status = checkWebSite($site);

    // Concatena o HTML para exibir os resultados da pesquisa
    $_SESSION['resultado_html'] .= "<div class='row'>";
    $_SESSION['resultado_html'] .= "<span class='site-url'>$site</span>";
    $_SESSION['resultado_html'] .= checkWebSite($site);
    $_SESSION['resultado_html'] .= "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Checker | Sites</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>

    <main class="center">
        <header class="header">
            <a href="../../index.html">
                <img src="../images/site-checker-logo.png" alt="">
            </a>

            <p>Bem vindo ao Site Checker, <?php echo $_SESSION['nome'];  ?></p>

            <a href="./logout.php">Sair</a>
        </header>

        <form method="get" class="form">
            <input type="text" name="site" id="site" placeholder="Digite a URL do site (ex: https://www.example.com)" class="url-input">
            <button type="submit" class="search-button">Pesquisar</button>

        </form>

        <section>
            <h2 class="section-title">Suas Pesquisas</h2>
            <div class="table">
                <?php echo isset($_SESSION['resultado_html']) ? $_SESSION['resultado_html'] : ''; ?>
            </div>
        </section>

        <section>
            <h2 class="section-title">Principais sites</h2>
            <div class="table">
                <div class="row">
                    <p class="site-name">Facebook <span class="site-url">https://www.facebook.com/</span></p>
                    <?php echo checkWebSite('https://www.facebook.com/') ?>
                </div>
                <div class="row">
                    <p class="site-name">Google <span class="site-url">https://google.com</span></p>
                    <?php echo checkWebSite('https://google.com') ?>
                </div>
                <div class="row">
                    <p class="site-name"><?php echo htmlspecialchars('<p>site</p>'); ?> <span class="site-url">http://localhost:8000</span></p>
                    <?php echo checkWebSite('http://localhost:8000') ?>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>Site Checker &copy; 2024</p>
    </footer>
</body>

</html>
