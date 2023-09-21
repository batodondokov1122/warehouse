<?php

include '../App/Etc/init.php';

use \App\Models\Expense;
use \App\Models\SfProduct;
use \App\Models\Arrival;

$stands = Expense::getStands();
$entities = SfProduct::getEntities();
$sf_products = SfProduct::getSfProducts();
$staff = Arrival::getStuffNames();


if ($_POST)
{
    $expense = new Expense($_POST);
    if ($expense->validate())
    {
        $expense->saveExpense();
    }
}
else
{
    $expense = new Expense();
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
            <li><a href="list.php">Расход</a></li>
            <li>Добавление</li>
        </ul>
        <?php if ($_POST): ?>
            <div class="errors">
                <?php if ($expense->hasErrors()): ?>
                    <p>Вы допустили ошибки:</p>
                    <ul>
                        <?php foreach ($expense->getErrors() as $error): ?>
                        <li><?= e($error)?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </div>
        <?php endif ?>
        <form action="" method="POST">
            <div class="input_block">
                <label>Дата*</label>
                <input type="date" name ="date" value="<?= e($expense->date) ?>" class="input_text">
            </div>
            <div class="input_block">
                <label>Стенд*</label>
                <select name="stand_id" class="input_text" id="stand_id">
                    <option selected disabled></option>
                    <?php foreach ($stands as $stand):?>
                        <option value ="<?php echo($stand['id']) ?>"<?php
                        if ($expense->stand_id != 0){
                            echo($expense->stand_id == $stand['id'] ? 'selected' : '');
                        }
                    ?>><?= e($stand['name']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input_block">
                <label>Сущность*</label>
                <select name="entity_id" class="input_text" id="entity_id">
                    <option selected disabled><?= e(Expense::getEntityById($expense->entity_id)['name']) ?></option>
                </select>
            </div>
            <div class="input_block">
                <label>Полуфабрикат*</label>
                <select name="sf_product_id" class="input_text" id="sf_product_id">
                    <option selected disabled><?= e(Expense::getSfProductsById($expense->sf_product_id)['name']) ?></option>
                </select>
            </div>
            <div class="input_block">
                <label>Количество</label>
                <input type="number" min = 0 name ="quantity" value=<?=e($expense->quantity)?> class="input_num">
            </div>
            <div class="input_block">
                <label>Принял(а)*</label>
                <select name="accepted_stuff_id" class="input_text" id="accepted_stuff_id">
                    <option selected disabled></option>
                    <?php 
                        foreach ($staff as $employee):?>
                        <option value ="<?php echo($employee['id']) ?>"<?php
                        if ($expense->accepted_stuff_id != 0){
                            echo($expense->accepted_stuff_id == $employee['id'] ? 'selected' : '');
                        }
                    ?>><?= e($employee['name']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input_block">
                <label>Кому*</label>
                <select name="receiver_stuff_id" class="input_text" id="receiver_stuff_id">
                    <option selected disabled></option>
                    <?php 
                        foreach ($staff as $employee):?>
                        <option value ="<?php echo($employee['id']) ?>"<?php
                        if ($expense->receiver_stuff_id != 0){
                            echo($expense->receiver_stuff_id == $employee['id'] ? 'selected' : '');
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