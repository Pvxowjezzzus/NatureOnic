<div class="container mt-5">
    <form class="form form-group"  action="<?=$url?>" id='add-item' method="post">
    <div class="alert-block" id="alert-block">
                    <div class="close" id="close-btn">
                        <i class="fas fa-times close_icon"></i>
                    </div>
                    <span></span>
                </div>
        <h3>Редактирование данных продукта</h3>
        <div class="input-group" id="types">
            <div class="input-wrap">
                <p>Выберите разновидность продукта</p>
                <select name="item-kind" id="item-kind" form="add-item">
                    <option value="">-</option>
                </select>
            </div>
        </div>
        <? foreach ($item as $data): ?>
        <div class="input-group">
            <div class="input-wrap">
                <input type="text" name="name" placeholder=" " id="name"  autocomplete="off" value="<?=$data['name']?>">
                <label for="name">Название продукта</label>
            </div>
        </div>
        <div class="input-group">
            <div class="input-wrap">
                <textarea name="description" placeholder=" " id="description" ><?=$data['description']?></textarea>
                <label for="email">Описание продукта</label>
            </div>
        </div>
        <div class="input-group">
            <div class="input-wrap">
                <div class="form-control-feedback"></div>
                <input type="text" name="country" placeholder=" " id="country"  autocomplete="off" value="<?=$data['country']?>">
                <label for="country">Страна-производитель</label>
            </div>
        </div>
        <div class="input-group">
            <div class="input-wrap d-flex">
                <input type="number" step="10" name="price" placeholder=" " id="price"  autocomplete="off" value="<?=$data['price']?>">
                <label for="price">Цена продукта</label>
                <span class="price-text ml-3">руб/кг</span>
            </div>
        </div>
        <div class="button-panel">
            <input class="button" type='submit' value="Обновить данные">
        </div>
    </form>
    <script type="text/javascript"  src='/public_html/scripts/form.js'></script>
    <script type="text/javascript">
        window.onload = function () {
            get_values("<?=$data['category']?>", select_type, "<?=$data['type']?>");
        }
        <? endforeach; ?>
    </script>
</div>
