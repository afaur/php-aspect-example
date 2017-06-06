<?php
namespace Single;
use Model\Person as Person;

final class People {
  static $instances = [];
  public static function ByName($name) {
    if (static::$instances !== []) {
      $people = static::$instances;
      foreach($people as $index => $tuple) {
        if ($tuple[0] === $name) { return $people[$index][1]; }
      }
    }
    $result = [$name, new Person()];
    static::$instances[] = $result;
    return $result[1];
  }

  private function __construct() {}
}

