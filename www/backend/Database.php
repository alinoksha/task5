<?php
class Database
{
    private $connection;
    public function __construct()
    {
        $this->connection = new mysqli(DB_SERVER, DB_USER, DB_PASS);

        $this->query('CREATE DATABASE IF NOT EXISTS `task5`');
        $this->query('USE `task5`');
        $this->query('
            CREATE TABLE IF NOT EXISTS `country` (
                `id` int(10) unsigned AUTO_INCREMENT,
                `name` varchar(255) NOT NULL UNIQUE,
                `code` varchar(255),
                PRIMARY KEY(`id`)
            )
        ');
    }
    /**
     * Отправляет запрос к БД
     * @param  string $sql Запрос к БД
     * @return object      Ответ от БД
     */
    public function query($sql)
    {
        $result = $this->connection->query($sql);
        return $result;
    }
    /**
     * Обработка данных (защита от опасного текста, вводимого пользователем), записываемых в БД
     * @param  string $string Необработанные данные
     * @return string         Обработанные данные
     */
    public function prepare($string)
    {
        $string = htmlspecialchars($string);
        $string = trim($string);
        $string = $this->connection->real_escape_string($string);
        return $string;
    }
}
