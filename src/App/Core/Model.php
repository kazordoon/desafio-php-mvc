<?php

namespace App\Core;

use App\Database\Database;

class Model {
  protected static $tableName = '';

  protected static function getTable() {
    return Database::$queryBuilder->table(static::$tableName);
  }

  public static function create(array $payload) {
    static::getTable()->insert($payload);
    return 1;
  }

  public static function findOne(array $payload) {
    $data = static::getTable();
    foreach ($payload as $key => $value) {
      $data->where($key, '=', $value);
    }
    return $data->get();
  }

  public static function findById(int $id) {
    $data = static::getTable()->where('id', '=', $id)->first();
    return $data;
  }

  public static function findByIdAndUpdate(int $id, array $payload) {
    $data = static::getTable()->where('id', '=', $id)->update($payload);
    return $data;
  }
}
