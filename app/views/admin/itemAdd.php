<form class="form"  action="/admin/items/add" id='add-item' method="post">
                <h3>Добавление продукта</h3>
                <p>Выберите категорию продукта</p>
                <select id="item-cat" form="add-item" onchange="slide_select('types', this), get_values(this, null, null)">
                    <option value="">-</option>
                    <? foreach ($cats as $key => $val): ?>
                        <option value="<?=$key?>"><?=$val?></option>
                    <? endforeach; ?>
                </select>

                <div id="types" hidden>
                    <p>Выберите разновидность продукта</p>
                    <select name="item-kind" id="item-kind" form="add-item" onchange="slide_select('form-part', this)">
                        <option value="">-</option>
                    </select>
                </div>

                <div id="form-part" hidden>
                    <input  type='text' id="name" name='name' placeholder="Название продукта" autocomplete="off">
                    <textarea placeholder="Описание продукта" rows="5" name="description"></textarea>
                    <input type='text' name="country" placeholder="Страна-производитель">
                    <input type="file" name='image' accept='image/jpeg,image/png,image/gif,image/jpg' value='Загрузить изображение'>
                    <input type='submit' value="Добавить товар">
                </div>
            </form>
<script  src='/public_html/scripts/form.js'></script>