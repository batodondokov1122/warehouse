<?php

namespace App\Models;

use App\Database\Database;

class Arrival
{
    public ?string $date = '';
    public ?int $company_id = 0;
    public ?int $sf_product_id = 0;
    public ?int $quantity = 0;
    public ?int $accepted_stuff_id = 0;

    private $errors = [];

    public function __construct(array $data=[]){
        $this->fill($data);
    }

    public function fill(array $data = [])
    {
        if ($data)
        {          
            $this->date = $data['date'] ?? '';
            $this->company_id = $data['company_id'] ?? 0;
            $this->sf_product_id = $data['sf_product_id'] ?? 0;
            $this->quantity = $data['quantity'] ?? 0;
            $this->accepted_stuff_id = $data['accepted_stuff_id'] ?? 0;
        } 
    }

    public function validate() : bool{
        $this -> errors = [];

        // Проверка заполнености полей
        if (!$this -> date)
        {
            $this -> errors[]='Поле "Дата" не заполнено';
        }
        if ($this -> company_id == 0)
        {
            $this -> errors[]='Поле "Компания" не заполнено';
        }
        if (!$this -> sf_product_id)
        {
            $this -> errors[]='Поле "Полуфабрикат" не заполнено';
        }
        if ($this -> accepted_stuff_id == 0)
        {
            $this -> errors[]='Поле "Принял(а)" не заполнено';
        }

        return ! $this->hasErrors();
    }

    public function hasErrors() : bool{
        return ! empty($this->errors);
    }
    
    public function getErrors(): array{
        return $this->errors; 
    }

    public function saveArrival(){ 
        $sql = Database::prepare('INSERT INTO `sf_product_arrivals` (`date`, `company_id`, `sf_product_id`, `quantity`, `accepted_stuff_id`) 
        VALUES (:date, :company_id, :sf_product_id, :quantity, :accepted_stuff_id);');
        $sql->execute([
            'date'=>$this->date, 
            'company_id'=>$this->company_id, 
            'sf_product_id'=>$this->sf_product_id,
            'quantity'=>$this->quantity,
            'accepted_stuff_id'=>$this->accepted_stuff_id,
        ]);
    }

    public function updateArrival($arrival_id){ 
        $sql = Database::prepare('UPDATE `sf_product_arrivals`
        SET `date`= :date, 
        `company_id` = :company_id, 
        `sf_product_id` = :sf_product_id, 
        `quantity` = :quantity, 
        `accepted_stuff_id` = :accepted_stuff_id
        WHERE `id` = :arrival_id;');
        $sql->execute([
            'date'=>$this->date, 
            'company_id'=>$this->company_id,
            'sf_product_id'=>$this->sf_product_id, 
            'quantity'=>$this->quantity, 
            'accepted_stuff_id'=>$this->accepted_stuff_id, 
            'arrival_id'=>$arrival_id
        ]);
    }

    public static function getArrivals(){
        return Database::queryAll("
        SELECT *
        FROM `sf_product_arrivals`;");
    }

    public static function getArrivalById($id){
        return Database::query("
        SELECT *        
        FROM `sf_product_arrivals`
        WHERE `id` = " . $id . ";");
    }

    public static function getCompanies(): array
    {
        return Database::queryAll("
        SELECT `id`, `name`
        FROM `companies`;");
    }

    public static function getStuffNames(): array{
        return Database::queryAll("
        SELECT `id` , CONCAT(`last_name`, ' ', SUBSTRING(`first_name`, 1, 1), '.') AS `name`
        FROM staff;");
    }

    public static function getStuffNameByID($id){
        return Database::query("
        SELECT CONCAT(`last_name`, ' ', SUBSTRING(`first_name`, 1, 1), '.') AS `name`
        FROM staff
        WHERE `id` = " . $id . ";")['name'];
    }

    public static function getCompanyNameByID($id){
        return Database::query("
        SELECT `name`
        FROM `companies`
        WHERE `id` = " . $id . ";")['name'];
    }

    public static function getSfProductNameByID($id){
        return Database::query("
        SELECT `name`
        FROM `sf_products`
        WHERE `id` = " . $id . ";")['name'];
    }

}