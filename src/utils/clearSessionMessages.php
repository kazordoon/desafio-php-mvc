<?php

function clearSessionMessages() {
  unset($_SESSION['error_message']);
  unset($_SESSION['success_message']);
}
