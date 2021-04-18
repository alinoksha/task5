<?php
class Country
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    /**
     * Добавляет страну в БД
     * @param Array $data Данные о стране
     */
    public function add($data)
    {
        $data['name'] = $this->db->prepare($data['name']);
        $data['code'] = $this->db->prepare($data['code']);
        if (!$this->getByName($data['name'])) {
            $sql = "INSERT INTO `country`(`name`, `code`) VALUES('{$data['name']}', '{$data['code']}')";
            $this->db->query($sql);
            return true;
        }
        return false;
    }
    /**
     * Возвращает список стран
     * @return Array Список всех стран в БД
     */
    public function list()
    {
        $countries = [];
        $sql = 'SELECT * FROM `country`';
        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            $countries[] = $row;
        }
        return $countries;
    }
    /**
     * Получение страны по названию
     * @param  string $name Название страны
     * @return Array        Информация о стране
     */
    public function getByName($name)
    {
        $sql = "SELECT * FROM `country` WHERE `name`='{$name}'";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }
}
