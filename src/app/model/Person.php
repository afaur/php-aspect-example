<?php
namespace Model;
use Mixin\AOP as AOP;

class Person {
  use AOP;
  public function address($location) {
    $fnName   = __FUNCTION__;
    $params   = compact('location');
    $callback = function($SPC) {
      list($self, $params, $chain) = $SPC;
      extract($params);
      echo "\n";
      echo 'Hello '. $name ."\n";
      echo 'Your currently located in '. $location ."\n";
    };
    return $this->_filter([$fnName, $params, $callback]);
  }
}

