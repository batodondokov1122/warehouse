DROP DATABASE warehouse;
CREATE DATABASE warehouse;
USE warehouse;

---------------------------------------------------------------

DROP TABLE IF EXISTS `roles`; 
CREATE TABLE IF NOT EXISTS `roles` ( 
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
);

INSERT INTO `roles` (`name`)
VALUES ('admin'), ('worker'), ('receiver');

---------------------------------------------------------------

DROP TABLE IF EXISTS `staff`; 
CREATE TABLE IF NOT EXISTS `staff` ( 
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `role_id` INT UNSIGNED NOT NULL, 
    PRIMARY KEY (`id`),
    FOREIGN KEY (`role_id`)  REFERENCES `roles` (`id`)
);

INSERT INTO `staff` (`first_name`, `last_name`, `role_id`)
VALUES ('Бато', 'Дондоков', 1 ),
('Александра', 'Куставинова', 2 );


--------------------------------------------------------------

DROP TABLE IF EXISTS `categories`; 
CREATE TABLE IF NOT EXISTS `categories` ( 
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
);

INSERT INTO `categories` (`name`)
VALUES ('Сетевое оборудование'), 
('Электротехника'), 
('Механические компоненты'),
('Микросхемы, контроллеры'),
('Компьютерные компоненты '),
('Компьютерные провода'),
('Уголки/прутки'),
('Конструкционный профиль/крепеж'),
('Провода/кабели'),
('Листовые материалы'),
('Строительные материалы'),
('Контейнеры'),
('Расходники'),
('Заказы');

---------------------------------------------------------------

DROP TABLE IF EXISTS `subcategories`; 
CREATE TABLE IF NOT EXISTS `subcategories` ( 
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`)  REFERENCES `categories` (`id`)
);

INSERT INTO `subcategories` (`name`, `category_id`)
VALUES ('Блоки питания', 2), 
('Компоненты - разъемы, штекеры, коннекторы, шлейфы',2),
('Лампы, переключатели, диф.автоматы', 2),
('Кромочник', 13),
('3d - принтеры', 13),
('Принтеры', 13),
('Краска', 13), 
('Крепеж', 13),
('Упаковка', 13),
('Типография', 14),
('Изготовление', 14),
('Платы', 14);

---------------------------------------------------------------

DROP TABLE IF EXISTS `components`; 
CREATE TABLE IF NOT EXISTS `components` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `article_number` VARCHAR(255) NOT NULL,
    `link` VARCHAR(255),
    `category_id` INT UNSIGNED NOT NULL,
    `subcategory_id` INT UNSIGNED,
    `contractor` VARCHAR(255),
    `stand_description` VARCHAR(255),
    `purpose` VARCHAR(255),
    `type` VARCHAR(255),
    `IES_quantity` FLOAT UNSIGNED DEFAULT 0.0,
    `BTS_quantity` FLOAT UNSIGNED DEFAULT 0.0,
    `OVKS_quantity` FLOAT UNSIGNED DEFAULT 0.0,
    `UNKS_quantity` FLOAT UNSIGNED DEFAULT 0.0,
    `start_quantity` FLOAT UNSIGNED DEFAULT 0.0,
    `min_quantity` FLOAT UNSIGNED DEFAULT 0.0,
    `arrival` FLOAT UNSIGNED DEFAULT 0.0,
    `expense` FLOAT UNSIGNED DEFAULT 0.0,
    `stock_balance` FLOAT UNSIGNED DEFAULT 0.0,
    `reserve_IES` FLOAT UNSIGNED DEFAULT 0.0,
    `reserve_BTS` FLOAT UNSIGNED DEFAULT 0.0,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`)  REFERENCES `categories` (`id`),
    FOREIGN KEY (`subcategory_id`)  REFERENCES `subcategories` (`id`)
);

INSERT INTO `warehouse_components` (`name+specification`, `article_number`, `link`, 
`categorie_id`, `subcategorie_id`, `contractor`, `components_quantity`, 
`stand_description`, `purpose`, `type`, `IES_quantity`, `BTS_quantity`, `OVKS_quantity`, 
`UNKS_quantity`, `start_quantity`, `min_quantity`, `arrival`, `expense`, `stock_balance`,
`reserve_IES`, `reserve_BTS`)
VALUES ('Шкаф телекоммуникационный настенный 9U (600 × 650) дверь металл', 'ШРН-Э-9.650.1',
NULL, )

---------------------------------------------------------------
---------------------------------------------------------------

DROP TABLE IF EXISTS `stands`; 
CREATE TABLE IF NOT EXISTS `stands` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    PRIMARY KEY (`id`)
);
INSERT INTO `stands` (`name`)
VALUES ('ИЭС'),
('БТС');


---------------------------------------------------------------

DROP TABLE IF EXISTS `substands`; 
CREATE TABLE IF NOT EXISTS `substands` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `stand_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`stand_id`)  REFERENCES `stands` (`id`)
);
INSERT INTO `substands` (`name`, `stand_id`)
VALUES ('ОВКС', 2),
('УНКС', 2);

---------------------------------------------------------------

DROP TABLE IF EXISTS `entities`; 
CREATE TABLE IF NOT EXISTS `entities` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `stand_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`stand_id`)  REFERENCES `stands` (`id`)
);
INSERT INTO `entities` (`name`, `stand_id`)
VALUES ('Объекты без эл.компонентов', '1'),
('Объекты с эл.компонентами', '1'), 
('Вентилятор', '1'),
('Шкаф', '1'),
('Крепеж и Комплектующие', '1'),
('Светильник', '1');

---------------------------------------------------------------

DROP TABLE IF EXISTS `subentities`; 
CREATE TABLE IF NOT EXISTS `subentities` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `entity_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`entity_id`)  REFERENCES `entities` (`id`)
);
INSERT INTO `subentities` (`name`, `entity_id`)
VALUES ('Макеты', 1), 
('Основания', 1),
('Днища', 1),
('Столбики', 1),
('Элементы', 1),
('Модули', 1),
('Платы', 1),
('Эл. Узлы', 1),
('СЭС', 2),
('ВЭС', 2),
('Дизель', 2),
('Аккумулятор', 2),
('Элементы', 3),
('Эл. Узлы', 3),
('Корпус', 4),
('Элементы', 4),
('Платы', 4),
('Эл. Узлы', 4);

---------------------------------------------------------------

DROP TABLE IF EXISTS `sf_products`;
CREATE TABLE IF NOT EXISTS `sf_products` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `entity_id` INT UNSIGNED NOT NULL,
    `subentity_id` INT UNSIGNED,
    `article_number` VARCHAR(255) NOT NULL,
    `stand_quantity` INT UNSIGNED NOT NULL,
    `quantity` INT UNSIGNED,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`entity_id`)  REFERENCES `entities` (`id`),
    FOREIGN KEY (`subentity_id`)  REFERENCES `subentities` (`id`)
);

----------------------------------------------------------------

DROP TABLE IF EXISTS `sf_product_expenses`; 
CREATE TABLE IF NOT EXISTS `sf_product_expenses` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `date` DATE NOT NULL,
    `stand_id` INT UNSIGNED NOT NULL,
    `entity_id` INT UNSIGNED NOT NULL,
    `sf_product_id` INT UNSIGNED NOT NULL,
    `quantity` INT UNSIGNED NOT NULL,
    `accepted_stuff_id` INT UNSIGNED,
    `receiver_stuff_id` INT UNSIGNED,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`stand_id`)  REFERENCES `stands` (`id`),
    FOREIGN KEY (`entity_id`)  REFERENCES `entities` (`id`),
    FOREIGN KEY (`sf_product_id`)  REFERENCES `sf_products` (`id`),
    FOREIGN KEY (`accepted_stuff_id`)  REFERENCES `staff` (`id`),
    FOREIGN KEY (`receiver_stuff_id`)  REFERENCES `staff` (`id`)
);

INSERT INTO `expenses` (`date`, `stend_id`, `entity_id`, `component_id`, `quantity`, `accepted_stuff_id`, `whom_stuff_id`)
VALUES ('26.03.2002', 1, 1, 1, 2, 1, 1);

---------------------------------------------------------------

DROP TABLE IF EXISTS `companies`; 
CREATE TABLE IF NOT EXISTS `companies` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    PRIMARY KEY (`id`)
);
INSERT INTO `companies` (`name`)
VALUES ('Инсайт'),
('Полюс-НТ'),
('ИнСитиЛаб');

---------------------------------------------------------------

DROP TABLE IF EXISTS `sf_product_arrivals`; 
CREATE TABLE IF NOT EXISTS `sf_product_arrivals` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `date` DATE NOT NULL,
    `company_id` INT UNSIGNED NOT NULL,
    `sf_product_id` INT UNSIGNED NOT NULL,
    `quantity` INT UNSIGNED NOT NULL,
    `accepted_stuff_id` INT UNSIGNED,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`company_id`)  REFERENCES `companies` (`id`),
    FOREIGN KEY (`sf_product_id`)  REFERENCES `sf_products` (`id`),
    FOREIGN KEY (`accepted_stuff_id`)  REFERENCES `staff` (`id`)
);
INSERT INTO `arrivals` (`date`, `company_id`, `component_id`, `quantity`, `accepted_stuff_id`)
VALUES (CURRENT_DATE, 1, 1, 10, 1),
(CURRENT_DATE, 3, 1, 10, 2);

---------------------------------------------------------------

DROP TABLE IF EXISTS `cells`;
CREATE TABLE IF NOT EXISTS `cells` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `sf_product_id` INT UNSIGNED NOT NULL,
    `quantity` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`sf_product_id`)  REFERENCES `sf_products` (`id`)
);

INSERT INTO container(`semi-finished_product_id`, `quantity`, `status`)
VALUES (1, 10, 0),
(2, 3, 1),
(3, 12, 0),
(4, 1, 1),

---------------------------------------------------------------

CREATE TRIGGER status_update
AFTER INSERT ON `warehouse_components`
FOR EACH ROW
UPDATE `containers`
SET `status` = (SELECT `status` FROM `accounting_records` ORDER BY id DESC LIMIT 1)
WHERE `id` = (SELECT `container_id` FROM `accounting_records` ORDER BY id DESC LIMIT 1);



SELECT CONCAT(`second_name`, ' ', SUBSTRING(`first_name`, 1, 1), '.') AS `name`
FROM staff;
