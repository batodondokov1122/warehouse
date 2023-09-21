<?php

include '../App/Etc/init.php';

use \App\Models\Component;

if ($_GET)
{
    if (!empty($_GET['category_id'])){
        $index = $_GET['category_id'];
        $subcategories = Component::getSubCategoriesById($index);
        if ($subcategories)
        {
            $result = [];
            foreach ($subcategories as $subcategory) {
                $result[$subcategory['id']] = $subcategory['name'];
            }
            echo json_encode($result);
        }
        else
        {
            echo json_encode(0);
        }
    }

    if (!empty($_GET['stand_id'])){
        $index = $_GET['stand_id'];
        $substands = Component::getSubStandsById($index);
        if ($substands)
        {
            $result = [];
            foreach ($substands as $substand) {
                $result[$substand['id']] = $substand['name'];
            }
            echo json_encode($result);
        }
        else
        {
            echo json_encode(0);
        }
    }

}