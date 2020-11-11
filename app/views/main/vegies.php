<section class="portf">
    <div class="portfolio">
        <div class="container">

            <div class="title">Овощи</div>

            <div class="row">
                <?php if (!empty($vegies)): ?>
                    <?php foreach ($vegies as $veg):
                        ?>
                        <div class="onecol1">
                            <div class="portfolio-item">
                                <div class="portfolio-item__png">
                                    <img src="<?= $veg['image']?>" >
                                </div>
                                <div class="portfolio-item__title">
                                    <h3><?=$veg['name']?></h3>
                                </div>
                                <div class="portfolio-item__text">
                                    <p><b>(<?=  $veg['country']?>)</b> <?=$veg['description']?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Категория овощей пуста:)</p>
                <?php endif; ?>

            </div>

        </div>
    </div>
</section>