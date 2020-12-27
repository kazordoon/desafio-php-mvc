<?php

function redirectTo(string $url) {
  header("Location: {$url}");
  exit;
}
