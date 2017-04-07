<?php
include_once __DIR__ . '/config.php';

$ping = "pong";


$emrSession = new emrSession();

errorlog( $_GET );
errorlog( $_POST );
errorlog( $_FILES );

#region ADMINISTRATION REDIRECTS - INCLUDES
if ( isset( $_GET[ 'a' ] ) ) {
  $actionA = str_ireplace( "/", "", $_GET[ 'a' ] );
} else {
  $actionA = "main";
}

if ( isset( $_GET[ 'b' ] ) ) {
  $actionB = str_ireplace( "/", "", $_GET[ 'b' ] );
}

if ( isset( $_GET[ 'c' ] ) ) {
  $actionC = str_ireplace( "/", "", $_GET[ 'c' ] );
}

if ( isset( $_GET[ 'd' ] ) ) {
  $actionD = str_ireplace( "/", "", $_GET[ 'd' ] );
}

if ( $actionA == "administration" ) {

  $subActions = array(
      "fbcamp" => array( "view", "list", "edit", "json" ),
      "adtest" => array( "view", "list", "edit", "json" )
  );


  if ( array_key_exists( $actionB, $subActions ) ) {
    if ( isset( $actionC ) && in_array( $actionC, $subActions[ $actionB ] ) ) {

      $file = ACTIONS . "/admin/{$actionB}/{$actionC}.php";
      include_once is_file( $file ) ? $file : ACTIONS . "/admin/main.php";
      endHere();
      exit();
    }


    $file = ACTIONS . "/admin/{$actionB}.php";

    include_once is_file( $file ) ? $file : ACTIONS . "/admin/main.php";
    endHere();

  } else {
    include_once ACTIONS . "/admin/main.php";
    endHere();
    exit();
  }

}

#endregion

$actions = array(
    "main" => array(),
    "fbcamp" => array( "test", "index", "curl", "login" ),
    "adtest" => array( "test", "index", "curl", "login" )
);



if ( !isset( $actionA ) ) {
  include_once ACTIONS . "/public/main.php";
  endHere();
  exit();
}

if ( array_key_exists( $actionA, $actions ) ) {

  if ( isset( $actionB ) && in_array( $actionB, $actions[ $actionA ] ) ) {

    $file = ACTIONS . "/public/{$actionA}/{$actionB}.php";

    include_once is_file( $file ) ? $file : ACTIONS . "/public/main.php";
    endHere();
    exit();
  }

  $file = ACTIONS . "/public/{$actionA}.php";

  include_once is_file( $file ) ? $file : ACTIONS . "/public/main.php";
  endHere();
  exit();
} else {
  include_once ACTIONS . "/public/main.php";
  endHere();
  exit();
}
#endregion

