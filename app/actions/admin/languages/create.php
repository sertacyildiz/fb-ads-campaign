<?php
if ( !isset( $ping ) || $ping != "pong" ) {
  endHere();
  exit();
}

if ( isset( $_POST[ 'create' ] ) == true ) {
  $language = new Language();
  $language->Create();

  echo json_encode($language);
}


 