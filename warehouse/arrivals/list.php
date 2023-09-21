<?php
    include '../App/Etc/init.php';

    use \App\Models\Arrival;
    use \App\Models\SfProduct;
    
    $arrivals = Arrival::getArrivals();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF_8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/arrival.css">
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
                        <th>Компания</th>
                        <th>Полуфабрикат</th>
                        <th class="th_num">КВО</th>
                        <th>Принял(а)</th>
                    </tr>
                </thead>
            </table>
            <table border="2">
                <tbody>
                    <?php foreach ($arrivals as $arrival): ?>
                        <tr>
                            <td><a href="edit.php?arrival_id=<?=e($arrival['id'])?>"><?= e($arrival['date']) ?></a></td>
                            <td><?= e(Arrival::getCompanyNameByID($arrival['company_id'])) ?></td>
                            <td><?= e(Arrival::getSfProductNameByID($arrival['sf_product_id'])) ?></td>
                            <td class="td_num"><?= e($arrival['quantity']) ?></td>
                            <td><?= e(Arrival::getStuffNameByID($arrival['accepted_stuff_id'])) ?></td>
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