<?php
    include '../App/Etc/init.php';

    use \App\Models\Expense;
    use \App\Models\SfProduct;
    
    $expenses = Expense::getExpenses();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF_8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/expense.css">
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Приход</title>
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
                        <a href="../expense/list.php"><li>Расход</li></a>
                        <a href="../arrival/list.php"><li>Приход</li></a>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <main>
        <ul class="breadcrumb">
            <li>Полуфабрикаты</li>
            <li>Приход</li>
        </ul>
        <div class="buttons">
            <a href="add.php"><img src="../images/plus-circle.svg" alt="plus icon"></a>
        </div>
        <div class="table">
            <table border="2">
                <thead>
                    <tr>
                        <th class="th_num">Дата</th>
                        <th>Стенд</th>
                        <th>Сущность</th>
                        <th>Полуфабрикат</th>
                        <th class="th_num">КВО</th>
                        <th>Принял(а)</th>
                        <th>Кому</th>
                    </tr>
                </thead>
            </table>
            <table border="2">
                <tbody>
                    <?php foreach ($expenses as $expense): ?>
                        <tr>
                            <td><a href="edit.php?expense_id=<?=e($expense['id'])?>"><?= e($expense['date']) ?></a></td>
                            <td><?= e(Expense::getStandById($expense['stand_id'])['name']) ?></td>
                            <td><?= e(Expense::getEntityById($expense['entity_id'])['name']) ?></td>
                            <td><?= e(Expense::getSfProductsById($expense['sf_product_id'])['name']) ?></td>
                            <td class="td_num"><?= e($expense['quantity']) ?></td>
                            <td><?= e(Expense::getStuffNameByID($expense['accepted_stuff_id'])) ?></td>
                            <td><?= e(Expense::getStuffNameByID($expense['receiver_stuff_id'])) ?></td>
                        </tr>
                    <?php endforeach ?>
                </thead>
            </table>
        </div>
    </main>
    <footer>
        Полюс-НТ, 2023
    </footer>
    <script src="../scripts/script.js"></script>
</body>
</html>