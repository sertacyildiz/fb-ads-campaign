<?php
include_once __DIR__ . '/config.php';

$ping = "pong";

$mongo = new emrMongo();
$mongo->setAutoConnect( false );
$mongo->mongoConnect();

$emrSession = new emrSession();

$emrExecution = new emrExecution();

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
      "login" => array(),
      "admin" => array( "list", "password", "new", "logout", "stats" ),
      "languages" => array( "list", "create", "json" ),
      "team" => array( "list", "edit", "json", "upload" ),
      "reference" => array( "list", "edit", "json", "upload" ),
      "businesspartner" => array( "list", "edit", "json", "upload" ),
      "showcase" => array( "list", "edit", "json", "upload" ),
      "slider" => array( "list", "edit", "json", "upload" ),
      "about" => array( "list", "edit", "json" ),
      "fbcamp" => array( "view", "list", "edit", "json" ),
      "adtest" => array( "view", "list", "edit", "json" )
  );

  if ( !isAdminLoggedIn() ) {
    include_once ACTIONS . "/admin/login.php";
    endHere();
    exit();
  }

  if ( !isset( $actionB ) ) {
    include_once ACTIONS . "/admin/main.php";
    endHere();
    exit();
  }

  if ( $actionB == "exit" ) {
    $emrSession->DestroySession();
    include_once ACTIONS . "/admin/login.php";
    endHere();
    exit();
  }

  if ( $actionB == "login" ) {
    include_once ACTIONS . "/admin/login.php";
    endHere();
    exit();
  }

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
    "sendMail" => "",
    "portfolio-post" => "",
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

