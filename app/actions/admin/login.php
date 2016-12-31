<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  exit();
}
?>
<?php include_once __DIR__ . "/_header.php"; ?>

  <div class="bs-docs-header" id="content">
    <div class="container">
      <h1>Login</h1>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3">
        <form action="/administration" method="post">
          <div>
            <fieldset>

              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username">
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>

              <button type="submit" class="btn btn-info">Login</button>
            </fieldset>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php include_once __DIR__ . "/_footer.php"; ?>