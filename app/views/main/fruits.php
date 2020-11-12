<section class="container">
   <a class="tomain-btn" href="/">На Главную</a>
            <div class="title">Фрукты</div>
                <?php if (empty($fruits)): ?>
                    <p>Категория "Фрукты" пуста:)</p>
                <?php else: ?>
                    <?php echo $pagination; ?>
                 <div class="row">
                        <?php foreach ($fruits as $fruit):?>
                        <div class="onecol1">
                            <div class="portfolio-item">
                                <div class="portfolio-item__png">
                                    <img src="/<?= $fruit['image']?>" >
                                </div>
                                <div class="portfolio-item__title">
                                    <h3><?=$fruit['name']?></h3>
                                </div>
                                <div class="portfolio-item__text">
                                    <p><b>Страна-производитель: <?=  $fruit['country']?></b> <?=$fruit['description']?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                 </div>
                    <?php echo $pagination; ?>
                <?php endif; ?>
</section>