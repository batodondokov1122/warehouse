<?php

include '../App/Etc/init.php';

use \App\Models\SfProduct;

if ($_GET)
{
    if (!empty($_GET['entity_id'])){
        $index = $_GET['entity_id'];
        $subentities = SfProduct::getSubEntitiesById($index);
        if ($subentities)
        {
            $result = [];
            foreach ($subentities as $subentity) {
                $result[$subentity['id']] = $subentity['name'];
            }
            echo json_encode($result);
        }
        else
        {
            echo json_encode(0);
        }
    }
}