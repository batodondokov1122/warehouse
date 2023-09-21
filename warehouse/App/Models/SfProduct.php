<?php

namespace App\Models;

use App\Database\Database;

class SfProduct
{
    public ?string $name = '';
    public ?int $entity_id = 0;
    public ?int $subentity_id = 0;
    public ?string $article_number = '';
    public ?float $stand_quantity = 0.0;
    public ?float $quantity = 0.0;

    private $errors = [];

    public function __construct(array $data=[]){
        $this->fill($data);
    }

    public function fill(array $data = [])
    {
        if ($data)
        {          
            $this->name = $data['name'] ?? '';
            $this->entity_id = $data['entity_id'] ?? 0;
            $this->subentity_id = $data['subentity_id'] ?? '';
            $this->article_number = $data['article_number'] ?? '';
            $this->stand_quantity = $data['stand_quantity'] ?? '';
            $this->quantity = $data['quantity'] ?? 0;
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
        if ($this -> entity_id == 0)
        {
            $this -> errors[]='Поле "Сущность" не заполнено';
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

    public function saveSfProduct(){ 
        $sql = Database::prepare('INSERT INTO `sf_products` (`name`, `entity_id`, `subentity_id`, `article_number`, `stand_quantity`, `quantity`) 
        VALUES (:name,:entity_id, :subentity_id, :article_number, :stand_quantity, :quantity);');
        $sql->execute([
            'name'=>$this->name, 
            'entity_id'=>$this->entity_id, 
            'subentity_id'=>$this->subentity_id,
            'article_number'=>$this->article_number,
            'stand_quantity'=>$this->stand_quantity,
            'quantity'=>$this->quantity, 
        ]);
    }

    public function updateSfProduct($sf_product_id){ 
        $sql = Database::prepare('UPDATE `sf_products`
        SET `name`= :name, 
        `entity_id` = :entity_id, 
        `subentity_id` = :subentity_id, 
        `article_number` = :article_number, 
        `stand_quantity` = :stand_quantity, 
        `quantity` = :quantity
        WHERE `id` = :sf_product_id;');
        $sql->execute([
            'name'=>$this->name, 
            'entity_id'=>$this->entity_id,
            'subentity_id'=>$this->subentity_id, 
            'article_number'=>$this->article_number, 
            'stand_quantity'=>$this->stand_quantity, 
            'quantity'=>$this->quantity,
            'sf_product_id'=>$sf_product_id
        ]);
    }

    public static function getEntities(): array
    {
        return Database::queryAll("
        SELECT `id`, `name`
        FROM `entities`;");
    }

    public static function getSubEntitiesById($id): array
    {
        return Database::queryAll("
        SELECT `id`, `name`
        FROM `subentities`
        WHERE `entity_id` = " . $id . ";");
    }

    public static function getSfProducts(){
        return Database::queryAll("
        SELECT `id`, `name`, `article_number`, `stand_quantity`, `quantity`
        FROM `sf_products`;");
    }

    public static function getSfProductsWithFilters($filters){
        if (array_key_exists("entity_id", $filters) && array_key_exists("subentity_id", $filters) > 0) {
            $filters_str = "`entity_id` = " . $filters['entity_id'] . " AND `subentity_id` = " . $filters['subentity_id'];
        }
        if (array_key_exists("entity_id", $filters) && array_key_exists("subentity_id", $filters) == 0) {
            $filters_str = "`entity_id` = " . $filters['entity_id'];
        }
        return Database::queryAll("
        SELECT `id`, `name`, `article_number`, `stand_quantity`, `quantity`
        FROM `sf_products`
        WHERE" . $filters_str . ";");
    }
}