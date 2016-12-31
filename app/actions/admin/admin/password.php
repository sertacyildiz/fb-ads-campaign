<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  exit();
}

if ( isset( $_POST[ "oldpassword" ] ) ) {
  $old = sanitize_string( $_POST[ "oldpassword" ] );
  $newa = sanitize_string( $_POST[ "newpassworda" ] );
  $newb = sanitize_string( $_POST[ "newpasswordb" ] );

  $current = $emrSession->GetPassword();
  if ( $current == sha1( $old ) ) {
    // Check if passwords are same
    if ( $newa == $newb ) {
      // Set new password
      $emrSession->SetPassword( $newa );
      $done = 1;
    } else {
      $check = "Passwords you entered are not the same. Try again.";
    }
  } else {
    $check = "Current password is wrong.";
  }
}
?>
<?php include_once __DIR__ . "/../_header.php"; ?>

  <div class="bs-docs-header" id="content">
    <div class="container">
      <h1>New Password</h1>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <form class="col-md-6 col-md-offset-3" action="/administration/admin/password" method="post" enctype="multipart/form-data" id="news_form" role="form">

        <?php if ( isset( $check ) ): ?>
          <div class="alert alert-danger"><?php echo $check; ?></div>
        <?php endif; ?>

        <?php if ( isset( $done ) ): ?>
          <div class="alert alert-success">Password is changed.</div>
        <?php endif; ?>

        <div class="form-group">
          <label for="oldpassword">Current password</label>
          <input id="oldpassword" name="oldpassword" type="password" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="newpassworda">New password</label>
          <input id="newpassworda" name="newpassworda" type="password" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="newpasswordb">New password - again</label>
          <input id="newpasswordb" name="newpasswordb" type="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-info" style="margin-top:10px;">Change</button>

      </form>
    </div>
  </div>

<?php include_once __DIR__ . "/../_footer.php"; ?>