<section id="table" class='m-5'>
    <div class="m-5">
        <div class="text-center">
             <h3 class="table-name">Продукты</span></h3>
        </div>
           
    
    <? if(empty($items)): ?>
        <div class='m-5'>
            <p>Продукты отсутствуют</p>
        </div>
    <? else: ?>
        <?=$pagination?>
        <table class="table mt-5">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Название</th>
                <th scope="col">Категория</th>
                <th scope="col">Разновидность</th>
                <th scope="col">Страна-производитель</th>
                <th scope="col">Описание</th>
                <th scope='col'>Цена</th>
                <th scope="col">Путь изображения</th>
                <th scope="col">Дата создания</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($items as $item): ?>
                <tr>
                    <td data-label='#'><?=$item['id']?></td>
                    <td data-label='Название'><?=$item['name']?></td>
                    <td data-label='Категория'><?=$item['category']?></td>
                    <td data-label='Разновидность'><?=$item['type']?></td>
                    <td data-label='Страна-производитель'><?=$item['country']?></td>
                    <td data-label='Описание'><?=mb_substr($item['description'], 0, 75)?>...</td>
                    <td data-label='Цена'><?=$item['price']?> ₽</td>                    
                    <td data-lable="Путь изображения"><?=$item['image']?></td>
                    <td data-label='Дата создания'><?=$item['date']?></td>
                    <td data-label='Действия'>
                        <a class="table-actions" href="/admin/items/edit/<?=$item['id']?>">Редактировать</a>
                        <a class="table-actions" href="/admin/items/delete/<?=$item['id']?>">Удалить</a>
                    </td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>
        <?=$pagination?>
    <? endif; ?>
    </div>
</section>
