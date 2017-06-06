<?php
namespace Mixin;
/**
 * AOP Trait
 * Used to created aop for your class.
 */
trait AOP {
  public $filters = [];
  public function applyFilter($NF) {
    list($fnName, $fn) = $NF;
    ($this->unlessFilter($fnName)) && $this->initFilter($fnName);
    return $this->filters[$fnName][] = $fn;
  }
  private function unlessFilter($fnName) { return (empty($this->filters[$fnName])); }
  private function initFilter($fnName)   { $this->filters[$fnName] = [];            }
  public function _filter($FPC)          { return $this->callQueue($FPC);           }
  private function callQueue($FPC) {
    list($fnName, $fnParams, $fnCallback) = $FPC;
    $queue = new AOPChain($this, $this->newChain($fnName, $fnCallback));
    return $queue->first($fnParams);
  }
  private function newChain($fnName, $fnCallback) {
    $filterCallbacks = $this->callbacks($fnName);
    $filterCallbacks[] = $fnCallback;
    return $filterCallbacks;
  }
  private function callbacks($fnName) { return $this->filters[$fnName]; }
}
/**
 * Responsible for creating the chain queue and processing it
 */
class AOPChain {
  public $host = null;
  public $callbacks = [];
  public function __construct($host, $callbacks) {
    $this->host = $host;
    $this->callbacks = $callbacks;
    $this->position = 0;
  }
  // Helps with the first item in the chain by prepending known variables
  public function first($params) { return $this->next([$this->host, $params, $this]); }
  // Called inside of a filter `$chain->next($self, $params, $chain);`
  public function next($SPC) { return call_user_func($this->callbacks[$this->position++], $SPC); }
}

