<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  exit();
}

?>


<?php if ( DEBUG ): ?>
  <div id="debuginfo">
    <span class="one">Time: <?php echo $emrExecution->Time() . " - " . $emrExecution->TimeHMS(); ?></span>
    <span class="two">Memory: <?php echo formatBytes( memory_get_peak_usage() ) . " - " . formatBytes( memory_get_usage() ); ?></span>
  </div>

  <div id="postinfo">
    <pre><?php
      if ( count( $_GET ) ) {
        echo "GET:\n";
        print_r( $_GET );
      }
      if ( count( $_POST ) ) {
        echo "POST:\n";
        print_r( $_POST );
      }
      if ( count( $_FILES ) ) {
        echo "FILES:\n";
        print_r( $_FILES );
      }
      ?></pre>
  </div>

  <style type="text/css">
    #debuginfo {
      z-index: 1001;
      position: fixed;
      bottom: 5px;
      left: 5px;
      padding: 5px 15px;
      font-size: 11px;
      color: white;
      background-color: #777;
      border-radius: 5px;
      opacity: 0.8;
    }

    #postinfo {
      z-index: 1;
    }

    #postinfo pre {
      z-index: 1001;
      position: fixed;
      right: 5px;
      bottom: 5px;
      margin: 0;
      padding: 10px;
      font-size: 10px;
      color: white;
      background-color: #777;
      border: none;
      opacity: 0.8;
    }
  </style>
<?php endif; ?>

</body>
</html>