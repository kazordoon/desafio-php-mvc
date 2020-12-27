<?php

namespace App\Database;

use PDO;
use Pecee\Pixie\Connection AS QueryBuilder;
use Pecee\Pixie\QueryBuilder\QueryBuilderHandler;

class Database {
  public static QueryBuilderHandler $queryBuilder;

  public static function loadQueryBuilder() {
    $dbConfig =
    [
      'driver'    => DB_DRIVER,
      'host'      => DB_HOST,
      'database'  => DB_NAME,
      'username'  => DB_USER,
      'password'  => DB_PASSWORD,

      'charset'   => 'utf8mb4',
      'collation' => 'utf8mb4_general_ci',
      'options'   => [
          PDO::ATTR_TIMEOUT => 5
      ],
    ];

    self::$queryBuilder = (new QueryBuilder(DB_DRIVER, $dbConfig))->getQueryBuilder();
  }
}

Database::loadQueryBuilder();
