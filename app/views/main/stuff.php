<section class="container">
   <a class="tomain-btn" href="/">На Главную</a>
            <div class="title"><?=$title?></div>
                <?php if (empty($items)): ?>
                    <p class="empty-msg">Категория "<?=$title?>" пуста:)</p>
                <section class="sort">
                    <div class="filters">
                        <a class='types' href="/stuff/<?=$cat?>">Все позиции</a>
                    </div>
                </section>
                <?php else: ?>
                    <?php echo $pagination; ?>
                    <section class="sort">
                        <a href="/stuff/<?=$cat?>?by=date&dir=<?=$dir?>"><span>Сортировать по дате</span><i class="arrow-<?=$dir?>">&uarr;</i></a>
                        <div class="filters">
                            <a class='types' href="/stuff/<?=$cat?>">Все позиции</a>
                            <? foreach ($types as $type):?>
                                <a class='types' href="/stuff/<?=$cat?>?type=<?=$type['alias']?>"><?=$type['name']?></a>
                            <? endforeach; ?>
                        </div>
                    </section>
                    <div class="row">
                        <?php foreach ($items as $item):?>
                        <div class="onecol1">
                            <div class="portfolio-item">
                                <div class="portfolio-item__png">
                                    <img width="95%" height="95%" src="/<?= $item['image']?>" >
                                </div>
                                <div class="portfolio-item__title">
                                    <h3><?=$item['name']?></h3>
                                </div>
                                <div class="portfolio-item__text">
                                    <p><b>Страна-производитель: <?=  $item['country']?></b></p>
                                    <p> <?=$item['description']?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                 </div>
                    <?=$pagination; ?>
                <?php endif; ?>
</section>