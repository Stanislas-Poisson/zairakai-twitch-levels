<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Top 50 Users Ranking - <?php echo date('Y-m-d H:i') ?></title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Top 50 Viewers</h1>
        <p><?php echo date('Y-m-d H:i') ?></p>
    </header>

    <main>
        <?php 
        require 'templates/legend.php';
        require 'templates/top3.php';
        require 'templates/top10.php';
        require 'templates/rankings.php';
        ?>
    </main>

    <footer>
        Build avec passion en live <a href="https://twitch.tv/zairakai" target="_blank">Twitch/zairakai</a> - <a href="https://www.linkedin.com/in/stanislasp" target="_blank">Linkedin.com/in/stanislasp</a>
    </footer>
</body>
</html>
