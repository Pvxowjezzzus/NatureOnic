<!doctype html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="/public_html/css/admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"  crossorigin="anonymous">
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

            <a href="/admin">
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
                    <li><a href="/admin/items?cat=meat">Мясо</a></li>
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
            <a href="/admin/support">
                <i class="fas fa-envelope"></i>
                <span>Обратная связь</span>
            </a>
            <a href="/admin/logout">
                <i class="fa fa-fw fa-sign-out"></i>
                <span>Выход</span>
            </a>
        </div>
    <?php endif ?>
        <?= $content ?>
    </div>
    <?php if ($_SESSION['admin'] == 1): ?>
    <script rel='script' src="/public_html/scripts/admin.js"></script>
<?php endif; ?>
</body>

</html>