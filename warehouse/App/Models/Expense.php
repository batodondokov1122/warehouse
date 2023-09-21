<?php

namespace App\Models;

use App\Database\Database;

class Expense
{
    public ?string $date = '';
    public ?int $stand_id = 0;
    public ?int $entity_id = 0;
    public ?int $sf_product_id = 0;
    public ?int $quantity = 0;
    public ?int $accepted_stuff_id = 0;
    public ?int $receiver_stuff_id = 0;

    private $errors = [];

    public function __construct(array $data=[]){
        $this->fill($data);
    }

    public function fill(array $data = [])
    {
        if ($data)
        {          
            $this->date = $data['date'] ?? '';
            $this->stand_id = $data['stand_id'] ?? 0;
            $this->entity_id = $data['entity_id'] ?? 0;
            $this->sf_product_id = $data['sf_product_id'] ?? 0;
            $this->quantity = $data['entity_id'] ?? 0;
            $this->accepted_stuff_id = $data['accepted_stuff_id'] ?? 0;
            $this->receiver_stuff_id = $data['receiver_stuff_id'] ?? 0;
        } 
    }

    public function validate() : bool{
        $this -> errors = [];

        // Проверка заполнености полей
        if (!$this -> date)
        {
            $this -> errors[]='Поле "Дата" не заполнено';
        }
        if ($this -> stand_id == 0)
        {
            $this -> errors[]='Поле "Стенд" не заполнено';
        }
        if ($this -> entity_id == 0)
        {
            $this -> errors[]='Поле "Сущность" не заполнено';
        }
        if (!$this -> sf_product_id)
        {
            $this -> errors[]='Поле "Компонент" не заполнено';
        }
        if ($this -> accepted_stuff_id == 0)
        {
            $this -> errors[]='Поле "Принял(а)" не заполнено';
        }
        if ($this -> receiver_stuff_id == 0)
        {
            $this -> errors[]='Поле "Кому" не заполнено';
        }

        return ! $this->hasErrors();
    }

    public function hasErrors() : bool{
        return ! empty($this->errors);
    }
    
    public function getErrors(): array{
        return $this->errors; 
    }

    public function saveExpense(){ 
        $sql = Database::prepare('INSERT INTO `sf_product_expenses` (`date`, `stand_id`, `entity_id`, `sf_product_id`, `quantity`, `accepted_stuff_id`, `receiver_stuff_id`) 
        VALUES (:date, :stand_id, :entity_id, :sf_product_id, :quantity, :accepted_stuff_id, :receiver_stuff_id);');
        $sql->execute([
            'date'=>$this->date, 
            'stand_id'=>$this->stand_id, 
            'entity_id'=>$this->entity_id, 
            'sf_product_id'=>$this->sf_product_id,
            'quantity'=>$this->quantity,
            'accepted_stuff_id'=>$this->accepted_stuff_id,
            'receiver_stuff_id'=>$this->receiver_stuff_id, 
        ]);
    }

    public function updateExpense($expense_id){ 
        $sql = Database::prepare('UPDATE `sf_product_expenses`
        SET `date`= :date, 
        `stand_id` = :stand_id, 
        `entity_id` = :entity_id, 
        `sf_product_id` = :sf_product_id, 
        `quantity` = :quantity, 
        `accepted_stuff_id` = :accepted_stuff_id, 
        `receiver_stuff_id` = :receiver_stuff_id
        WHERE `id` = :expense_id;');
        $sql->execute([
            'date'=>$this->date, 
            'stand_id'=>$this->stand_id,
            'entity_id'=>$this->entity_id,
            'sf_product_id'=>$this->sf_product_id, 
            'quantity'=>$this->quantity, 
            'accepted_stuff_id'=>$this->accepted_stuff_id, 
            'receiver_stuff_id'=>$this->receiver_stuff_id, 
            'expense_id'=>$expense_id
        ]);
    }

    public static function getExpenses(){
        return Database::queryAll("
        SELECT *
        FROM `sf_product_expenses`;");
    }

    public static function getExpenseById($id){
        return Database::query("
        SELECT *        
        FROM `sf_product_expenses`
        WHERE `id` = " . $id . ";");
    }

    public static function getStuffNameByID($id){
        return Database::query("
        SELECT CONCAT(`last_name`, ' ', SUBSTRING(`first_name`, 1, 1), '.') AS `name`
        FROM staff
        WHERE `id` = " . $id . ";")['name'];
    }

    public static function getStands(): array
    {
        return Database::queryAll("
        SELECT `id`, `name`
        FROM `stands`;");
    }

    public static function getEntitiesByStand($id): array
    {
        return Database::queryAll("
        SELECT `id`, `name`
        FROM `entities`
        WHERE `stand_id` = " . $id . ";");
    }

    public static function getSfProductsByEntity($id): array
    {
        return Database::queryAll("
        SELECT `id`, `name`
        FROM `sf_products`
        WHERE `entity_id` = " . $id . ";");
    }

    public static function getEntityById($id): array
    {
        return Database::query("
        SELECT `id`, `name`
        FROM `entities`
        WHERE `id` = " . $id . ";");
    }

    public static function getSfProductsById($id): array
    {
        return Database::query("
        SELECT `id`, `name`
        FROM `sf_products`
        WHERE `id` = " . $id . ";");
    }

    public static function getStandById($id): array
    {
        return Database::query("
        SELECT `id`, `name`
        FROM `stands`
        WHERE `id` = " . $id . ";");
    }

}