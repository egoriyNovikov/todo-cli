<?php

namespace EgorNovikov\TodoCli\Database;

use PDO;
use PDOException;

class Database {

  private ?PDO $pdo = null;
  private string $dsn;
  private string $username;
  private string $password;

  public function __construct(array $config) {
    $this->dsn = $config['dsn'];
    $this->username = $config['username'];
    $this->password = $config['password'];
  }

  public function connect(): PDO {
    if ($this->pdo !== null) {
      return $this->pdo;
    }
    try {
      $this->pdo = new PDO(
        $this->dsn,
        $this->username,
        $this->password,
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
      );
    } catch (PDOException $e) {
      throw new \RuntimeException("Connection failed: " . $e->getMessage(), 0, $e);
    }
    return $this->pdo;
  }

  public function query(string $sql, array $params = []): array {
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function exec(string $sql, array $params = []): int {
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute($params);
    return $stmt->rowCount();
  }
}