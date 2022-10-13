<section class="profile-container" id="profile">
<div class="modal fade" id="EmailModal" tabindex="-1" role="dialog" aria-labelledby="EmailModal" aria-hidden="true" on>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EmailModalTitle">Обновление электронной почты</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="alert-block alert-block_email" id="alert-block">
          <div class="close" id="close-btn">
            <i class="fas fa-times close_icon"></i>
          </div>
          <span></span>
      </div>
        <div class="input-group mt-3">
            <div class="input-wrap">
                <input type="email" name="email" placeholder=" " id="new_email" autocomplete="off">
                <label for="email">Ваш новый Email</label>
            </div>
        </div>
        <div class="input-group mt-3">
            <div class="input-wrap">
                <input type="password" name="password" placeholder=" " id="password" autocomplete="off">
                <label for="password">Пароль</label>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="button" id="changeEmailBtn" class="btn classic-btn">Сохранить изменения</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="PasswordModal" tabindex="-1" role="dialog" aria-labelledby="PasswordModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="PasswordModalTitle">Изменение пароля</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="alert-block alert-block_password" id="alert-block">
          <div class="close" id="close-btn">
            <i class="fas fa-times close_icon"></i>
          </div>
          <span></span>
      </div>
      <div class="input-group mt-3">
            <div class="input-wrap">
                <input type="password" name="password" placeholder=" " id="old_password" autocomplete="off">
                <label for="password">Ваш старый пароль</label>
            </div>
        </div>
        <div class="input-group mt-3">
            <div class="input-wrap">
                <input type="password" name="new_password" placeholder=" " id="new_password" autocomplete="off">
                <label for="new_password">Ваш новый пароль</label>
            </div>
        </div>
        <div class="input-group mt-3">
            <div class="input-wrap">
                <input type="password" name="verify_password" placeholder=" " id="verify_password" autocomplete="off">
                <label for="verify_password">Подтверждение пароля</label>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Закрыть</button>
        <button type="button" id="changePasswordBtn" class="btn classic-btn">Сохранить изменения</button>
      </div>
    </div>
  </div>
</div>
    <div class="profile-block">
        <div class="leftbox">
            <nav class="profile-nav">
                <a id="profile" class="active-prof prof">
                    <i class="fa fa-user"></i>
                </a>
                <?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'developer'):?>
                <a id="users">
                    <i class="fa fa-tasks"></i>
                </a>
                <!-- <a id="settings">
                    <i class="fa fa-cog"></i>
                </a> -->
                <?php endif;?>
            </nav>
        </div>
        <div class="rightbox">
            <div class="profile">
                <h3>Персональная информация</h3>
                <div class="profile-info">
                    <h4>Имя пользователя</h4>
                   <p><?=$_SESSION['username']?>
                    <span>Роль: <?=$userrole?></span>
                    </p> 
                   <? foreach($userdata as $data):?>
                   <h4>Email</h4>
                   <p><?=$data['email']?>
                   <button type="button" class="btn data-btn"  data-toggle="modal" data-target="#EmailModal">обновить</button>
                   </p> 
                   <h4>Дата создания аккаунта</h4>
                   <p><?=date_format(date_create($data['created_at']), 'd-m-Y');?></p> 
                   <? endforeach; ?>
                   <h4>Пароль</h4>
                   <p>••••••••
                   <button class="btn data-btn" data-toggle="modal" data-target="#PasswordModal">изменить</button>
                   </p>
                </div>     
            </div>
            <?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'developer'):?>
            <div class="users noshow">
                    <h3>Пользователи</h3>
              <table class="table users-table mt-5">
                <thead>
                  <tr>
                  <th scope="col">#</th>
                  <th scope="col">Имя</th>
                  <th scope="col">Email</th>
                  <th scope="col">Регистрация</th>
                  <th scope="col">Роль</th>
                  <!-- <th scope="col">Права</th> -->
                  </tr>
                </thead>
                <tbody>
                  <? foreach ($users as $user): ?>
                  <tr>
                    <td data-label='#'><?=$user['id']?></td>
                    <td data-label='Имя'><?=$user['username']?></td>
                    <td data-label='Email'><?=$user['email']?></td>
                    <td data-label='Регистрация'><?=$user['created_at']?></td>
                      
                    <td data-label='Роль'><?=$role?></td>                  
                    <? endforeach; ?>
    

                  
                  </tr>
                </tbody>
              </table>
            </div>
            <?php endif;?>
        </div>
    </div>
</section>