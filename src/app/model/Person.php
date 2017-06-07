<?php
namespace Model;
use Mixin\AOP as AOP;

class Person {
  use AOP;
  public function __call($method, $args) {
    $this->applyFilter(['details', function($SPC) use ($method, $args) {
      try {
        list($self, $params, $chain) = $SPC;
        $params[$method] = $args[0];
        addToLog($params, $method);
        $chain->next([$self, $params, $chain]);
      } catch (Exception $e) { echo 'Exception Thrown'; }
    }]);
  }
  public function details() {
    $fnName   = __FUNCTION__;
    $params   = [];
    $callback = function($SPC) {
      list($self, $params, $chain) = $SPC;
      extract($params);
      echo join("\n", $_log);
      echo "\n";
      echo 'Hello '. $name ."\n";
      echo 'Your age is '. $age ."\n";
      echo 'Your currently located in '. $location ."\n";
    };
    return $this->_filter([$fnName, $params, $callback]);
  }
}

// Helper functions used in closures
function addToLog(&$params, $method) {
  $msg = 'Log: Added '.$method;
  ($params['_log'] === null) ?
    $params['_log'] = [$msg] : $params['_log'][] = $msg;
}

