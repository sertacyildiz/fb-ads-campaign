<?php

/**
 * Sanitizes string for magic quotes by using
 * the PHPs built in filter_var function
 * @param string $data
 * @return string
 */
function sanitize_string ( $data )
{
  return filter_var( $data, FILTER_SANITIZE_MAGIC_QUOTES );
}

function sanitize_string_array ( $data )
{
  $nData = array();
  foreach ( $data as $d ) {
    array_push( $nData, sanitize_string( $d ) );
  }
  return $nData;
}

/**
 * Sanitizes string for integers by using
 * the PHPs built in filter_var function
 * @param $data mixed
 * @return int
 */
function sanitize_int ( $data )
{
  return (int)filter_var( $data, FILTER_SANITIZE_NUMBER_INT );
}

/**
 * Sanitizes string for integers by using
 * the PHPs built in filter_var function
 * @param $data array
 * @return array
 */
function sanitize_int_array ( $data )
{
  $nData = array();
  foreach ( $data as $d ) {
    array_push( $nData, sanitize_int( $d ) );
  }
  return $nData;
}

/**
 * Sanitizes string for float by using
 * the PHPs built in filter_var function
 * @param $data mixed
 * @return float
 */
function sanitize_float ( $data )
{
  return (float)filter_var( $data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
}

/**
 * Sanitizes string for float by using
 * the PHPs built in filter_var function
 * @param $data array
 * @return array
 */
function sanitize_float_array ( $data )
{
  $nData = array();
  foreach ( $data as $d ) {
    array_push( $nData, sanitize_float( $d ) );
  }
  return $nData;
}

/**
 * Sanitizes incoming for boolean.
 * The incoming can be string or int.
 * Case insensitive "true" and 1 are true, else false
 * @param $data mixed
 * @return boolean
 */
function sanitize_boolean ( $data )
{
  if ( $data == "1" || $data == 1 || strtolower( $data ) == 'true' ) {
    return true;
  } else {
    return false;
  }
}

/**
 * Sanitizes incoming for boolean.
 * The incoming can be string or int.
 * Case insensitive "true" and 1 are true, else false
 * @param $data array
 * @return array
 */
function sanitize_boolean_array ( $data )
{
  $nData = array();
  foreach ( $data as $d ) {
    array_push( $nData, sanitize_boolean( $d ) );
  }
  return $nData;
}

/**
 * Sanitizes string for email by using
 * the PHPs built in filter_var function
 * @param $data mixed
 * @return string
 */
function sanitize_email ( $data )
{
  return filter_var( $data, FILTER_SANITIZE_EMAIL );
}

/**
 * Sanitizes string for email by using
 * the PHPs built in filter_var function
 * @param $data array
 * @return array
 */
function sanitize_email_array ( $data )
{
  $nData = array();
  foreach ( $data as $d ) {
    array_push( $nData, sanitize_email( $d ) );
  }
  return $nData;
}

/**
 * Validates the string if it's email by using
 * the PHPs built in filter_var function
 * @param $data mixed
 * @return boolean
 */
function validate_email ( $data )
{
  return filter_var( $data, FILTER_VALIDATE_EMAIL );
}

/**
 * Validates the string to check if the given
 * string is a cell phone number
 * @param $data
 * @return boolean
 */
function validate_cell ( $data )
{
  return preg_match( "/^[0-9]{10}$/", $data );
}