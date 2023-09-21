<?php

namespace App\Models;

use App\Database\Database;

class Component
{
    public ?string $name = '';
    public ?string $article_number = '';
    public ?string $link = '';
    public ?int $category_id = 0;
    public ?int $subcategory_id = 0;
    public ?string $contractor = '';
    public ?string $stand_description = '';
    public ?string $purpose = '';
    public ?string $type = '';
    public ?float $IES_quantity = 0.0;
    public ?float $BTS_quantity = 0.0;
    public ?float $OVKS_quantity = 0.0;
    public ?float $UNKS_quantity = 0.0;    
    public ?float $start_quantity = 0.0;
    public ?float $min_quantity = 0.0;
    public ?float $arrival = 0.0;
    public ?float $expense = 0.0;
    public ?float $stock_balance = 0.0;
    public ?float $reserve_IES = 0.0;
    public ?float $reserve_BTS = 0.0;

    private $errors = [];

    public function __construct(array $data=[])
    {
        $this->fill($data);
    }

    public function fill(array $data = [])
    {
        if ($data)
        {          
            $this->name = $data['name'] ?? '';
            $this->article_number = $data['article_number'] ?? '';
            $this->link = $data['link'] ?? '';
            $this->category_id = $data['category_id'] ?? 0;
            $this->subcategory_id = $data['subcategory_id'] ?? 0;
            $this->contractor = $data['contractor'] ?? '';
            $this->stand_description = $data['stand_description'] ?? '';
            $this->purpose = $data['purpose'] ?? '';
            $this->type = $data['type'] ?? '';
            $this->IES_quantity = floatval($data['IES_quantity']) ?? 0.0;
            $this->BTS_quantity = floatval($data['BTS_quantity']) ?? 0.0;
            $this->OVKS_quantity = floatval($data['OVKS_quantity']) ?? 0.0;
            $this->UNKS_quantity = floatval($data['UNKS_quantity']) ?? 0.0;    
            $this->start_quantity = floatval($data['start_quantity']) ?? 0.0;
            $this->min_quantity = floatval($data['min_quantity']) ?? 0.0;
        } 
    }

    public function validate() : bool
    {
        $this -> errors = [];

        // Проверка заполнености полей
        if (!$this -> name)
        {
            $this -> errors[]='Поле "Название + спецификация" не заполнено';
        }
        if (!$this -> article_number)
        {
            $this -> errors[]='Поле "Артикул" не заполнено';
        }
        if ($this -> category_id == 0)
        {
            $this -> errors[]='Поле "Категория" не заполнено';
        }

        return ! $this->hasErrors();
    }

    public function hasErrors() : bool
    {
        return ! empty($this->errors);
    }
    
    public function getErrors() : array
    {
        return $this->errors; 
    }

    public function saveComponent(){ 
        $sql = Database::prepare('INSERT INTO `components` (`name`, `article_number`, `link`, 
        `category_id`, `subcategory_id`, `contractor`, 
        `stand_description`, `purpose`, `type`, `IES_quantity`, `BTS_quantity`, `OVKS_quantity`, 
        `UNKS_quantity`, `start_quantity`, `min_quantity`, `stock_balance`, `reserve_IES`, `reserve_BTS`) 
        VALUES (:name, :article_number, :link, :category_id, :subcategory_id, :contractor,
        :stand_description, :purpose, :type, :IES_quantity, :BTS_quantity, :OVKS_quantity, :UNKS_quantity,
        :start_quantity, :min_quantity, :stock_balance, :reserve_IES, :reserve_BTS);');
        $sql->execute([
            'name'=>$this->name, 
            'article_number'=>$this->article_number,
            'link'=>$this->link,
            'category_id'=>$this->category_id, 
            'subcategory_id'=>($this->subcategory_id != 0) ? $this->subcategory_id  : NULL, 
            'contractor'=>$this->contractor, 
            'stand_description'=>$this->stand_description, 
            'purpose'=>$this->purpose, 
            'type'=>$this->type, 
            'IES_quantity'=>$this->IES_quantity, 
            'BTS_quantity'=>$this->BTS_quantity, 
            'OVKS_quantity'=>$this->OVKS_quantity, 
            'UNKS_quantity'=>$this->UNKS_quantity, 
            'start_quantity'=>$this->start_quantity, 
            'min_quantity'=>$this->min_quantity,
            'stock_balance'=>$this->start_quantity,
            'reserve_IES'=>$this->IES_quantity * 10.0, 
            'reserve_BTS'=>$this->BTS_quantity
        ]);
    }

    public function updateComponent($component_id){ 
        $sql = Database::prepare('UPDATE `components`
        SET `name`= :name, 
        `article_number` = :article_number, 
        `link` = :link, 
        `category_id` = :category_id, 
        `subcategory_id` = :subcategory_id, 
        `contractor` = :contractor, 
        `stand_description` = :stand_description, 
        `purpose` = :purpose, 
        `type` = :type, 
        `IES_quantity` = :IES_quantity, 
        `BTS_quantity` = :BTS_quantity, 
        `OVKS_quantity` = :OVKS_quantity, 
        `UNKS_quantity` = :UNKS_quantity, 
        `start_quantity` = :start_quantity, 
        `min_quantity` = :min_quantity, 
        `stock_balance` = :stock_balance, 
        `reserve_IES` = :reserve_IES, 
        `reserve_BTS` = :reserve_BTS
        WHERE `id` = :component_id;');
        $sql->execute([
            'name'=>$this->name, 
            'article_number'=>$this->article_number,
            'link'=>$this->link,
            'category_id'=>$this->category_id, 
            'subcategory_id'=>$this->subcategory_id, 
            'contractor'=>$this->contractor, 
            'stand_description'=>$this->stand_description, 
            'purpose'=>$this->purpose, 
            'type'=>$this->type, 
            'IES_quantity'=>$this->IES_quantity, 
            'BTS_quantity'=>$this->BTS_quantity, 
            'OVKS_quantity'=>$this->OVKS_quantity, 
            'UNKS_quantity'=>$this->UNKS_quantity, 
            'start_quantity'=>$this->start_quantity, 
            'min_quantity'=>$this->min_quantity,
            'stock_balance'=>$this->start_quantity,
            'reserve_IES'=>$this->IES_quantity * 10.0, 
            'reserve_BTS'=>$this->BTS_quantity,
            'component_id'=>$component_id
        ]);
    }

    public static function getCategories(): array
    {
        return Database::queryAll("
        SELECT `id`, `name`
        FROM `categories`;");
    }

    public static function getSubCategoriesById($id): array
    {
        return Database::queryAll("
        SELECT `id`, `name`
        FROM `subcategories`
        WHERE `category_id` = " . $id . ";");
    }

    public static function getStands(): array
    {
        return Database::queryAll("
        SELECT `id`, `name`
        FROM `stands`;");
    }

    public static function getSubStandsById($id): array
    {
        return Database::queryAll("
        SELECT `id`, `name`
        FROM `substands`
        WHERE `stand_id` = " . $id . ";");
    }

    public static function getComponents(){
        return Database::queryAll("
        SELECT `id`, `name`, `article_number`, `IES_quantity`, `BTS_quantity`, `arrival`, `expense`, `stock_balance`
        FROM `components`;");
    }

    public static function getComponentById($component_id){
        return Database::query("
        SELECT *        
        FROM `components`
        WHERE `id` = " . $component_id . ";");
    }

    public static function getComponentsWithFilters($filters){
        if (array_key_exists("category_id", $filters) && array_key_exists("subcategory_id", $filters) && array_key_exists("stand_id", $filters) && $filters['stand_id'] == 1) {
            $filters_str = "`category_id` = " . $filters['category_id'] . " AND `subcategory_id` = " . $filters['subcategory_id'] . " AND `IES_quantity` > 0.0";
        }
        if (array_key_exists("category_id", $filters) && array_key_exists("subcategory_id", $filters) && array_key_exists("stand_id", $filters) && $filters['stand_id'] == 2 && array_key_exists("substand_id", $filters) && $filters['substand_id'] == 1) {
            $filters_str = "`category_id` = " . $filters['category_id'] . " AND `subcategory_id` = " . $filters['subcategory_id'] . " AND `BTS_quantity` > 0.0 AND `OVKS_quantity` > 0.0";
        }
        if (array_key_exists("category_id", $filters) && array_key_exists("subcategory_id", $filters) && array_key_exists("stand_id", $filters) && $filters['stand_id'] == 2 && array_key_exists("substand_id", $filters) && $filters['substand_id'] == 2) {
            $filters_str = "`category_id` = " . $filters['category_id'] . " AND `subcategory_id` = " . $filters['subcategory_id'] . " AND `BTS_quantity` > 0.0 AND `UNKS_quantity` > 0.0";
        }
        if (array_key_exists("category_id", $filters) && array_key_exists("subcategory_id", $filters) && array_key_exists("stand_id", $filters) && $filters['stand_id'] == 2 && !array_key_exists("substand_id", $filters)) {
            $filters_str = "`category_id` = " . $filters['category_id'] . " AND `subcategory_id` = " . $filters['subcategory_id'] . " AND `BTS_quantity` > 0.0 ";
        }
        if (array_key_exists("category_id", $filters) && !array_key_exists("subcategory_id", $filters) && array_key_exists("stand_id", $filters) && $filters['stand_id'] == 1) {
            $filters_str = "`category_id` = " . $filters['category_id'] . " AND `IES_quantity` > 0.0";
        }
        if (array_key_exists("category_id", $filters) && !array_key_exists("subcategory_id", $filters) && array_key_exists("stand_id", $filters) && $filters['stand_id'] == 2 && array_key_exists("substand_id", $filters) && $filters['substand_id'] == 1) {
            $filters_str = "`category_id` = " . $filters['category_id'] . " AND `BTS_quantity` > 0.0 AND `OVKS_quantity` > 0.0";
        }
        if (array_key_exists("category_id", $filters) && !array_key_exists("subcategory_id", $filters) && array_key_exists("stand_id", $filters) && $filters['stand_id'] == 2 && array_key_exists("substand_id", $filters) && $filters['substand_id'] == 2) {
            $filters_str = "`category_id` = " . $filters['category_id'] . " AND `BTS_quantity` > 0.0 AND `UNKS_quantity` > 0.0";
        }
        if (array_key_exists("category_id", $filters) && !array_key_exists("subcategory_id", $filters) && array_key_exists("stand_id", $filters) && $filters['stand_id'] == 2 && !array_key_exists("substand_id", $filters)) {
            $filters_str = "`category_id` = " . $filters['category_id'] . " AND `BTS_quantity` > 0.0 ";
        }
        if (!array_key_exists("category_id", $filters) && !array_key_exists("subcategory_id", $filters) && array_key_exists("stand_id", $filters) && $filters['stand_id'] == 1) {
            $filters_str = "`IES_quantity` > 0.0";
        }
        if (!array_key_exists("category_id", $filters) && !array_key_exists("subcategory_id", $filters) && array_key_exists("stand_id", $filters) && $filters['stand_id'] == 2 && !array_key_exists("substand_id", $filters)) {
            $filters_str = "`BTS_quantity` > 0.0 ";
        }
        if (!array_key_exists("category_id", $filters) && !array_key_exists("subcategory_id", $filters) && array_key_exists("stand_id", $filters) && $filters['stand_id'] == 2 && array_key_exists("substand_id", $filters) && $filters['substand_id'] == 1) {
            $filters_str = "`BTS_quantity` > 0.0 AND `OVKS_quantity` > 0.0";
        }
        if (!array_key_exists("category_id", $filters) && !array_key_exists("subcategory_id", $filters) && array_key_exists("stand_id", $filters) && $filters['stand_id'] == 2 && array_key_exists("substand_id", $filters) && $filters['substand_id'] == 2) {
            $filters_str = "`BTS_quantity` > 0.0 AND `UNKS_quantity` > 0.0";
        }
        if (array_key_exists("category_id", $filters) && array_key_exists("subcategory_id", $filters) && !array_key_exists("stand_id", $filters)) {
            $filters_str = "`category_id` = " . $filters['category_id'] . " AND `subcategory_id` = " . $filters['subcategory_id'];
        }
        if (array_key_exists("category_id", $filters) && !array_key_exists("subcategory_id", $filters) && !array_key_exists("stand_id", $filters)) {
            $filters_str = "`category_id` = " . $filters['category_id'];
        }

        return Database::queryAll("
        SELECT `id`, `name`, `article_number`, `IES_quantity`, `BTS_quantity`, `arrival`, `expense`, `stock_balance`
        FROM `components`
        WHERE" . $filters_str . ";");
    }
}