<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Markakod</title>

  <link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  <link href="/css/adm/bootstrap.css" rel="stylesheet">
  <link href="/css/adm/bootstrap-docs.css" rel="stylesheet">
  <link href="/css/adm/font-awesome.css" rel="stylesheet">
  <link href="/css/adm/administration.css" rel="stylesheet">

  <script src="/js/adm/jquery-2.1.1.min.js"></script>
  <script src="/js/adm/bootstrap.js"></script>
  <script src="/js/adm/jquery.flot.min.js"></script>
  <script src="/js/adm/jquery.flot.time.min.js"></script>
  <!-- <script src="/js/ckeditor/ckeditor.js"></script>-->

</head>

<body data-spy="scroll" data-target=".bs-docs-sidebar">

<nav class="navbar navbar-static-top bs-docs-nav" role="navigation">
  <div class="container">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">...</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/administration">Markakod</a>
    </div>

    <?php if ( isAdminLoggedIn() ): ?>
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <li>
                <a href="/administration/slider/list"><i class="fa fa-windows "></i> Slider</a>
            </li>

            <li>
                <a href="/administration/showcase/list"><i class="fa fa-windows "></i> Showcase</a>
            </li>

            <li>
                <a href="/administration/about/list"><i class="fa fa-cube "></i> About</a>
            </li>

            <li>
                <a href="/administration/businesspartner/list"><i class="fa fa-building-o "></i> Business Partner</a>
            </li>

            <li>
                <a href="/administration/reference/list"><i class="fa fa-cubes "></i> Reference</a>
            </li>

            <li>
                <a href="/administration/team/list"><i class="fa fa-users"></i> Team</a>
            </li>

            <li>
                <a href="/administration/languages/list"><i class="fa fa-flag-o"></i> Languages</a>
            </li>

        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-user"></i> <?php echo $emrSession->GetName(); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li>
                <a href="/administration/admin/logout"><i class="fa fa-fw fa-sign-out"></i> Logout</a>
              </li>
              <li>
                <a href="/administration/admin/password"><i class="fa fa-fw fa-asterisk"></i> Change password</a>
              </li>
              <li class="nav-divider"></li>
              <li>
                <a href="/administration/admin/new"><i class="fa fa-fw fa-user"></i> Add user</a>
              </li>
              <li>
                <a href="/administration/admin/list"><i class="fa fa-fw fa-users"></i> List users</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    <?php endif; ?>
  </div>
</nav>