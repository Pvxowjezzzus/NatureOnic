<form class="form"  action="/admin/items/types/add" id='add-type' method="post">
    <h3>Добавление фильтра</h3>
    <p>Выберите категорию продукта</p>
    <select id="item-cat" form="add-item" onchange="slide_select('form-part', this)">
        <option value="">-</option>
        <? foreach ($cats as $key => $val): ?>
            <option value="<?=$key?>"><?=$val?></option>
        <? endforeach; ?>
    </select>

    <div id="form-part" hidden>
        <label for="name">Название фильтра</label>
        <input id="name" type='text' name="name" placeholder="Введите наименование">
        <label for="name">Псевдоним</label>
        <input id="alias" type='text' name="alias" placeholder="Введите псевдоним">
        <input type='submit' value="Добавить товар">
    </div>
</form>
<script  src='/public_html/scripts/form.js'></script>
