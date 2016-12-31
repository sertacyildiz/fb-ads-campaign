<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  exit();
}

$emrSession = new emrSession();
$emrSession->DestroySession();
header( "Location: /administration" );