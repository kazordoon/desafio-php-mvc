<?php

function formatPrice(float $price) {
  $numberFormatter = new NumberFormatter('pt_BR', NumberFormatter::CURRENCY);
  return $numberFormatter->format($price);
}