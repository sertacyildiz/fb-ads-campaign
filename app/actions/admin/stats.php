<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  exit();
}

$daysInYear = 365;
$secondsInAMinute = 60;
$secondsInAnHour = 60 * $secondsInAMinute;
$secondsInADay = 24 * $secondsInAnHour;

$timeEnd = time();
$timeStart = $timeEnd - ( 29 * $secondsInADay );

if ( isset( $_POST[ 'datetime_start' ] ) ) {
  $timeStart = strtotime( sanitize_string( $_POST[ 'datetime_start' ] ) );
}
if ( isset( $_POST[ 'datetime_end' ] ) ) {
  $timeEnd = strtotime( sanitize_string( $_POST[ 'datetime_end' ] ) );
}

function secondsToTime ( $inputSeconds )
{
  global $daysInYear, $secondsInAMinute, $secondsInAnHour, $secondsInADay;

  // extract days
  $days = floor( $inputSeconds / $secondsInADay );

  // Find years
  $years = floor( $days / $daysInYear );
  // Remaining days
  $days -= $years * $daysInYear;

  // extract hours
  $hourSeconds = $inputSeconds % $secondsInADay;
  $hours = floor( $hourSeconds / $secondsInAnHour );

  // extract minutes
  $minuteSeconds = $hourSeconds % $secondsInAnHour;
  $minutes = floor( $minuteSeconds / $secondsInAMinute );

  // extract the remaining seconds
  $remainingSeconds = $minuteSeconds % $secondsInAMinute;
  $seconds = ceil( $remainingSeconds );

  // return the final array
  $obj = array(
      'y' => (int)$years,
      'd' => (int)$days,
      'h' => (int)$hours,
      'm' => (int)$minutes,
      's' => (int)$seconds,
  );
  return $obj;
}

function datesFromStartToEnd ()
{
  global $secondsInADay, $timeStart, $timeEnd;

  $current = $timeEnd;
  $return = array();

  do {
    $date = date( 'Y-m-d', $current );
    $return[ $date ] = 0;

    $current -= $secondsInADay;
  } while ( $current >= $timeStart );

  return $return;
}

// Users count
$mongo->setCollection( COLLECTION_STATS );

$statscanbe = array(
    'register' => 'New device',
    'returning' => 'Returning',
    'login' => 'Log in',
    'logout' => 'Log out',

    'notification' => 'Notification registration',
    'notificationSent' => 'Delivered notifications',
    'notificationReceived' => 'Received notifications',

    'filesearchstarted' => 'File search started',
    'filesearchcompleted' => 'File search ended',

    'filefound' => 'File found',
    'fileremoved' => 'File removed',
    'genrefound' => 'Genre found',
    'genreremoved' => 'Genre removed',
    'albumfound' => 'Album found',
    'albumremoved' => 'Album removed',
    'artistfound' => 'Artist found',
    'artistremoved' => 'Artist removed',

    'newplaylist' => 'New playlist',

    'play' => 'Play',
    'stop' => 'Stop',
    'pause' => 'Pause',
    'shuffle' => 'Shuffle',
    'rewind' => 'Rewind',
    'prev' => 'Prev song',
    'next' => 'Next song',

    'settings' => 'Settings',
    'home' => 'Home button',

    'search' => 'Search',

    'playalbum' => 'Play album',
    'playartist' => 'Play artist',
    'playgenre' => 'Play genre',
    'playsong' => 'Play song',

    'songclick' => 'Song clicked',
    'albumclick' => 'Album clicked',
    'artistclick' => 'Artist clicked',
    'genreclick' => 'Genre clicked',

    'eqon' => 'EQ on',
    'eqoff' => 'EQ off',
    'crossfadeon' => 'Crossfade on',
    'crossfadeoff' => 'Crossface off',
    'amplifieron' => 'Amplifier on',
    'amplifieroff' => 'Amplifier off',
    'trebleon' => 'Treble on',
    'trebleoff' => 'Treble off',
    'basson' => 'Bass on',
    'bassoff' => 'Bass off',

    'lyric' => 'Lyric',

    'gracenotestart' => 'Gracenote start',
    'gracenoteend' => 'Gracenote end',
    'gracenotetext' => 'Gracenote update info',
    'gracenotecover' => 'Gracenote update cover',
);

// LOGIN stat data
$stats = array();
foreach ( $statscanbe as $s => $tr ) {
  $stats[ $s ] = $mongo->dataFindOne( array( "_id" => $s ) );
}

// Random for chart id
$random = new emrRandom();
// Last 30 days
$last = datesFromStartToEnd();
?>
<?php include_once __DIR__ . "/_header.php"; ?>

  <script src="/js/moment.js"></script>
  <script src="/js/bootstrap-datetimepicker.min.js"></script>
  <link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

  <div class="bs-docs-header" id="content">
    <div class="container">
      <h1>Statistics</h1>

      <form class="form-inline" role="form" method="post">
        <input type='text' class="form-control" data-date-format="YYYY-MM-DD" id="datetimepicker" name="datetime_start" value="<?php echo date( "Y-m-d", $timeStart ) ?>"/>
        <input type='text' class="form-control" data-date-format="YYYY-MM-DD" id="datetimepicker" name="datetime_end" value="<?php echo date( "Y-m-d", $timeEnd ) ?>"/>
        <input type="submit" name="submit" value="Show" class="btn btn-default"/>
      </form>
    </div>
  </div>

  <div class="container">
    <div class="row">

      <table class="col-sm-12 table table-condensed table-hover">
        <thead>
        <tr>
          <th class="col-sm-2">Action</th>
          <th class="col-sm-3" style="text-align: right">Total</th>
          <th class="col-sm-7" style="text-align: right"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ( $stats as $k => $d ): ?>
          <tr>
            <td><?php echo $statscanbe[ $k ]; ?></td>
            <td style="text-align: right; font-size: 12px;">
              <?php
              if ( !is_array( $d ) ) {
                $d = array();
              }
              ?>
              <?php foreach ( $d as $n => $v ): ?>
                <?php if ( $n == "total" ): ?>
                  <?php
                  if ( $k == "session" ) {
                    $str = secondsToTime( $v );
                    echo "{$str["y"]} years {$str["d"]} days {$str["h"]} hours {$str["m"]} minutes {$str["s"]} seconds";
                  } else {
                    echo number_format( $v );
                  }
                  ?>
                <?php endif ?>
              <?php endforeach; ?>
            </td>
            <td style="text-align: right">
              <?php $name = "chart_" . $random->alphaNumeric( 7 ); ?>
              <div id="<?php echo $name ?>" style="height:100px;"></div>
              <script>
                (function () {
                  var data = [
                    <?php
                     foreach ( $d as $n => $v ) {
                      if ( $n == "single" ){
                      $count = 0;
                        foreach ( $last as $day => $value ){
                          $count++;
                          if(isset($v[$day])) {
                            $value = $v[$day];
                          }
                          echo $count == count($last) ? "[" . (strtotime($day)*1000) . "," . $value."]" : "[" . (strtotime($day)*1000) . "," . $value . "],";
                        }
                      }
                     }
                     ?>
                  ];
                  var options = {
                    xaxes: [
                      {mode: "time", color: "#ECF6FF"}
                    ],
                    yaxes: [
                      {min: 0, color: "#ECF6FF"}
                    ],
                    series: {
                      lines: {
                        show: true
                      },
                      points: {
                        show: true
                      }
                    },
                    grid: {
                      hoverable: true,
                      clickable: true,
                      borderWidth: 0
                    },
                    colors: ["#FF4793"]
                  };

                  $( "<div id='tooltip<?php echo $name ?>' class='mytooltip'></div>" ).appendTo( "body" );

                  $( "#<?php echo $name ?>" ).bind( "plothover", function ( event, pos, item ) {
                    if (item) {
                      var x = item.datapoint[0], y = item.datapoint[1];

                      var date = new Date( x );
                      var year = date.getFullYear();
                      var month = date.getMonth() + 1 < 10 ? "0" + (date.getMonth() + 1) : date.getMonth() + 1;
                      var day = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
                      var con = year + "-" + month + "-" + day;

                      var str = y + '';
                      x = str.split( '.' );
                      var x1 = x[0];
                      var x2 = x.length > 1 ? '.' + x[1] : '';
                      var rgx = /(\d+)(\d{3})/;
                      while (rgx.test( x1 )) {
                        x1 = x1.replace( rgx, '$1' + ',' + '$2' );
                      }
                      var fin = x1 + x2;

                      $( "#tooltip<?php echo $name ?>" ).html( con + "<br/><strong>" + fin + "</strong>" )
                          .css( {top: item.pageY + 5, left: item.pageX + 5} )
                          .fadeIn( 200 );
                    } else {
                      $( "#tooltip<?php echo $name ?>" ).hide();
                    }
                  } );

                  $.plot( "#<?php echo $name ?>", [data], options );
                })()
              </script>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <style>
    .mytooltip {
      position: absolute;
      display: none;
      border: 1px solid #5a0d34;
      padding: 2px;
      background-color: #641946;
      color: white;
    }

    .yAxis .tickLabel {
      font-size: 9px;
    }
  </style>

  <script type="text/javascript">
    $( function () {
      $( '#datetimepicker' ).datetimepicker( {
        pickDate: true,
        pickTime: false,
        useStrict: true
      } );
    } );
  </script>

<?php include_once __DIR__ . "/_footer.php"; ?>