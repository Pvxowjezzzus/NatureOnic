<section class="enter-admin">
    <form class="admin-action" action="/admin/signup" method="post">
        <h3>Регистрация аккаунта</h3>
        <label for="login">Введите Email</label>
        <input id="login" type="text" name="email" class="auth-input" placeholder="Email">
        <label for="login">Введите Логин</label>
        <input id="login" type="text" name="login" class="auth-input" placeholder="Логин">
        <label for="password">Введите Пароль</label>
        <input id="password" type="password" name="password" class="auth-input" placeholder="Пароль">
        <label for="password">Введите повторно Пароль</label>
        <input id="password" type="password" name="password" class="auth-input" placeholder="Пароль еще раз">
        <input class="submit-log" type="submit" value="Зарегистрироваться" class="auth-input">
    </form>
    <a class="signup-link" href="/admin/login">Есть аккаунт? Войти</a>
</section>
<script src="/public_html/scripts/form.js"></script>
