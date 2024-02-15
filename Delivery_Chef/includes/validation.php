<?php

//validate email
function validateEmail($email) {
  return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

//sanitize email
function sanitizeEmail($email) {
  $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
  return $sanitizedEmail;
}

//validate password with minimum 5 char
function validatePassword($password) {
  if (strlen($password) >= 5) {
    return true;
} else {
    return false;
  }
}

//hash password
function hashPassword($password) {
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  return $hashedPassword;
}

//validate username containing only letters
function validateName($name) {
  return preg_match('/^[A-Za-z]+$/', $name);
}

function validatePhone($phone) {
  $phone = preg_replace("/[^0-9]/", "", $phone);
  
  if (strlen($phone) >= 9) {
      return true; 
  }
  return false; 
}

function validatePostalCode($zip) {

  $postalCode = trim($zip);
  $pattern = "/^[A-Za-z]\d[A-Za-z] \d[A-Za-z]\d$/";
  
  if (preg_match($pattern, $postalCode)) {
      return true; 
  } else {
      return false; 
  }
}


?>