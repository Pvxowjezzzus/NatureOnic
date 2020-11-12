<section class="container">
    <a class="tomain-btn" href="/">На Главную</a>
    <div class="title">Орехи</div>
    <?php if (empty($nuts)): ?>
        <p>Категория "Орехи" пуста:)</p>
    <?php else: ?>
        <?php echo $pagination; ?>
        <div class="row">
            <?php foreach ($nuts as $nut):?>
                <div class="onecol1">
                    <div class="portfolio-item">
                        <div class="portfolio-item__png">
                            <img src="/<?= $nut['image']?>" >
                        </div>
                        <div class="portfolio-item__title">
                            <h3><?=$nut['name']?></h3>
                        </div>
                        <div class="portfolio-item__text">
                            <p><b>Страна-производитель: <?=  $nut['country']?></b> <?=$nut['description']?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php echo $pagination; ?>
    <?php endif; ?>
</section>