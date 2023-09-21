<?php
    include '../App/Etc/init.php';

    use \App\Models\Component;

    $categories = Component::getCategories();
    $stands = Component::getstands();
    $filters = [];

    if ($_GET){
        if (!empty($_GET['category_id'])){
            $filters['category_id'] = $_GET['category_id'];
            $subcategories = Component::getSubCategoriesById($filters['category_id']);
        }
        if (!empty($_GET['stand_id'])){
            $filters['stand_id'] = $_GET['stand_id'];
            $substands = Component::getSubStandsById($filters['stand_id']);
        }
        if (!empty($_GET['subcategory_id'])){
            $filters['subcategory_id'] = $_GET['subcategory_id'];
        }
        if (!empty($_GET['substand_id'])){
            $filters['substand_id'] = $_GET['substand_id'];
        }
        $components = Component::getComponentsWithFilters($filters);
        $filter_icon_src = "../images/filter-icon-active.svg";
    }else{
        $components = Component::getComponents();
        $filter_icon_src = "../images/filter-icon.png";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF_8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
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
                            <label class="filter_label">По категории</label>
                            <select name="category_id" id="category_id" class="filter_select">
                                <option selected disabled></option>
                                <?php foreach ($categories as $category): ?>
                                    <option value ="<?php echo($category['id']) ?>"<?php
                                    if (array_key_exists("category_id", $filters) && $filters['category_id'] != 0)
                                    {
                                        echo($filters['category_id'] == $category['id'] ? 'selected' : '');
                                    }
                                    ?>><?= e($category['name']) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="filter">
                            <label class="filter_label">По подкатегории</label>
                            <select name="subcategory_id" id="subcategory_id" class="filter_select">
                                <option selected disabled></option>
                                <?php foreach ($subcategories as $subcategory):?>
                                    <option value ="<?php echo($subcategory['id']) ?>"<?php
                                    if (array_key_exists("subcategory_id", $filters) && $filters['subcategory_id'] != 0){
                                        echo($filters['subcategory_id'] == $subcategory['id'] ? 'selected' : '');
                                    }
                                ?>><?= e($subcategory['name']) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="two_filters_block">
                        <div class="filter">
                            <label class="filter_label">По стенду</label>
                            <select name="stand_id" id="stand_id"class="filter_select">
                                <option selected disabled></option>
                                <?php foreach ($stands as $stand): ?>
                                    <option value ="<?php echo($stand['id']) ?>"<?php
                                    if (array_key_exists("stand_id", $filters) && $filters['stand_id'] != 0)
                                    {
                                        echo($filters['stand_id'] == $stand['id'] ? 'selected' : '');
                                    }
                                    ?>><?= e($stand['name']) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="filter">
                            <label class="filter_label">По подстенду</label>
                            <select name="substand_id" id="substand_id"class="filter_select">
                                <option selected disabled></option>
                                <?php foreach ($substands as $substand):?>
                                    <option value ="<?php echo($substand['id']) ?>"<?php
                                    if (array_key_exists("substand_id", $filters) && $filters['substand_id'] != 0){
                                        echo($filters['substand_id'] == $substand['id'] ? 'selected' : '');
                                    }
                                ?>><?= e($substand['name']) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="filter_buttons_block">
                    <a href="index.php" class="filter_button"><div id="reset_filters">СБРОСИТЬ</div></a>
                    <button type="submit" class="filter_button">ПРИМЕНИТЬ</button>
                </div>
            </form>
        </div>
        <div class="table">
            <table border="2">
                <thead>
                    <tr>
                        <th>Название и спецификация</th>
                        <th>Артикул</th>
                        <th class="th_num">КВО ИЭС</th>
                        <th class="th_num">КВО БТС</th>
                        <th class="th_num">Приход</th>
                        <th class="th_num">Расход</th>
                        <th class="th_num">Осталось</th>
                    </tr>
                </thead>
            </table>
            <table border="2">
                <tbody>
                    <?php foreach ($components as $component): ?>
                        <tr>
                            <td><a href="edit.php?component_id=<?=e($component['id'])?>"><?= e($component['name']) ?></a></td>
                            <td><?= e($component['article_number']) ?></td>
                            <td class="td_num"><?= e($component['IES_quantity']) ?></td>
                            <td class="td_num"><?= e($component['BTS_quantity']) ?></td>
                            <td class="td_num"><?= e($component['arrival']) ?></td>
                            <td class="td_num"><?= e($component['expense']) ?></td>
                            <td class="td_num"><?= e($component['stock_balance']) ?></td>
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