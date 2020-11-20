<form class="form"  action="/admin/items/types/add" id='add-type' method="post">
    <h3>Добавление фильтра</h3>
    <p>Выберите категорию продукта</p>
    <select id="item-cat" form="add-item" onchange="slide_select('form-part', this)">
        <option value="">-</option>
        <option value="fruits">Фрукты</option>
        <option value="vegies">Овощи</option>
        <option value="nuts">Орехи</option>
        <option value="berries">Ягоды</option>
        <option value="shrooms">Грибы</option>
    </select>

    <div id="form-part" hidden>
        <input type='text' name="name" placeholder="Название фильтра">
        <input type='text' name="alias" placeholder="Псевдоним фильтра">
        <input type='submit' value="Добавить товар">
    </div>
</form>
<script  src='/public_html/scripts/form.js'></script>
