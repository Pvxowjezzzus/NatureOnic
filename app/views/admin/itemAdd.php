<form class="form"  action="/admin/items/add" id='add-item' method="post">
                <h3>Добавление продукта</h3>
                <p>Выберите категорию</p>
                <select name="item-cat" id="item-cat" form="add-item">
                    <option value="">-</option>
                    <option value="fruits">Фрукты</option>
                    <option value="vegies"">Овощи</option>
                    <option value="nuts">Орехи</option>

                </select>
                <input type='text' name='name' placeholder="Название продукта" autocomplete="off">
                <textarea placeholder="Описание продукта" rows="5" name="description"></textarea>
                <input type='text' name="country" placeholder="Страна-производитель">
                <input type="file" name='image' accept='image/jpeg,image/png,image/gif,image/jpg' value='Загрузить изображение'>
                <input type='submit' value="Добавить товар">
            </form>
<script  src='/public_html/scripts/form.js'></script>