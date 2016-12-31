<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  endHere();
}


if (!isset($_POST['id'])) {
  echo json_encode(array('OK' => 0, 'MSG' => 'Id is missing'));
  endHere();
  exit();
}

if (!isset($_POST['name']) || !isset($_POST['value'])) {
  echo json_encode(array('OK' => 0, 'MSG' => 'Missing Data'));
  endHere();
  exit();
}

$id = sanitize_string($_POST['id']);
$lang = new Language();
if (!$lang->Load($id)) {
  echo json_encode(array('OK' => 0, 'MSG' => 'Unable to load item'));
  endHere();
  exit();
}

if ($_POST['name'] == 'order') {
  $val = sanitize_int($_POST['value']);
  $lang->SetOrder($val);
  echo json_encode(array('OK' => 1, 'MSG' => 'Success : Order'));
  endHere();
  exit();
}

if ($_POST['name'] == 'name') {
  $val = sanitize_string($_POST['value']);
  $lang->SetName($val);
  echo json_encode(array('OK' => 1, 'MSG' => 'Success : Name'));
  endHere();
  exit();
}

if ($_POST['name'] == 'code') {
  $val = sanitize_string($_POST['value']);
  $lang->SetCode($val);
  echo json_encode(array('OK' => 1, 'MSG' => 'Success : Code'));
  endHere();
  exit();
}

if ( $_POST[ 'name' ] == 'activate' ) {
  $active = !$lang->isActive;
  $lang->SetIsActive( $active );
  echo json_encode( array( 'OK' => 1, 'MSG' => 'Success : Active', 'ISACTIVE' => $lang->isActive ? 1 : 0 ) );
  endHere();
  exit();
}

if ($_POST['name'] == 'delete') {
  $lang->Delete();
  echo json_encode(array('OK' => 1, 'MSG' => 'Success : Delete'));
  endHere();
  exit();
}


 