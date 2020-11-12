<section class="container">
    <a class="tomain-btn" href="/">На Главную</a>
    <div class="title">Фрукты</div>
    <?php if (empty($vegies)): ?>
        <p>Категория фруктов пуста:)</p>
    <?php else: ?>
        <?php echo $pagination; ?>
        <div class="row">
            <?php foreach ($vegies as $veg):?>
                <div class="onecol1">
                    <div class="portfolio-item">
                        <div class="portfolio-item__png">
                            <img src="/<?= $veg['image']?>" >
                        </div>
                        <div class="portfolio-item__title">
                            <h3><?=$veg['name']?></h3>
                        </div>
                        <div class="portfolio-item__text">
                            <p><b>Страна-производитель: <?=  $veg['country']?></b> <?=$veg['description']?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php echo $pagination; ?>
    <?php endif; ?>
</section>