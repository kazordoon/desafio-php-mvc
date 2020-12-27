<?php

function generateToken() {
  $token = uniqid(bin2hex(random_bytes(16)));
  return $token;
}
