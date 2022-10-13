<section class="container p-5">
    
    <a class="btn__main" href="/">На Главную</a>
    <div class="title"><h3><?=$title?></h3></div>

	<?php if(empty($items) && !empty($_GET['type'])): ?>
        <p class="empty-msg">Разновидность <?=$type?> пуста.</p>
        <a class="back-link text-green" href="/stuff/<?=$cat?>">Вернуться в категорию</a>
        <div class="sort mx-5">
            <div class="filters">
                <a class='type' href="/stuff/<?=$cat?>">Все позиции</a>
            </div>
        </div>

	<?php elseif (empty($items) && !isset($_GET['type'])): ?>
        <p class="empty-msg"><?=$title?> пуста.</p>
        <div class="sort mx-5">
            <div class="filters">
                <a class='type' href="/stuff/<?=$cat?>">Все позиции</a>
            </div>
        </div>

	<?php else: ?>
		<?=$pagination;?>
        <div class="sort">
            <a <?= isset($_GET['type']) ? "href='/stuff/$cat?type=".$_GET['type']. "&by=date&dir=$dir'" : "href='/stuff/$cat?by=date&dir=$dir'"; ?> class="sort-val">
                <span>Сортировать по дате</span>
                <i <?=($_GET['by'] == 'date') ? "class='arrow-$dir'" : "" ?> >&uarr;</i>
            </a>
            <a <?= isset($_GET['type']) ? "href='/stuff/$cat?type=".$_GET['type']. "&by=name&dir=$dir'" : "href='/stuff/$cat?by=name&dir=$dir'"; ?> class="sort-val" >
                <span>Сортировать по имени</span>
                <i <?=($_GET['by'] == 'name') ? "class='arrow-$dir'" : "" ?> >&uarr;</i>
            </a>
            <div class="filters">
                <a <?= (!isset($_GET['type'])) ? "class=' type active'" : "class='type'"; ?> href="/stuff/<?=$cat?>">Все позиции</a>
				<? foreach ($types as $type):?>
                    <a <?= ($type['alias'] == $_GET['type']) ? "class='type active'" : "class='type'"; ?> href="/stuff/<?=$cat?>?type=<?=$type['alias']?>"><?=html_entity_decode($type['name'])?></a>
				<? endforeach; ?>
            </div>
        </div>
        <div class="row items mx-5">
			<?php foreach ($items as $item):?>
                <div class="onecol1 col-md-4 item">
                    <div class="portfolio-item">
                        <div class="portfolio-item__png">
                            <img  src="/<?= $item['image']?>" >
                        </div>
                        <div class="portfolio-item__title">
                            <h3><?=$item['name']?></h3>
                        </div>
                        <div class="portfolio-item__text mb-4">
                            <p><b>Страна-производитель: <?=  $item['country']?></b></p>
                            <p><b>Цена: <?= $item['price']?> руб/кг</b></p>
                            <p> <?=html_entity_decode(ucfirst($item['description']))?></p>
                        </div>
                        <a class="buy-btn" href="/?item=<?=$item['name']?>#request">Купить</a>
                    </div>
                </div>
			<?php endforeach; ?>
        </div>
		<?=$pagination; ?>
        </section>
	<?php endif; ?>
</section>