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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="/images/favicon.png">
<title>Markakod</title>
<!-- Bootstrap core CSS -->
<link href="/css/public/bootstrap.css" rel="stylesheet">
<link href="/css/public/settings.css" rel="stylesheet">
<link href="/css/public/owl.carousel.css" rel="stylesheet">
<link href="/js/public/google-code-prettify/prettify.css" rel="stylesheet">
<link href="/js/public/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" media="all" />
<link href="/js/public/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.2" rel="stylesheet" type="text/css" />
<link href="/css/public/style.css" rel="stylesheet">
<link href="/css/public/color/blue.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Josefin+Sans:400,600,700,400italic,600italic,700italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800' rel='stylesheet' type='text/css'>
<link href="/css/public/type/fontello.css" rel="stylesheet">
<link href="/css/public/type/budicons.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="/js/public/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
</head>
<body>
<div class="body-wrapper">
  <div class="offset"></div>
  <?php

  $lang = $_GET["dataLang"];
  $id = $_GET["dataId"];

  $showcase = new Showcase();
  $showcase->Load($id);
  ?>

  <div class="pcw">
    <div class="container inner">
      <div class="row">

        <div class="col-md-8">

          <div class="owl-carousel portfolio-slider custom-controls">
            <?php foreach ( $showcase->image as $photo ): ?>
              <div class="item">
                <img src="<?php echo SHOWCASE_IMAGES_URL.'/'.$photo['name']; ?>" width="770" height="530" alt="" />
              </div>
            <?php endforeach ?>
          </div>

        </div>
        <!-- /.col-sm-8 -->

        <div class="col-md-4 lp30">

          <h1 class="post-title"><?php echo $showcase->title[$lang]; ?></h1>

          <p><?php echo $showcase->detail[$lang]; ?></p>
        </div>
        <!-- /.col-sm-4 -->
      </div>
      <!-- /.row -->
    </div>
  </div>
  <!-- /.pcw -->
</div>
<!-- .body-wrapper --> 
<script src="/js/public/jquery.min.js"></script>
<script src="/js/public/bootstrap.min.js"></script>
<script src="/js/public/twitter-bootstrap-hover-dropdown.min.js"></script>
<script src="/js/public/jquery.themepunch.plugins.min.js"></script>
<script src="/js/public/jquery.themepunch.revolution.min.js"></script>
<script src="/js/public/jquery.easytabs.min.js"></script>
<script src="/js/public/owl.carousel.min.js"></script>
<script src="/js/public/jquery.isotope.min.js"></script>
<script src="/js/public/jquery.fitvids.js"></script>
<script src="/js/public/jquery.fancybox.pack.js"></script>
<script src="/js/public/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.2"></script>
<script src="/js/public/fancybox/helpers/jquery.fancybox-media.js?v=1.0.0"></script>
<script src="/js/public/jquery.slickforms.js"></script>
<script src="/js/public/sinstafeed.min.js"></script>
<script src="/js/public/retina.js"></script>
<script src="/js/public/google-code-prettify/prettify.js"></script>
<script src="/js/public/scripts.js"></script>
</body>
</html>