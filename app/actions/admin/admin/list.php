<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  exit();
}

// Admins
$mongo = new emrMongo();
$mongo->setAutoConnect( true );
$mongo->setDatabase( MONGO_DATABASE );
$mongo->setHost( MONGO_HOST );
$mongo->setPort( MONGO_PORT );
$mongo->setCollection( COLLECTION_ADMINS );

$admins = $mongo->dataFind();
if ( isset( $admins[ '_id' ] ) ) {
  $admins = array( $admins );
}
?>
<?php include_once __DIR__ . "/../_header.php"; ?>

  <div class="bs-docs-header" id="content">
    <div class="container">
      <h1>Users</h1>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-hover">
          <thead>
          <tr>
            <th></th>
            <th>Name</th>
            <th style="text-align: right">Last Activity</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ( $admins as $u ): ?>
            <tr>
              <td>
                <?php echo $u[ "username" ]; ?>
              </td>
              <td>
                <?php echo $u[ "name" ]; ?>
              </td>
              <td style="text-align: right">
                <?php echo date( "d.m.Y H:i:s", strtotime( $u[ "lastaccess" ] ) ); ?>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <style>
    td {
      vertical-align: middle !important;
    }
  </style>

<?php include_once __DIR__ . "/../_footer.php"; ?>