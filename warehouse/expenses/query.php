<?php

include '../App/Etc/init.php';

use \App\Models\Expense;

if ($_GET)
{
    if (!empty($_GET['stand_id'])){
        $index = $_GET['stand_id'];
        $entities = Expense::getEntitiesByStand($index);
        if ($entities)
        {
            $result = [];
            foreach ($entities as $entity) {
                $result[$entity['id']] = $entity['name'];
            }
            echo json_encode($result);
        }
        else
        {
            echo json_encode(0);
        }
    }

    if (!empty($_GET['entity_id'])){
        $index = $_GET['entity_id'];
        $sf_products = Expense::getSfProductsByEntity($index);
        if ($sf_products)
        {
            $result = [];
            foreach ($sf_products as $sf_product) {
                $result[$sf_product['id']] = $sf_product['name'];
            }
            echo json_encode($result);
        }
        else
        {
            echo json_encode(0);
        }
    }

}