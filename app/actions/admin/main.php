<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  exit();
}

?>
<?php include_once __DIR__ . "/_header.php"; ?>

  <div class="bs-docs-header" id="content">
    <div class="container">
      <h1>Hello</h1>
    </div>
  </div>

<?php include_once __DIR__ . "/_footer.php"; ?>