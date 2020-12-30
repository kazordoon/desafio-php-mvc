<?php

function cloneClass($class) {
  $classCopy = new stdclass;

  foreach ($class as $property => $value) {
    $classCopy->$property = $value;
  }

  return $classCopy;
}
