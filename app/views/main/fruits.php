<section class="portf">
    <div class="portfolio">
        <div class="container">

            <div class="title">Фрукты</div>

            <div class="row">
                <?php if (!empty($fruits)): ?>
                <?php foreach ($fruits as $fruit):
                       ?>
                <div class="onecol1">
                    <div class="portfolio-item">
                        <div class="portfolio-item__png">
                            <img src="<?= $fruit['image']?>" >
                        </div>
                        <div class="portfolio-item__title">
                            <h3><?=$fruit['name']?></h3>
                        </div>
                        <div class="portfolio-item__text">
                            <p><b>(<?=  $fruit['country']?>)</b> <?=$fruit['description']?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>Категория фруктов пуста:)</p>
                <?php endif; ?>

            </div>

        </div>
    </div>
</section>