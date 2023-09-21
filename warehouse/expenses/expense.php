<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF_8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/expense.css">
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <title>Расход</title>
</head>
<body>
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
                    <a href="../components/index.html"><li>Общий список</li></a>
                </ul>
            </li>
            <li>
                <div class="li">ПОЛУФАБРИКАТЫ
                    <img src="../images/chevron-down.svg" alt="chevron-down" class="down">
                </div>
                <ul class="sub_ul closed">
                    <a href="../sf-products/list.html"><li>Общий список</li></a>
                    <a href="#"><li>Ячейки</li></a>
                    <a href="../sf-products/expense.html"><li>Расход</li></a>
                    <a href="../sf-products/arrival.html"><li>Приход</li></a>
                </ul>
            </li>
        </ul>
    </nav>
    <main>
        <ul class="breadcrumb">
            <li>Полуфабрикаты</li>
            <li>Расход</li>
        </ul>
        <div class="table">
            <table border="2">
                <thead>
                    <tr>
                        <th class="th_num">Дата</th>
                        <th>Стенд</th>
                        <th>Сущность</th>
                        <th>Компонент</th>
                        <th class="th_num">КВО</th>
                        <th>Принял(а)</th>
                        <th>Кому</th>
                    </tr>
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