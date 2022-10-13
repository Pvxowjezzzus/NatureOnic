<!doctype html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="/public_html/css/admin-style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
    <title><?= $title ?></title>
</head>
<body>
        <nav class="admin-navbar navbar navbar-expand-lg navbar-dark  bg_green">
            <a class="navbar-brand" href="/">
                    <img src="/public_html/img/white-logo.png" width="150" height="50"  class="d-inline-block align-top" alt="">
            </a>
            <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarCollapse"
                    aria-controls="navbarCollapse"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto sidenav" id="navAccordion">
	                <?php if($_SESSION['admin'] == 1): ?>
                    <li class="nav-item ">
                        <a class="nav-link" href="/admin">
                            <i class="fas fa-home"></i>
                            <span>Главная</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/items">
                            <i class="fas fa-list"></i>
                            <span>Продукты</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/items/add">
                            <i class="fas fa-plus"></i>
                            <span>Добавить продукт</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="/admin/items/types/add">
                            <i class="fas fa-plus"></i>
                            <span>Добавить фильтр</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/requests">
                            <i class="fas fa-envelope"></i>
                            <span>Заявки</span>
                        </a>
                    </li>
                    <div class="user-links">
                       <li class="nav-item">
                        <a href="/admin/profile" class="nav-link text-monospace profile-btn">
            
                            <span><?=$_SESSION['username']?></span>
                        </a>
                    </li>
                    <li class="nav-item logout-btn">
                        <a class="nav-link" href="/admin/logout">
                        <i class="fa-solid fa-left-from-line"></i>
                            <span>Выйти</span>
                        </a>
                    </li>  
                    </div>
                   
            <?php else: ?>
                    <li class="nav-item  login-btn">
                        <a class="nav-link  " href="/admin/login">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Войти</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <span>Вернуться на главную</span>
                        </a>
                    </li>

        <?php endif;?>
                </ul>
            </div>
        </nav>
        <?= $content ?>
    <?php if ($_SESSION['admin'] == 1): ?>
        <script rel='script' src="/public_html/scripts/admin.js"></script>
    <?php endif; ?>
        <script src="/public_html/scripts/jquery-3.4.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
        <script src="/public_html/scripts/jquery.validate.js"></script>
        <script src="/public_html/scripts/form.js"></script>


</body>

</html>