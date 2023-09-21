<?php

include '../App/Etc/init.php';

use \App\Models\SfProduct;

$entities = SfProduct::getEntities();

if ($_POST)
{
    $sf_product = new SfProduct($_POST);
    if ($sf_product->entity_id > 0)
    {
        $subentities = SfProduct::getSubEntitiesById($sf_product->entity_id);
    }
    if ($sf_product->validate())
    {
        $sf_product->saveSfProduct();
    }
}
else
{
    $sf_product = new SfProduct();
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
            <li>Полуфабрикаты</li>
            <li><a href="list.php">Общий список</a></li>
            <li>Добавление</li>
        </ul>
        <?php if ($_POST): ?>
            <div class="errors">
                <?php if ($sf_product->hasErrors()): ?>
                    <p>Вы допустили ошибки:</p>
                    <ul>
                        <?php foreach ($sf_product->getErrors() as $error): ?>
                        <li><?= e($error)?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </div>
        <?php endif ?>
        <form action="" method="POST">
            <div class="input_block">
                <label>Название*</label>
                <textarea name="name" cols="60" rows="5" maxlength="255" class="textarea"><?=e($sf_product->name)?></textarea>
            </div>
            <div class="input_block">
                <label>Артикул*</label>
                <input type="text" name ="article_number" value="<?=e($sf_product->article_number)?>" class="input_text">
            </div>
            <div class="input_block">
                <label>Сущность*</label>
                <select name="entity_id" class="input_text" id="entity_id">
                    <option selected disabled></option>
                    <?php 
                        foreach ($entities as $entity):?>
                        <option value ="<?php echo($entity['id']) ?>"<?php
                        if ($sf_product->entity_id != 0){
                            echo($sf_product->entity_id == $entity['id'] ? 'selected' : '');
                        }
                    ?>><?= e($entity['name']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input_block">
                <label>Подсущность</label>
                <select class="input_text" name="subentity_id" id="subentity_id" >
                    <option selected disabled></option>
                    <?php foreach ($subentities as $subentity):?>
                        <option value ="<?php echo($subentity['id']) ?>"<?php
                        if ($sf_product->subentity_id != 0){
                            echo($sf_product->subentity_id == $subentity['id'] ? 'selected' : '');
                        }
                    ?>><?= e($subentity['name']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input_block">
                <label>Количество в стенде</label>
                <input type="number" min = 0 name ="stand_quantity" value=<?=e($sf_product->stand_quantity)?> class="input_num">
            </div>
            <div class="input_block">
                <label>Общая сумма на складе</label>
                <input type="number" min = 0 name ="quantity" value=<?=e($sf_product->quantity)?> class="input_num">
            </div>
            <button type="submit" class="component_save_button">ДОБАВИТЬ</button>
        </form>
    </main>
    <footer>
        Полюс-НТ, 2023
    </footer>
    <script src="../scripts/script.js"></script>
</body>
</html>