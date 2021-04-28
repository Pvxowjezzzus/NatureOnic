<h3 class="table-name">Полученные сообщения от пользователей</h3>
<? if(empty($items)): ?>
	<p>Сообщений нет.</p>
<? else: ?>
	<table class="table">
		<thead>
		<tr>
			<th>#</th>
			<th>Имя</th>
			<th>Email</th>
			<th>Сообщение</th>
            <th>Дата получения</th>
		</tr>
		</thead>
		<tbody>
		<? foreach ($items as $item): ?>
			<tr>
				<td data-label='#'><?=$item['id']?></td>
				<td data-label='Имя'><?=$item['name']?></td>
                <td data-label='Email'><?=$item['email']?></td>
                <td data-label='Сообщение'><?=$item['message']?></td>
				<td data-label='Дата создания'><?=$item['created_at']?></td>
			</tr>
		<? endforeach; ?>
		</tbody>
	</table>
	<?=$pagination?>
<? endif; ?>