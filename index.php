<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Checker | Sites</title>
    <link rel="stylesheet" href="./src/css/style.css">
</head>

<body>

    <main class="center">
        <header class="header">
            <a href="./index.html">
                <h1 class="logo-name">Site Checker</h1>
            </a>
        </header>
        <section>
            <h2 class="section-title">Sites</h2>
            <div class="table">
                <div class="row">
                    <p class="site-name">Meu Portfólio <span class="site-url">https://www.fransuelton.dev</span></p>
                    <?php echo checkWebSite('https://www.fransuelton.dev') ?>
                </div>
                <div class="row">
                    <p class="site-name">Google <span class="site-url">https://google.com</span></p>
                    <?php echo checkWebSite('https://google.com') ?>
                </div>
                <div class="row">
                    <p class="site-name">Site Teste <span class="site-url">https://example.test</span></p>
                    <?php echo checkWebSite('https://www.test.test123') ?>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>Site Checker &copy; 2024</p>
    </footer>

    <?php
    function checkWebSite($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return 'offline';
        }

        if (!function_exists('curl_init')) {
            return 'offline';
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
    ?>
</body>

</html>