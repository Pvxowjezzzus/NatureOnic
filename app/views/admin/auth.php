<div class="form-wrapper">
    <div class="text-center text-gray">
        <h3>Авторизация</h3>
    </div>

    <form action="/admin/login" method="post" id="auth_form" class="form">
        <div class="alert-block" id="alert-block">
            <div class="close" id="close-btn">
                <i class="fas fa-times close_icon"></i>
            </div>
            <span></span>
        </div>
        <div class="input-group">
            <label class="control-label"  for="username">Имя пользователя или Email</label>
            <div class="input-wrap">
                <input type="text" class="form-control"  id="username" name="username" placeholder="Введите имя или Email" />
            </div>
        </div>
        <div class="input-group">
            <label class="control-label" for="password">Пароль</label>
            <div class="input-wrap">
                <input type="password" class="form-control" name="password" placeholder="Введите пароль" id="password">
            </div>
        </div>


        <div class="button-panel">
            <input type="submit" class="button" id="submit_btn" title="Войти" value="Войти">
        </div>
    </form>
	<div class="form-footer">
		<p><a href="/admin/signup">Зарегистрироваться</a></p>
	</div>
</div>
