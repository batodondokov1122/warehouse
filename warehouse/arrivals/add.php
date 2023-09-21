<?php

include '../App/Etc/init.php';

use \App\Models\Arrival;
use \App\Models\SfProduct;

$companies = Arrival::getCompanies();
$sf_products = SfProduct::getSfProducts();
$staff = Arrival::getStuffNames();


if ($_POST)
{
    $arrival = new Arrival($_POST);
    if ($arrival->validate())
    {
        $arrival->saveArrival();
    }
}
else
{
    $arrival = new Arrival();
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
            <li><a href="list.php">Приход</a></li>
            <li>Добавление</li>
        </ul>
        <?php if ($_POST): ?>
            <div class="errors">
                <?php if ($arrival->hasErrors()): ?>
                    <p>Вы допустили ошибки:</p>
                    <ul>
                        <?php foreach ($arrival->getErrors() as $error): ?>
                        <li><?= e($error)?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </div>
        <?php endif ?>
        <form action="" method="POST">
            <div class="input_block">
                <label>Дата*</label>
                <input type="date" name ="date" value="<?= e($arrival->date) ?>" class="input_text">
            </div>
            <div class="input_block">
                <label>Компания*</label>
                <select name="company_id" class="input_text" id="company_id">
                    <option selected disabled></option>
                    <?php 
                        foreach ($companies as $company):?>
                        <option value ="<?php echo($company['id']) ?>"<?php
                        if ($arrival->company_id != 0){
                            echo($arrival->company_id == $company['id'] ? 'selected' : '');
                        }
                    ?>><?= e($company['name']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input_block">
                <label>Полуфабрикат*</label>
                <select name="sf_product_id" class="input_text" id="sf_product_id">
                    <option selected disabled></option>
                    <?php 
                        foreach ($sf_products as $sf_product):?>
                        <option value ="<?php echo($sf_product['id']) ?>"<?php
                        if ($arrival->sf_product_id != 0){
                            echo($arrival->sf_product_id == $sf_product['id'] ? 'selected' : '');
                        }
                    ?>><?= e($sf_product['name']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input_block">
                <label>Количество</label>
                <input type="number" min = 0 name ="quantity" value=<?=e($arrival->quantity)?> class="input_num">
            </div>
            <div class="input_block">
                <label>Принял(а)*</label>
                <select name="accepted_stuff_id" class="input_text" id="accepted_stuff_id">
                    <option selected disabled></option>
                    <?php 
                        foreach ($staff as $employee):?>
                        <option value ="<?php echo($employee['id']) ?>"<?php
                        if ($arrival->accepted_stuff_id != 0){
                            echo($arrival->accepted_stuff_id == $employee['id'] ? 'selected' : '');
                        }
                    ?>><?= e($employee['name']) ?></option>
                    <?php endforeach ?>
                </select>
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