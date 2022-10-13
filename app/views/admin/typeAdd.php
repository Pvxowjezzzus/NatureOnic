<div class="container mt-5">
    <form class="form form-group"  action="/admin/items/types/add" id='add-type' method="post">
        <h3>Добавление фильтра</h3>
        <div class="alert-block" id="alert-block">
            <div class="close" id="close-btn">
                <i class="fas fa-times close_icon"></i>
            </div>
            <span></span>
        </div>
        <p>Выберите категорию продукта</p>
        <select id="item-cat" form="add-item" onchange="slide_select('form-part', this)">
            <option value="">-</option>
            <? foreach ($cats as $key => $val): ?>
                <option value="<?=$key?>"><?=$val?></option>
            <? endforeach; ?>
        </select>

        <div class="form-part mt-5" id="form-part" hidden>
            <div class="input-group">
                <div class="input-wrap">
                    <input id="name" type='text' name="name" placeholder=" ">
                    <label for="name">Название фильтра</label>
                </div>
            </div>
            <div class="input-group">
                <div class="input-wrap">
                    <input id="alias" type='text' name="alias" placeholder=" ">
                    <label for="name">Псевдоним</label>
                </div>
            </div>
            <div class="button-panel">
                <input class="button" type='submit' value="Добавить товар">
            </div>
        </div>
    </form>
</div>