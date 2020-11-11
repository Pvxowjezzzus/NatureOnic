<h3 class="table-name">Таблица <span><?=$title?></span></h3>
<? if(empty($items)): ?>
    <p>Продуктов данной категории нет.</p>
<? else: ?>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th>Страна-производитель</th>
            <th>Описание</th>
            <th>Путь изображения</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($items as $item): ?>
            <tr>
                <td data-label='#'><?=$item['id']?></td>
                <td data-label='Название'><?=$item['name']?></td>
                <td data-label='Страна-производитель'><?=$item['country']?></td>
                <td data-label='Описание'><?=mb_substr($item['description'], 0, 75)?>...</td>
                <td data-lable="Путь изображения"><?=$item['image']?></td>
                <td data-label='Дата создания'><?=$item['date']?></td>
                <td data-label='Действия'>
                    <a class="table-actions" href="/admin/item/edit/<?=$_GET['cat']."/".$item['id']?>">Редактировать</a>
                    <a class="table-actions" href="/admin/items/delete/<?=$_GET['cat']."/".$item['id']?>">Удалить</a>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
<? endif; ?>