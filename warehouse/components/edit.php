<?php

include '../App/Etc/init.php';

use \App\Models\Component;

$categories = Component::getCategories();

if ($_POST) 
{
    $component = new Component($_POST);
    if ($component->category_id > 0)
    {
        $subcategories = Component::getSubCategoriesById($component->category_id);
    }
    if ($component->validate())
    {
        $component->updateComponent($_GET['component_id']);
    }
}
else
{
    if ($_GET){
        if (!empty($_GET['component_id'])){
            $component = new Component(Component::getComponentById($_GET['component_id']));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/add.css">
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Добавление</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <img src="../images/menu.svg" alt="Menu icon" class="menu_icon">
            <img src="../images/logo.jpg" alt="Logo icon" class="logo_icon">
        </header>
        <nav class="sidenav">
            <div class="sidenav_header">
                <img src="../images/logo.jpg" alt="Logo icon" class="logo_icon">
                <img src="../images/x.svg" alt="Exit icon" class="exit_icon">
            </div>
            <ul class="main_ul">
                <li>
                    <div class="li">КОМПОНЕНТЫ
                        <img src="../images/chevron-down.svg" alt="chevron-down" class="down">
                    </div>
                    <ul class="sub_ul closed">
                        <a href="../components/index.php"><li>Общий список</li></a>
                    </ul>
                </li>
                <li>
                    <div class="li">ПОЛУФАБРИКАТЫ
                        <img src="../images/chevron-down.svg" alt="chevron-down" class="down">
                    </div>
                    <ul class="sub_ul closed">
                        <a href="../sf-products/list.php"><li>Общий список</li></a>
                        <a href="#"><li>Ячейки</li></a>
                        <a href="../sf-products/expense.php"><li>Расход</li></a>
                        <a href="../sf-products/arrival.php"><li>Приход</li></a>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <main>
        <ul class="breadcrumb">
            <li>Компоненты</li>
            <li><a href="index.php">Общий список</a></li>
            <li>Добавление</li>
        </ul>
        <?php if ($_POST): ?>
            <div class="errors">
                <?php if ($component->hasErrors()): ?>
                    <p>Вы допустили ошибки:</p>
                    <ul>
                        <?php foreach ($component->getErrors() as $error): ?>
                        <li><?= e($error)?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </div>
        <?php endif ?>
        <form action="" method="POST">
            <div class="input_block">
                <label>Название + спецификация*</label>
                <textarea name="name" cols="60" rows="5" maxlength="255" class="textarea"><?=e($component->name)?></textarea>
            </div>
            <div class="input_block">
                <label>Артикул*</label>
                <input type="text" name ="article_number" value="<?=e($component->article_number)?>" class="input_text">
            </div>
            <div class="input_block">
                <label>Ссылка</label>
                <textarea name="link" cols="60" rows="5" maxlength="255" class="textarea"><?=e($component->link)?></textarea>
            </div>
            <div class="input_block">
                <label>Категория*</label>
                <select name="category_id" class="input_text" id="category_id">
                    <option selected disabled></option>
                    <?php 
                        foreach ($categories as $category):?>
                        <option value ="<?php echo($category['id']) ?>"<?php
                        if ($component->category_id != 0){
                            echo($component->category_id == $category['id'] ? 'selected' : '');
                        }
                    ?>><?= e($category['name']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input_block">
                <label>Подкатегория</label>
                <select class="input_text" name="subcategory_id" id="subcategory_id" >
                    <option selected disabled></option>
                    <?php 
                        foreach ($subcategories as $subcategory):?>
                        <option value ="<?php echo($subcategory['id']) ?>"<?php
                        if ($component->subcategory_id != 0 && $component->subcategory_id != NULL){
                            echo($component->subcategory_id == $subcategory['id'] ? 'selected' : '');
                        }
                    ?>><?= e($subcategory['name']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input_block">
                <label>Контрагент</label>
                <input type="text" name ="contractor" value="<?=e($component->contractor)?>" class="input_text">
            </div>
            <div class="input_block">
                <label>Что в стенде</label>
                <textarea name="stand_description" cols="60" rows="5" maxlength="255" class="textarea"><?=e($component->stand_description)?></textarea>
            </div>
            <div class="input_block">
                <label>Назначение</label>
                <textarea name="purpose" cols="60" rows="5" maxlength="255" class="textarea"><?=e($component->purpose)?></textarea>
            </div>
            <div class="input_block">
                <label>Тип</label>
                <input type="text" name ="type" value="<?=e($component->type)?>" class="input_text">
            </div>
            <div class="input_block">
                <label>Количество ИЭС</label>
                <input type="number" min = 0 name ="IES_quantity" value=<?=e($component->IES_quantity)?> class="input_num">
            </div>
            <div class="input_block">
                <label>Количество ОВКС</label>
                <input type="number" min = 0 name ="OVKS_quantity" value=<?=e($component->OVKS_quantity)?> class="input_num" id="ovks_input">
            </div>
            <div class="input_block">
                <label>Количество УНКС</label>
                <input type="number" min = 0 name ="UNKS_quantity" value=<?=e($component->UNKS_quantity)?> class="input_num" id="unks_input">
            </div>
            <div class="input_block">
                <label>Количество БТС</label>
                <input type="number" min = 0 name ="BTS_quantity" value=<?=e($component->BTS_quantity)?> class="input_num" id="bts_input">
            </div>
            <div class="input_block">
                <label>Стартовое количество</label>
                <input type="number" min = 0 name ="start_quantity" value=<?=e($component->start_quantity)?> class="input_num">
            </div>
            <div class="input_block">
                <label>Минимальное наличие</label>
                <input type="number" min = 0 name ="min_quantity" value=<?=e($component->min_quantity)?> class="input_num">
            </div>
            <button type="submit" class="component_save_button">СОХРАНИТЬ</button>

        </form>
    </main>
    <footer>
        Полюс-НТ, 2023
    </footer>
    <script src="../scripts/script.js"></script>
</body>
</html>