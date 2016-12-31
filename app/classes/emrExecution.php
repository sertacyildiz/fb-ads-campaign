<?php
/**
 * Script Execution V1
 * Counts for script execution time in microseconds, and H:M:S
 * @author emrahgunduz
 */
class emrExecution
{

  private $starttime;

  /**
   * Starts script execution time
   */
  function emrExecution ()
  {
    $this->starttime = ( float )microtime( true );
  }

  /**
   * Returns execution time
   */
  function Time ()
  {
    $emtime = ( float )microtime( true );
    return $this->ConvertMathNumber( ( $emtime - $this->starttime ), ".", " " );
  }

  /**
   * Returns execution time as H:M:S
   */
  function TimeHMS ()
  {
    $emtime = ( float )microtime( true );
    $ttime = (int)( $emtime - $this->starttime );

    // Set hours
    $hours = intval( intval( $ttime ) / 3600 );

    // Set minutes
    $minutes = intval( ( $ttime / 60 ) % 60 );
    $minutes = str_pad( $minutes, 2, "0", STR_PAD_LEFT );

    // Set seconds
    $seconds = intval( $ttime % 60 );
    $seconds = str_pad( $seconds, 2, "0", STR_PAD_LEFT );

    // Return H:M:S
    return $hours . ":" . $minutes . ":" . $seconds;
  }

  /**
   * Resets start time
   */
  function Reset ()
  {
    $this->starttime = ( float )microtime( true );
  }

  private function ConvertMathNumber ( $number, $dec_point, $thousands_sep )
  {
    $number = ( rtrim( sprintf( '%.5e', $number ), "0" ) );
    if ( fmod( (float)$number, 1 ) != 0 ) {
      $array_int_dec = explode( '.', $number );
    } else {
      $array_int_dec = array( strlen( $number ), 0 );
    }
    ( strlen( $array_int_dec [ 1 ] ) < 2 ) ? ( $decimals = 2 ) : ( $decimals = strlen( $array_int_dec [ 1 ] ) );
    return number_format( (float)$number, $decimals, $dec_point, $thousands_sep );
  }

}