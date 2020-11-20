    <form class="form"  action="<?=$url?>" id='add-item' method="post">
        <h3>Редактирование данных продукта</h3>
        <p>Разновидность продукта</p>
        <select id="item-kind" name="item-kind"  form="add-item">
        </select>
        <? foreach ($item as $data): ?>
        <input type='text' name='name' placeholder="Название продукта" value="<?=$data['name']?>" autocomplete="off">
        <textarea placeholder="Описание продукта" rows="5" name="description"><?=$data['description']?></textarea>
        <input type='text' name="country" placeholder="Страна-производитель" value="<?=$data['country']?>">
        <input type="file" name='image' accept='image/jpeg,image/png,image/gif,image/jpg' value='Загрузить изображение'>
        <? endforeach; ?>
        <input type='submit' value="Обновить данные">
    </form>
    <script type="text/javascript"  src='/public_html/scripts/form.js'></script>
    <script type="text/javascript">
        window.onload = function () {
            get_values("<?=$cat?>", select_type, "<?=$data['type']?>");
        }

    </script>
