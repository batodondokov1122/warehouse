<?php
    include '../App/Etc/init.php';

    use \App\Models\SfProduct;

    $entities = SfProduct::getEntities();
    $filters = [];

    if ($_GET){
        if (!empty($_GET['entity_id'])){
            $filters['entity_id'] = $_GET['entity_id'];
            $subentities = SfProduct::getSubEntitiesById($filters['entity_id']);
        }
        if (!empty($_GET['stand_id'])){
            $filters['stand_id'] = $_GET['stand_id'];
            $substands = Component::getSubStandsById($filters['stand_id']);
        }
        if (!empty($_GET['subentity_id'])){
            $filters['subentity_id'] = $_GET['subentity_id'];
        }
        if (!empty($_GET['substand_id'])){
            $filters['substand_id'] = $_GET['substand_id'];
        }
        $sf_products = SfProduct::getSfProductsWithFilters($filters);
        $filter_icon_src = "../images/filter-icon-active.svg";
    }else{
        $sf_products = SfProduct::getSfProducts();
        $filter_icon_src = "../images/filter-icon.png";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF_8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/sf-product-list.css">
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Общий список</title>
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
            <li>Общий список</li>
        </ul>
        <div class="buttons">
            <img src="<?= $filter_icon_src ?>" alt="plus icon" class="filter_icon">
            <a href="add.php"><img src="../images/plus-circle.svg" alt="plus icon"></a>
        </div>
        <div class="hidden_filter_block closed">
            <form action="" method="get">
                <div class="filters">
                    <div class="two_filters_block">
                        <div class="filter">
                            <label class="filter_label">По сущности</label>
                            <select name="entity_id" class="filter_select" id="entity_id">
                                <option selected disabled></option>
                                <?php foreach ($entities as $entity):?>
                                    <option value ="<?php echo($entity['id']) ?>"<?php
                                    if (array_key_exists("entity_id", $filters) && $filters['entity_id'] != NULL){
                                        echo($filters['entity_id'] == $entity['id'] ? 'selected' : '');
                                    }
                                ?>><?= e($entity['name']) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="filter">
                            <label class="filter_label">По подсущности</label>
                            <select name="subentity_id" id="subentity_id"class="filter_select">
                                <option selected disabled></option>
                                <?php foreach ($subentities as $subentity):?>
                                    <option value ="<?php echo($subentity['id']) ?>"<?php
                                    if (array_key_exists("subentity_id", $filters) && $filters['subentity_id'] != NULL){
                                        echo($filters['subentity_id'] == $subentity['id'] ? 'selected' : '');
                                    }
                                ?>><?= e($subentity['name']) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="filter_buttons_block">
                    <a href="list.php" class="filter_button"><div id="reset_filters">СБРОСИТЬ</div></a>
                    <button type="submit" class="filter_button">ПРИМЕНИТЬ</button>
                </div>
            </form>
        </div>
        <div class="table">
            <table border="2">
                <thead>
                    <tr>
                        <th>Деталь</th>
                        <th>Артикул</th>
                        <th class="th_num">КВО в стенде</th>
                        <th class="th_num">Общая сумма на складе</th>
                    </tr>
                </thead>
            </table>
            <table border="2">
                <tbody>
                    <?php foreach ($sf_products as $sf_product): ?>
                        <tr>
                            <td><a href="edit.php?sf_product_id=<?=e($sf_product['id'])?>"><?= e($sf_product['name']) ?></a></td>
                            <td><?= e($sf_product['article_number']) ?></td>
                            <td class="td_num"><?= e($sf_product['stand_quantity']) ?></td>
                            <td class="td_num"><?= e($sf_product['quantity']) ?></td>
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