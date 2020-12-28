<?php

namespace App\Models;

use App\Core\Model;

class Product extends Model {
  protected static $tableName = 'products';

  public static function findAvailable() {
    $data = static::getTable()->where('stock', '>', 0)->get();
    return $data;
  }
}
