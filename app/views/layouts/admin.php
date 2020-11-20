<!doctype html>
<html lang="ru">
<head>
    <meta content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Security-Policy: font-src" content="default-src 'none'; frame-src 'none'; base-uri 'none'; script-src-elem 'self'; style-src-elem 'self'; img-src 'self'">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="/public_html/css/admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title><?= $title ?></title>
</head>
<body>
    <header class="admin-header">
        <h2>Панель Администратора</h2>
        <a class="back-btn" href="/">Вернуться на главную</a>
    </header>
    <div class="container">
    <?php if($_SESSION['admin'] == 1): ?>
        <div class="sidebar">
            <p>Приветствую, <?=$_SESSION['login']?></p>

            <a href="/admin-panel">
                <i class="fa fa-fw fa-home"></i>
                <span>Главная</span>
            </a>
            <div class="drop-wrap">
                <div class="drop-btn">
                    <i class="fa fa-fw fa-list"></i>
                    <span>Продукты</span>
                </div>
                <ul class="drop-menu">
                    <li><a href="/admin/items?cat=fruits">Фрукты</a></li>
                    <li><a href="/admin/items?cat=vegies">Овощи</a></li>
                    <li><a href="/admin/items?cat=nuts">Орехи</a></li>
                    <li><a href="/admin/items?cat=berries">Ягоды</a></li>
                    <li><a href="/admin/items?cat=shrooms">Грибы</a></li>
                </ul>
            </div>
            <a href="/admin/items/add">
                <i class="fa fa-fw fa-plus"></i>
                <span>Добавить продукт</span>
            </a>
            <a href="/admin/items/types/add">
                <i class="fa fa-fw fa-plus"></i>
                <span>Добавить фильтр</span>
            </a>
            <a href="/admin/logout">
                <i class="fa fa-fw fa-sign-out"></i>
                <span>Выход</span>
            </a>
        </div>
    <?php endif ?>
        <?= $content ?>
    </div>
</body>
<?php if ($_SESSION['admin'] == 1): ?>
    <script type="text/javascript" src="/public_html/scripts/admin.js"></script>
<?php endif; ?>
</html>