<?php

namespace Src\Configs;

use PDO;
use PDOStatement;

class Database
{
    private PDO $pdo;
    private string $sql;
    private array $params;

    public function __construct()
    {
        $host = $_ENV["DB_HOST"];
        $port = $_ENV["DB_PORT"];
        $name = $_ENV["DB_NAME"];
        $username = $_ENV["DB_USERNAME"];
        $password = $_ENV["DB_PASSWORD"];
        $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$name", $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->sql = "";
        $this->params = [];
    }

    /**
     * Set SQL query string
     * 
     * @param string $sql
     * @return Database
     */
    public function setSql(string $sql): Database
    {
        $this->sql = $sql;
        return $this;
    }

    /**
     * Set params
     * 
     * @param array $params
     * @return Database
     */
    public function setParams(array $params): Database
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Execute
     * 
     * @return PDOStatement
     */
    public function exec(): PDOStatement
    {
        $stm = $this->pdo->prepare($this->sql);
        $stm->setFetchMode(PDO::FETCH_ASSOC);
        $stm->execute($this->params);
        $this->sql = "";
        $this->params = [];
        return $stm;
    }

    /**
     * Get last inserted ID
     * 
     * @return bool|string
     */
    public function lastInsertId(): bool|string
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Begin Transaction
     * 
     * @return void
     */
    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }

    /**
     * Commit Transaction
     * 
     * @return void
     */
    public function commitTransaction(): void
    {
        $this->pdo->commit();
    }

    /**
     * Roll Back Transaction
     * 
     * @return void
     */
    public function rollBackTransaction(): void
    {
        $this->pdo->rollBack();
    }
}
