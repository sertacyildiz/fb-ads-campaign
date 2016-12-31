<?php

/**
 * Logging
 * @param string $logName
 * @param int $increment
 * @param int $date
 */
function LogData ( $logName, $increment = 1, $date = -1 )
{
  global $mongo;

  $time = time();
  if ( $date > 0 ) {
    $time = $date;
  }

  $day = date( "d", $time );
  $month = date( "m", $time );
  $year = date( "Y", $time );
  $inc = array(
    "total" => $increment,
    "single.{$year}-{$month}-{$day}" => $increment
  );

  // Totals update
  $mongo->setCollection( COLLECTION_STATS );
  $mongo->dataUpdate( array( "_id" => $logName ), array( '$inc' => $inc ), array( "upsert" => 1, "w" => 0 ) );
}
 