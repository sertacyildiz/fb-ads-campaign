<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  exit();
}

if ( isset( $_POST[ "name" ] ) ) {
  // Admins
  $mongo = new emrMongo();
  $mongo->setAutoConnect( true );
  $mongo->setDatabase( MONGO_DATABASE );
  $mongo->setHost( MONGO_HOST );
  $mongo->setPort( MONGO_PORT );
  $mongo->setCollection( COLLECTION_ADMINS );

  $name = sanitize_string( $_POST[ "name" ] );
  $username = sanitize_string( $_POST[ "username" ] );
  $newa = sanitize_string( $_POST[ "newpassworda" ] );
  $newb = sanitize_string( $_POST[ "newpasswordb" ] );

  $check = $mongo->dataCount( array( 'username' => $username ) );

  // Check for username availability
  if ( $check ) {
    // Username is already in use
    $check = "This user already registered.";
  } else {
    if ( $newa != $newb ) {
      $check = "Passwords you entered are not the same. Try again..";
    } else {
      $random = new emrRandom();

      // Save new user
      $save = array(
        "name" => $name,
        "username" => $username,
        "password" => sha1( $newa ),
        "sessionid" => $random->AlphaNumeric( 6 ),
        "lastaccess" => date( "Y-m-d h:i:s" ),
        "active" => 1
      );
      $mongo->dataInsert( $save );
      header( "Location: /administration/admin/list" );
    }
  }
}
?>
<?php include_once __DIR__ . "/../_header.php"; ?>

  <div class="bs-docs-header" id="content">
    <div class="container">
      <h1>Create New User</h1>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <form class="col-md-6 col-md-offset-3" action="/administration/admin/new" method="post" enctype="multipart/form-data" id="news_form" role="form">

        <?php if ( isset( $check ) ): ?>
          <div class="alert alert-danger"><?php echo $check; ?></div>
        <?php endif; ?>

        <div class="form-group">
          <label for="name">Name and surname</label>
          <input id="name" name="name" type="text" class="form-control" required value="<?php echo isset( $_POST[ "name" ] ) ? $_POST[ "name" ] : ""; ?>">
        </div>

        <div class="form-group">
          <label for="username">Username</label>
          <input id="username" name="username" type="text" class="form-control" required value="<?php echo isset( $_POST[ "username" ] ) ? $_POST[ "username" ] : ""; ?>">
        </div>

        <div class="form-group">
          <label for="newpassworda">Password</label>
          <input id="newpassworda" name="newpassworda" type="password" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="newpasswordb">Password - again</label>
          <input id="newpasswordb" name="newpasswordb" type="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-info" style="margin-top:10px;">Create</button>

      </form>
    </div>
  </div>

<?php include_once __DIR__ . "/../_footer.php"; ?>