<div class="form-wrapper">
    <div class="text-center text-gray">
        <h3>Регистрация</h3>
    </div>
    <div class="container">
        <form action="/admin/signup" method="post" id="auth_form" class="form">
                <div class="alert-block" id="alert-block">
                    <div class="close" id="close-btn">
                        <i class="fas fa-times close_icon"></i>
                    </div>
                    <span></span>
                </div>
            <div class="input-group">
                <label class="control-label" for="username">Имя пользователя</label>
                <div class="input-wrap">
                    <input type="text" id="username" name="username" placeholder="Введите имя" autocomplete="off" />
                </div>
            </div>

                <div class="input-group">
                    <label class="control-label" for="email">Email</label>
                    <div class="input-wrap">
                        <input  type="email" name="email" placeholder="Введите email" id="email"  autocomplete="off">
                    </div>
                </div>
                <div class="input-group">
                    <label class="control-label" for="password">Пароль</label>
                    <div class="input-wrap">
                        <input type="password" name="password" placeholder="Введите пароль" id="password">
                    </div>
                </div>

                <div class="input-group">
                    <label class="control-label" for="password_verify">Подтверждение пароля</label>
                    <div class="input-wrap">
                        <input type="password" name="password_verify" placeholder="Подтвердите пароль" id="password_verify">
                    </div>
                </div>

                <div class="button-panel">
                    <input type="submit" class="button" id="submit_btn" title="Зарегистрироваться" value="Зарегистрироваться">
                </div>
        </form>
        <div class="form-footer">
            <p><a href="/admin/login">Есть аккаунт? Войти</a></p>
        </div>
    </div>
</div>


