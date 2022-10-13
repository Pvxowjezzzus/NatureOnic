<header class="header fixed-top">
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="info-block col">
                    <object class="img-fluid info-icon" type="image/svg+xml" data="/public_html/img/mail.svg" id="svg" width="5%" height="5%"></object>
                    <span class="info-text text-white">Наш Email: natureonic@yandex.ru</span>
                </div>
                <div class="info-block col offset-4">
                        <object class="img-fluid info-icon" type="image/svg+xml" data="/public_html/img/pin.svg" id="svg" width="5%" height="5%"></object>
                        <span class="info-text text-white">Наш адрес: г. Москва, Краснопрудная улица, дом 12/1 строение 1</span>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark" id="navigation" >
        <div class="container">
            <div class="col logo">
                <div class="order-first">
                    <a class="navbar-brand" href="#">
                        <img src="public_html/img/white-logo.png" width="105" height="39"  class="d-inline-block align-top" alt="">
                    </a>
                </div>
            </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Переключатель навигации">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mx-auto" id="navbarToggler">
                <ul class="navbar-nav text-center navbar-dark navbar-inverse">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#about">О компании</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#products">Продукты</a>
                    </li>
                    <li class="nav-item pr-0">
                        <a class="nav-link text-white" href="#contacts">Контакты</a>
                    </li>
                </ul>
                <div class="float-right ml-auto">
                    <a href="#request" class="btn order-btn btn-sm">
                        <span>Оставить заявку</span>
                    </a>
                </div>
                <div>

                </div>
            </div>
    </nav>
</header>
<div class="wrapper">
    <main class="main">
        <section id="home" class="home">
            <div class="home-center">
                <div class="home-desc">
                    <div class="text-center">
                        <img src="public_html/img/logo.png"   class="d-inline-block align-top" alt="">
                        <h2 class="text-white mb-3">Оптовая доставка сухофруктов, орехов</h2>
                        <button class="btn btn-lg btn-group about-btn px-5">
                            <a class="text-white text-decoration-none" href="#about">Подробнее</a>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="about" id="about">
            <div class="container">
                <div class="content-block">
                    <div class="row">
                        <div class="col">
                            <div class="section-header text-green">
                                <h2>О нас</h2>
                            </div>
                            <div class="about-text">
                                <p class="text-break">
                                    Наша компания успешно осуществляет продажу орехов и сухофруктов и занимает одно из первых мест по надежности среди поставщиков,
                                    благодаря постоянному усовершенствованию условий доставки. Ежедневно мы находим и выбираем для своих клиентов самые лучшие и
                                    свежие продукты по оптимальной цене и привозим их на свой склад по России, чтобы завтра к Вам доставили качественные и продукты.
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="about-img">
                                <img src="public_html/img/nuts.png"  class="d-inline-block align-top img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="products" id="products">
            <div class="container bg_green">
                <div class="products-block my-5">
                    <div class="content-block">
                        <div class="section-header text-center text-white mb-5">
                            <h2>Наша Продукция</h2>
                        </div>
                        <div class="row products_catalog">
                            <div class="col-lg-6 col-sm-12 left catalog">
                                <h3 class="text-white products_header">Орехи</h3>
                                <a  class="products_link" href="/stuff/nuts"></a>
                            </div>
                            <div class="col-lg-6 col-sm-12 right catalog">
                                <h3 class="text-white products_header">Сухофрукты</h3>
                                <a  class="products_link" href="/stuff/driedfruits"></a>
                            </div>
                        </div>

                    </div>
                </div>
        </section>
        <section id="pros" class="pros-block">
        <div class="container bg_white my-5">
            <div class="section-header text-green text-center">
                    <h2>Наши приемущества</h2>
            </div>
            <div class="d-flex justify-content-around mt-5">
                <div class="pros-elem">
                    <img src="/public_html/img/fresh-production.png">
                    <p class="pros-text text-green text-center mt-3">Самая свежая продукция</p>
                </div>
                <div class="pros-elem">
                    <img src="/public_html/img/processing.png">
                    <p class="pros-text text-green text-center mt-3">Быстрая обработка заявок</p>
                </div>
                <div class="pros-elem">
                    <img src="/public_html/img/handshake.png">
                    <p class="pros-text text-green text-center mt-3">Сотрудничество с качественными производителями </p>
                </div>
            </div>
        </div>
        </section>
        <section id="request" class="request-block">
            <div class="container bg_green">
                <div class="section-header text-white text-center">
                    <h2>Оставить заявку</h2>
                </div>
                <form id="request-form" action="request/send" method="post" class="request__form mt-5" novalidate>
                    <div class="msg__block">
                        <span class="msg__value"></span>
                        <div class="close close-btn" id="close-btn">
                            <i class="fas fa-times close_icon"></i>
                        </div>
                    </div>

                        <div class='input-wrap'>
                             <input  type="text" name="username" placeholder=" " id='username'  autocomplete="off">
                        <label for="username">Имя пользователя</label>
                        </div>
                       


                    <div class="input-wrap">
                        <input type="email" name="email" placeholder=" " id='email'  autocomplete="off">
                        <label for="email">Email</label>
                    </div>

                    <div class="input-wrap">
                        <textarea class="textarea" name="message" placeholder=" " id="message"  autocomplete="off"></textarea>
                        <label for="message">Сообщение к заявке</label>
                    </div>
                    <label class='text-white' for="product">Выбор продукции</label>
                    <div class="input-select">
                        <select class="form-control form-control-sm product-select" name="product" id="product" form="request-form">
                            <option value="">-</option>
                        <? foreach ($products as $product): ?>
                                    <option value="<?=$product['name']?>"><?=$product['name']?></option>
                        <? endforeach; ?>
                        </select>
                        <label for="product">Сообщение к заявке</label>
                    </div>
                    <input class="my-4" type="submit" value="Отправить заявку" class="support__submit">
                </form>
            </div>
        </section>
    </main>
</div>



