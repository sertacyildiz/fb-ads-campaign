<?php

/**
 * Error log function.
 * @param mixed $data
 */
function errorlog ( $data )
{
  if ( !DEBUG_LOG ) {
    return;
  }
  if ( is_array( $data ) || is_object( $data ) ) {
    error_log( var_export( $data, true ) );
  } else {
    error_log( $data );
  }
}

/**
 * End mongo connection end exit app
 */
function endHere ()
{
  global $mongo;
  $mongo->mongoConnectionClose();
  exit();
}

/**
 * New Relic transaction name
 * @param string $name
 */
function newRelicNameTransaction ( $name )
{
  if ( extension_loaded( 'newrelic' ) ) {
    newrelic_name_transaction( $name );
  }
}

/**
 * Converts bytes to readable format
 * @param int $bytes
 * @return string
 */
function formatBytes ( $bytes )
{
  $labels = array( 'B', 'KB', 'MB', 'GB', 'TB' );
  for ( $x = 0; $bytes >= 1024 && $x < ( count( $labels ) - 1 ); $bytes /= 1024, $x++ ) ;
  return ( round( $bytes, 2 ) . ' ' . $labels[ $x ] );
}

/**
 * Returns the given seconds in "x days h i s" format
 * @param int $seconds
 * @param bool $noNegative Do not accept negative seconds
 * @return string
 */
function formatSeconds ( $seconds, $noNegative = true )
{
  if ( $noNegative && $seconds < 0 ) {
    return '-';
  }

  $days = floor( $seconds / ( 24 * 60 * 60 ) );
  $h = gmdate( "H", $seconds );
  $m = gmdate( "i", $seconds );
  $s = gmdate( "s", $seconds );
  if ( $days > 0 )
    return $days . " days " . $h . " hours " . $m . " minutes " . $s . " seconds";
  if ( $h > 0 )
    return $h . " hours " . $m . " minutes " . $s . " seconds";
  if ( $m > 0 )
    return $m . " minutes " . $s . " seconds";

  return $s . " seconds";
}

/**
 * Checks if the admin login is ok
 * @return boolean
 */
function isAdminLoggedIn ()
{
  $emrSession = new emrSession();
  if ( $emrSession->ConfirmLogin() ) {
    return true;
  }
  if ( $emrSession->ConfirmSession() ) {
    return true;
  }
  return false;
}

/**
 * Sorts an array by a key value
 * @param $array Array to sort
 * @param $key String Key used for sorting
 * @param bool $desc Is descending
 * @return mixed Returns sorted array
 */
function sortArrayByKey ( $array, $key, $desc = false )
{
  $sort = array();
  foreach ( $array as $k => $row ) {
    $sort[ $k ] = $row[ $key ];
  }
  array_multisort( $sort, $desc ? SORT_ASC : SORT_DESC, $array );
  return $array;
}

/**
 * Sort an array randomly
 * @param $array
 * @param bool $preserve_keys
 * @return array
 */
function sortArrayRandom ( $array, $preserve_keys = false )
{
  if ( !is_array( $array ) ) return $array;

  $randsort = array();
  $array_length = count( $array );
  $randomize_array_keys = array_rand( $array, $array_length );

  if ( $preserve_keys === true ) {
    foreach ( $randomize_array_keys as $k => $v ) {
      $randsort[ $randomize_array_keys[ $k ] ] = $array[ $randomize_array_keys[ $k ] ];
    }
    return $randsort;
  }

  for ( $i = 0; $i < $array_length; $i++ ) {
    $randsort[ $i ] = $array[ $randomize_array_keys[ $i ] ];
  }
  return $randsort;
}

/**
 * Limits the word count in text
 * @param string $string
 * @param int $limit
 * @return string
 */
function limitWords ( $string, $limit = 20 )
{
  $exploded = explode( " ", $string );
  if ( count( $exploded ) <= $limit ) {
    return $string;
  }

  $newString = "";
  for ( $i = 0; $i < $limit; $i++ ) {
    $newString .= " {$exploded[$i]}";
  }

  return $newString;
}

/**
 * Limits the character count in text
 * @param $string
 * @param int $max
 * @return string
 */
function limitChars ( $string, $max = 30 )
{
  if ( mb_strlen( $string, 'utf-8' ) > $max ) {
    $string = mb_substr( $string, 0, $max - 3, 'utf-8' ) . "...";
  }
  return trim( $string );
}

/**
 * Create a slug from given string
 * @param $str String
 * @return mixed String
 */
function slugFromString ( $str )
{
  $cleana = iconv( 'UTF-8', 'ASCII//TRANSLIT//IGNORE', $str );
  $cleanb = preg_replace( "/[^a-zA-Z0-9\/_|+ -]/", '', trim( $cleana ) );
  $cleanc = strtolower( trim( $cleanb, '-' ) );
  $clean = preg_replace( "/[\/_|+ -]+/", "-", $cleanc );
  return $clean;
}

/**
 * Curl download an image
 * @param $url String URL of file
 * @param $saveto String Save to this location
 */
function curlImage ( $url, $saveto )
{
  $ch = curl_init( $url );
  curl_setopt( $ch, CURLOPT_HEADER, 0 );
  curl_setopt( $ch, CURLOPT_VERBOSE, false );
  curl_setopt( $ch, CURLOPT_BINARYTRANSFER, 1 );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
  $raw = curl_exec( $ch );
  curl_close( $ch );
  if ( file_exists( $saveto ) ) {
    unlink( $saveto );
  }
  $fp = fopen( $saveto, 'x' );
  fwrite( $fp, $raw );
  fclose( $fp );
}

/**
 * Returns a placeholder Lorem Ipsum text.
 * @param int $paragraphCount Paragraph count
 * @param string $paragraphLength Paragraph length (short, medium, long, verylong)
 * @param bool $isPlainText Plaintext or HTML
 * @return string
 */
function loremIpsum ( $paragraphCount = 1, $paragraphLength = 'medium', $isPlainText = true )
{
  $url = 'http://loripsum.net/api/' . $paragraphCount . '/' . $paragraphLength . ( $isPlainText ? '/plaintext' : '' );
  $ch = curl_init( $url );
  curl_setopt( $ch, CURLOPT_HEADER, 0 );
  curl_setopt( $ch, CURLOPT_VERBOSE, false );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
  $raw = curl_exec( $ch );
  curl_close( $ch );
  return $raw;
}

/**
 * Returns a placeholder image
 * @param $string
 * @param $width
 * @param $height
 * @return string
 */
function loremImage ( $string, $width, $height )
{
  return "placehold.it/{$width}x{$height}&text=" . urlencode( $string );
}

/**
 * Returns the json object from the requested URL
 * @param string $url
 * @param mixed $postBody Must be array
 * @param bool $returnHTTPCode Return result or http code
 * @return mixed
 */
function curlJSON ( $url, $postBody = false, $returnHTTPCode = false )
{
  $headers = array( 'Content-Type: application/json' );

  $ch = curl_init( $url );
  curl_setopt( $ch, CURLOPT_HEADER, true );
  curl_setopt( $ch, CURLOPT_VERBOSE, true );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

  if ( $postBody ) {
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $postBody ) );
  }

  $response = curl_exec( $ch );
  $header_size = curl_getinfo( $ch, CURLINFO_HEADER_SIZE );
  $header = substr( $response, 0, $header_size );
  $raw = substr( $response, $header_size );

  // Get HTTP code
  $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
  errorlog( "<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<" );
  errorlog( "curlJSON Request ------- Code: " . $httpCode );
  errorlog( "---------------------------------------" );
  errorlog( $header );
  errorlog( "---------------------------------------" );
  errorlog( $raw );
  errorlog( ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>" );

  curl_close( $ch );
  if ( $returnHTTPCode )
    return $httpCode;
  else
    return json_decode( $raw, true );
}

/**
 * Upper case the turkish characters
 * @param $string string
 * @return string
 */
function upperCaseTurkish ( $string )
{
  $tr = array( "Ğ", "ğ", "Ü", "ü", "Ş", "ş", "İ", "i", "I", "ı", "Ö", "ö", "Ç", "ç" );
  $ntr = array( "Ğ", "Ğ", "Ü", "Ü", "Ş", "Ş", "İ", "İ", "I", "I", "Ö", "Ö", "Ç", "Ç" );
  return str_replace( $tr, $ntr, $string );
}

/**
 * Uppercase first letter in every word
 * @param $string string
 * @return string
 */
function ucWordsTurkish ( $string )
{
  $tr = array( "Ğ", "ğ", "Ü", "ü", "Ş", "ş", "İ", "i", "I", "ı", "Ö", "ö", "Ç", "ç" );
  $mtr = array( "Ğ", "Ğ", "Ü", "Ü", "Ş", "Ş", "İ", "İ", "I", "I", "Ö", "Ö", "Ç", "Ç" );
  $ntr = array( "ğ", "ğ", "ü", "ü", "ş", "ş", "i", "i", "ı", "ı", "ö", "ö", "ç", "ç" );

  $string = mb_strtolower( str_replace( $tr, $ntr, $string ), 'UTF-8' );

  $words = explode( " ", $string );
  $count = count( $words );
  for ( $i = 0; $i < $count; $i++ ) {
    $word = $words[ $i ];
    $letter = mb_strtoupper( str_replace( $tr, $mtr, mb_substr( $word, 0, 1, 'UTF-8' ) ), 'UTF-8' );
    $word = $letter . mb_substr( $word, 1, null, 'UTF-8' );
    $words[ $i ] = $word;
  }
  $string = join( " ", $words );
  return $string;
}

/**
 * Lower case the turkish characters
 * @param $string string
 * @return string
 */
function lowerCaseTurkish ( $string )
{
  $tr = array( "Ğ", "ğ", "Ü", "ü", "Ş", "ş", "İ", "i", "I", "ı", "Ö", "ö", "Ç", "ç" );
  $ntr = array( "ğ", "ğ", "ü", "ü", "ş", "ş", "i", "i", "ı", "ı", "ö", "ö", "ç", "ç" );
  return str_replace( $tr, $ntr, $string );
}

/**
 * Escapes turkish characters with utf8 js code
 * @param $string string
 * @return string
 */
function escapeTurkishCharacters ( $string )
{
  $tr = array( "Ğ", "ğ", "Ü", "ü", "Ş", "ş", "İ", "ı", "Ö", "ö", "Ç", "ç", "i" );
  $ntr = array(
      '&#x011E;', // Ğ
      '&#x011F;', // ğ
      '&#x00DC;', // Ü
      '&#x00FC;', // ü
      '&#x015E;', // Ş
      '&#x015F;', // ş
      '&#x0130;', // İ
      '&#x0131;', // ı
      '&#x00D6;', // Ö
      '&#x00F6;', // ö
      '&#x00C7;', // Ç
      '&#x00E7;', // ç,
      '&#x0069;' // i
  );
  return str_replace( $tr, $ntr, $string );
}

/**
 * Returns the name by shortening for personal security
 * @param string $name
 * @return string
 */
function firstNameLastChar ( $name )
{
  $arr = explode( " ", $name );
  if ( count( $arr ) > 1 ) {
    $first = $arr[ 0 ];
    $last = $arr[ count( $arr ) - 1 ];
    $join = $first . " " . mb_substr( $last, 0, 1, 'utf-8' ) . ".";
    return $join;
  } else {
    return $name;
  }
}

/**
 * Returns the first characters of the name and surname
 * @param string $name
 * @return string
 */
function firstCharLastChar ( $name )
{
  $arr = explode( " ", $name );
  if ( count( $arr ) > 1 ) {
    $first = $arr[ 0 ];
    $last = $arr[ count( $arr ) - 1 ];
    $join = mb_substr( $first, 0, 1, 'utf-8' ) . mb_substr( $last, 0, 1, 'utf-8' );
    return $join;
  }

  return mb_substr( $name, 0, 1, 'utf-8' );
}

/**
 * Returns the IP address of the connected user
 * @return string
 */
function getIPAddress ()
{
  foreach ( array( 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ) as $key ) {
    if ( array_key_exists( $key, $_SERVER ) === true ) {
      foreach ( explode( ',', $_SERVER[ $key ] ) as $ip ) {
        $ip = trim( $ip ); // just to be safe

        if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) {
          return $ip;
        }
      }
    }
  }

  return "0.0.0.0";
}

/**
 * Sends json headers and content expire time
 */
function jsonHeaders ()
{
  header( 'Content-type: application/json' );
  header( 'Cache-Control: no-cache, must-revalidate' );
  header( 'Expires: ' . date( 'D, d M Y H:i:s \G\M\T', time() ) );
}

/**
 * Replace invalid UTF8 bytes
 * @param $str
 * @return string
 */
function replaceInvalidByteSequence ( $str )
{
  mb_substitute_character( 0xFFFD );
  return mb_convert_encoding( $str, 'UTF-8', 'UTF-8' );
}

/**
 * Go back to referrer header
 * @param string $back
 */
function goBackHeader ( $back = "/administration" )
{
  if ( isset( $_SERVER[ 'HTTP_REFERER' ] ) )
    header( 'Location: ' . $_SERVER[ 'HTTP_REFERER' ] );
  else
    header( 'Location:', $back );
}