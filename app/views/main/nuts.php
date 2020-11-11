<section class="portf">
    <div class="portfolio">
        <div class="container">

            <div class="title">Орехи</div>

            <div class="row">
                <?php if (!empty($nuts)): ?>
                    <?php foreach ($nuts as $nut):
                        ?>
                        <div class="onecol1">
                            <div class="portfolio-item">
                                <div class="portfolio-item__png">
                                    <img src="<?= $nut['image']?>" >
                                </div>
                                <div class="portfolio-item__title">
                                    <h3><?=$nut['name']?></h3>
                                </div>
                                <div class="portfolio-item__text">
                                    <p><b>(<?=  $nut['country']?>)</b> <?=$nut['description']?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Категория орехов пуста:)</p>
                <?php endif; ?>

            </div>

        </div>
    </div>
</section>