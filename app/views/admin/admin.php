<div class="container">
	<div class="header">
		<h3>Добро пожаловать в панель администратора</h3>
	</div>
<div class="d-flex justify-content-between">
	<div class="card info-card mb-3">
	<div class="row no-gutters">
		<div class="col-md-4 card-image">
			<img class="img-fluid" src="/public_html/img/items.webp"   alt="nuts&driedfruits">
		</div>
		<div class="col-md-8">
		<div class="card-body">
			<h5 class="card-title">Всего товаров</h5>
			<p class="card-text">На данный момент добавлено товаров: <?=$items?> </p>
			<p class="card-text"><small class="text-muted">Последнее обновление: <?= $lastitem?></small></p>
		</div>
		</div>
	</div>
	</div>
<div class="card info-card mb-3">
	<div class="row no-gutters">
		<div class="col-md-4 card-image">
			<img class="img-fluid" src="/public_html/img/new.webp"   alt="nuts&driedfruits">
		</div>
		<div class="col-md-8">
		<div class="card-body">
			<h5 class="card-title">Новые товары</h5>
			<p>Товаров добавленных за сегодня: <?=$new?> </p>
			<p class="card-text"><small class="text-muted">Последнее обновление: <?= $lastitem?></small></p>
		</div>
		</div>
	</div>
	</div>
</div>
</div>
</div>
	<div class='d-flex justify-content-center'>
			<div class="chart-diagram" id="chart"></div>
	</div>
	
	</div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="/public_html/scripts/diagram.js"></script>
