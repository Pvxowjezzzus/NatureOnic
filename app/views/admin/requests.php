<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<div class='m-5'>  
        <div class="text-center">  
            <h3 class="table-name">Полученные заявки от пользователей</h3>
        </div>
        <? if(empty($requests)): ?>
            <div class='m-5 text-center'>
                <p>Сообщений нет.</p>
            </div>
        <? else: ?>
            <?=$pagination?>    
            <table class="table mt-5">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Сообщение</th>
                    <th>Продукт</th>
                    <th>Дата получения</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($requests as $request): ?>
                    <tr>
                        <td data-label='#'><?=$request['id']?></td>
                        <td data-label='Имя'><?=$request['username']?></td>
                        <td data-label='Email'><?=$request['email']?></td>
                        <td data-label='Сообщение'><?=$request['message']?></td>
                        <td data-label='Продукт'><?=$request['product']?></td>
                        <td data-label='Дата создания'><?=$request['date']?></td>
                    </tr>
                <? endforeach; ?>
                </tbody>
            </table>
            <?=$pagination?>
        <? endif; ?>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
