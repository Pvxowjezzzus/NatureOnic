<section class="enter-admin">
    <form class="admin-action" action="/admin/login" method="post">
        <h3>Вход в Панель Администратора</h3>
        <label for="login">Введите Логин или Email</label>
        <input id="login" type="text" name="login" class="auth-input" placeholder="Логин или Email">
        <label for="password">Введите Пароль</label>
        <input id="password" type="password" name="password" class="auth-input" placeholder="Пароль">
        <input class="submit-log" type="submit" value="Войти" class="auth-input">
    </form>
    <a class="signup-link" href="/admin/signup">Зарегистрироваться</a>
</section>
<script src="/public_html/scripts/form.js"></script>



