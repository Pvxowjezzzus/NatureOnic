<div class="container mt-5">
            <form class="form-group form"  action="/admin/items/add" id='add-item' method="post" enctype="multipart/form-data">
                <h3>Добавление продукта</h3>
                <div class="alert-block" id="alert-block">
                    <div class="close" id="close-btn">
                        <i class="fas fa-times close_icon"></i>
                    </div>
                    <span></span>
                </div>
                    <div class="input-group mt-3">
                        <p>Выберите категорию продукта</p>
                        <div class="input-wrap">
                            <select name="cat" class="select" id="item-cat" form="add-item" onchange="slide_select('types', this), get_values(this, null, null)">
                                <option value="">-</option>
                                <? foreach ($cats as $key => $val): ?>
                                    <option value="<?=$key?>"><?=$val?></option>
                                <? endforeach; ?>
                            </select>
                        </div>

                    </div>
                    <div class="input-group" id="types" hidden>
                        <div class="input-wrap">
                            <p>Выберите разновидность продукта</p>
                            <select name="item-kind" id="item-kind" form="add-item">
                                <option value="">-</option>
                            </select>
                        </div>

                    </div>

                    <div class="input-group">
                        <div class="input-wrap">
                            <input type="text" name="name" placeholder=" " id="name"  autocomplete="off">
                            <label for="name">Название продукта</label>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-wrap">
                            <textarea name="description" placeholder=" " id="description"></textarea>
                            <label for="email">Описание продукта</label>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-wrap">
                            <div class="form-control-feedback"></div>
                            <input type="text" name="country" placeholder=" " id="country"  autocomplete="off">
                            <label for="country">Страна-производитель</label>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-wrap price-input">
                            <input type="number"  name="price" placeholder=" " id="price" min="10" max="10000" step="10"  autocomplete="off">
                            <label for="price">Цена продукта</label>
                            <span class="price-text ml-3">руб/кг</span>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="file-input custom-file">
                            <input class="custom-file-input" id="chooseFile" type="file" title="Выберите изображение"  id="upload-photo" name='image' accept='image/jpeg,image/png,image/webp'  value='Загрузить изображение'>
                            <label class="custom-file-label" for="chooseFile">Выберите изображение</label>
                        </div>
                    <div class="button-panel">
                        <input class="button" type='submit' value="Добавить товар">
                    </div>
        </form>

</div>
