<?php

namespace AppLibrary;


/**
 * Convenience methods for handling arrays
 * @version 0.1
 */
class Arr {
  
  /**
   * Is this array iterable?
   * @param array $arr
   * @return bool
   */
  public static function iterable($arr) {
    return (is_array($arr) && count($arr) > 0);
  }
}