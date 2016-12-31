<?php
//$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
if(isset($actionA) && strlen($actionA)==2)
    $lang = $actionA;
else
    $lang = "tr";


switch ($lang){
    case 'en':
        include("languages/en.php");
        break;
    default:
        include("languages/tr.php");
        break;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/images/favicon.ico">
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
    <!--
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:400,600,700,400italic,600italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800' rel='stylesheet' type='text/css'>
    -->
    <link href="/css/public/type/fontello.css" rel="stylesheet">
    <link href="/css/public/type/budicons.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]-->
    <script src="/js/public/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <!--[endif]-->
</head>
<body>
<div class="body-wrapper">
<div class="navbar default">
    <div class="navbar-header">
        <div class="container">
            <div class="basic-wrapper">
                <a class="btn responsive-menu pull-right" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class='icon-menu-1'></i>
                </a>
                <a class="navbar-brand" href="#">
                    <img src="/images/markakod_logo.png" alt="" data-src="/images/markakod_logo.png" width="150" height="100" data-ret="/images/markakod_logo.png" />
                </a>
            </div>
            <nav class="collapse navbar-collapse pull-right">
                <ul class="nav navbar-nav">
                    <li><a href="#home"><?php echo $static_data_lang[ "home" ]; ?></a></li>
                    <li><a href="#services"><?php echo $static_data_lang['whatWeDo'] ?></a></li>
                    <li><a href="#portfolio"><?php echo $static_data_lang[ "portfolio" ]; ?></a></li>
                    <li><a href="#about"><?php echo $static_data_lang[ "about" ]; ?></a></li>
                    <li><a href="#pricing"><?php echo $static_data_lang[ "reference" ]; ?></a></li>
                    <li><a href="#contact"><?php echo $static_data_lang[ "contact" ]; ?></a></li>
                    <?php
                    $language = new Language();
                    $lngge = $language->LoadAll(false);
                    ?>
                    <?php foreach ( $lngge as $item ): ?>
                        <?php $language->LoadByData( $item ); ?>
                    <li><a href="/<?php echo $language->code ?>/"><img src="/images/<?php echo $language->code ?>.png" width="20" height="15"></a></li>
                    <?php endforeach ?>
                </ul>
            </nav>
        </div>
    </div>
    <!--/.nav-collapse -->
</div>
<!--/.navbar -->
<div id="home" class="section">
    <div class="light-wrapper">
        <div class="fullscreenbanner-container revolution">
            <div class="fullscreenbanner">
                <ul>

                    <?php
                    $slider = new Slider();
                    $sldr = $slider->LoadAll(false);
                    ?>
                    <?php foreach ( $sldr as $item ): ?>
                        <?php $slider->LoadByData( $item ); ?>
                            <li data-transition="fade"> <img src="<?php echo $slider->imageUrl; ?>" alt="" />
                                <div class="caption small lite sfb" data-x="center" data-y="245" data-speed="900" data-start="1500" data-easing="Sine.easeOut"><?php echo $slider->detail[$lang]; ?></div>

                                <?php if ( $slider->isButton ): ?>
                                    <div class="caption small lite sfb" data-x="center" data-y="319" data-speed="900" data-start="2200" data-easing="Sine.easeOut">
                                        <div class="smooth"><a href="#portfolio" class="btn btn-border-lite"><?php echo $static_data_lang[ "seeOurProjects" ]; ?></a></div>
                                    </div>
                                <?php endif; ?>

                            </li>
                    <?php endforeach ?>
                </ul>
                <div class="tp-bannertimer tp-bottom"></div>
            </div>
            <!-- /.fullscreenbanner -->
        </div>
        <!-- /.fullscreenbanner-container -->
    </div>
</div>
<div id="services" class="section anchor">
    <div class="light-wrapper">
        <div class="container inner">
            <h2 class="section-title text-center"><?php echo $static_data_lang['whatWeDo'] ?></h2>
            <p class=" main text-center"><?php echo $static_data_lang['whatWeDo_text'] ?></p>
            <br>
            <div class="row text-center services-1">
                <div class="col-sm-6">
                    <div class="col-wrapper">
                        <h3><u>ONLINE</u></h3>
                        <?php echo $static_data_lang['whatWeDo_online_list'] ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="col-wrapper">
                        <h3><u>OFFLINE</u></h3>
                        <?php echo $static_data_lang['whatWeDo_offline_list'] ?>
                    </div>
                </div>
            </div>
            <!-- /.services -->

        </div>
        <!-- /.container -->
    </div>
</div>
<!-- /#home -->

<div id="portfolio" class="section anchor">
    <div class="dark-wrapper">
        <div class="container inner">
            <h2 class="section-title text-center"><?php echo $static_data_lang[ "project" ]; ?></h2>
            <div class="grid-portfolio fix-portfolio">
                <!--
                <ul class="filter">
                    <li><a class="active" href="#" data-filter="*">All</a></li>
                    <li><a href="#" data-filter=".web">Web Design</a></li>
                    <li><a href="#" data-filter=".graphic">Graphic Design</a></li>
                    <li><a href="#" data-filter=".photo">Photography</a></li>
                    <li><a href="#" data-filter=".motion">Motion Design</a></li>
                </ul>
                 -->

                <!-- /filter -->

                <ul class="content-slider items">
                    <?php
                    $showcase = new Showcase();
                    $shwcs = $showcase->LoadAll(false);
                    ?>
                    <?php foreach ( $shwcs as $item ): ?>
                        <?php $showcase->LoadByData( $item ); ?>
                        <li class="item thumb web">
                            <figure>
                                <a href="#" data-contenturl="portfolio-post" data-lang="<?php echo $lang ?>" data-id="<?php echo $showcase->_id ?>" data-callback="callPortfolioScripts();" data-contentcontainer=".pcw">
                                    <div class="text-overlay">
                                        <div class="info">
                                            <h3><?php echo $item['title'][$lang]; ?></h3>
                                            <?php echo $item['detail'][$lang]; ?>
                                        </div>
                                    </div>
                                    <?php if(isset($showcase->image[0])){ ?>
                                    <img src="<?php echo SHOWCASE_IMAGES_URL.'/'.$showcase->image[0]['name']; ?>" alt="" width="440" height="330" />
                                    <?php } ?>
                                </a>
                            </figure>
                        </li>

                    <?php endforeach ?>
                </ul>
                <!-- /.items -->
            </div>
            <!-- /.portfolio -->
        </div>
    </div>
</div>
<!-- /#portfolio -->


<div id="about" class="section anchor">
    <div class="light-wrapper">
        <div class="container inner">
            <h2 class="section-title text-center"><?php echo $static_data_lang["about"]; ?></h2>
            <div class="row">
                <?php
                    $abouts = new About();
                    $about = $abouts->LoadAll(false);
                ?>
                <?php foreach ( $about as $item ): ?>
                <div class="col-sm-12">
                    <p><?php echo $item['detail'][$lang]; ?></p>
                </div>

                <?php endforeach ?>
            </div>
            <div class="pricing row">

                <?php
                $businessPartner = new BusinessPartner();
                $bsnssPrtnr = $businessPartner->LoadAll(false);
                ?>

                <?php foreach ( $bsnssPrtnr as $p ): ?>
                    <?php
                    $businessPartner->LoadByData( $p );
                    ?>

                    <div class="col-sm-12">

                        <div class="col-sm-3">
                            <div class="features">
                                <img src="<?php echo $businessPartner->imageUrl; ?>" alt="" width="230" height="160" />
                            </div>
                        </div>


                        <div class="col-sm-9" style="text-align: left;">
                            <?php echo $businessPartner->detail[$lang] ?>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
            <br>
            <h1 style="text-align: center;"><b><?php echo $static_data_lang["team"]; ?></b></h1>
            <div class="row team text-center">
                <?php
                    $teamMember = new Team();

                    $team = $teamMember->LoadAll(false);
                ?>
                <?php foreach ( $team as $p ): ?>
                <?php
                $teamMember->LoadByData( $p );
                ?>

                <div class="col-sm-4">
                    <img src="<?php echo $teamMember->imageUrl ?>" alt="" width="200" height="150" />
                    <h4><?php echo $teamMember->name; ?></h4>
                    <span class="biz-title colored"><?php echo $teamMember->title; ?></span>
                </div>

                <?php endforeach ?>

            </div>
        </div>
    </div>
</div>
<!-- /#about -->
<div id="pricing" class="section anchor">
    <div class="light-wrapper">
        <div class="container">
            <h2 class="section-title text-center"><?php echo $static_data_lang[ "reference" ]; ?></h2>
            <div class="pricing row">

                <?php
                $reference = new Reference();
                $ref = $reference->LoadAll(false);
                ?>

                <?php foreach ( $ref as $p ): ?>
                <?php
                    $reference->LoadByData( $p );
                ?>
                <div class="col-sm-2 marginTopBottom">
                    <div class="plan">
                        <div class="features">
                            <img src="<?php echo $reference->imageUrl; ?>" alt="" width="100" height="100" />
                        </div>
                    </div>
                </div>
                <!-- /.col-sm-2  -->

                <?php endforeach; ?>

            </div>
            <!-- /.pricing  -->

        </div>
    </div>
</div>

    <div style="display:none"><?php include_once("portfolio-post.php"); ?></div>
<div id="contact" class="section anchor">
    <div class="dark-wrapper">
        <div class="container inner">
            <div class="thin text-center">
                <h2 class="section-title text-center"><?php echo $static_data_lang[ "contact" ]; ?></h2>
                <ul class="contact-info">
                    <li><i class="icon-location"></i><?php echo $static_data_lang[ "contact_address" ]; ?> </li>
                    <li><i class="icon-phone"></i>0(212) 346 43 63</li>
                    <!--<li><i class="icon-mail"></i><a href="first.last@email.com">email adresi</a> </li>-->
                </ul>
                <div class="divide50"></div>
                <div class="form-container">
                    <div class="response alert alert-success"></div>
                    <form class="forms" action="/sendMail" method="post">
                        <fieldset>
                            <ol class="row">
                                <li class="form-row text-input-row name-field col-sm-6">
                                    <input type="text" name="name" class="text-input defaultText required" title="Name (Required)"/>
                                </li>
                                <li class="form-row text-input-row email-field col-sm-6">
                                    <input type="text" name="email" class="text-input defaultText required email" title="Email (Required)"/>
                                </li>
                                <li class="form-row text-area-row col-sm-12">
                                    <textarea name="message" class="text-area required" title="Your message"></textarea>
                                </li>
                                <li class="form-row hidden-row">
                                    <input type="hidden" name="hidden" value="" />
                                </li>
                                <li class="nocomment">
                                    <label for="nocomment">Leave This Field Empty</label>
                                    <input id="nocomment" value="" name="nocomment" />
                                </li>
                                <li class="button-row">
                                    <input type="submit" value="<?php echo $static_data_lang[ "sendMessage" ]; ?>" name="submit" class="btn btn-submit bm0" />
                                </li>
                            </ol>
                            <input type="hidden" name="v_error" id="v-error" value="Required" />
                            <input type="hidden" name="v_email" id="v-email" value="Enter a valid email" />
                        </fieldset>
                    </form>
                </div>
                <!-- /.form-container -->
                <div class="clearfix"></div>
                <div
            </div>
        </div>
    </div>
    <br><br>
    <div id="map"></div>
</div>
<!-- /#contact -->
<footer class="footer">
    <div class="container inner">
        <p class="pull-left">© 2015 <?php echo $static_data_lang[ "copyright" ]; ?></p>
        <ul class="social pull-right">
            <li><a href="https://twitter.com/markakod" target="_blank"><i class="icon-s-twitter"></i></a></li>
            <li><a href="https://www.facebook.com/MarkakodDigital" target="_blank"><i class="icon-s-facebook"></i></a></li>
            <li><a href="https://www.linkedin.com/company/692374?trk=prof-0-ovw-curr_pos" target="_blank"><i class="icon-s-linkedin"></i></a></li>
            <li><a href="https://www.youtube.com/user/markakodhq" target="_blank"><i class="icon-s-youtube"></i></a></li>
        </ul>
    </div>
    <!-- .container -->
</footer>
<!-- /footer -->
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
<script src="/js/public/instafeed.min.js"></script>
<script src="/js/public/retina.js"></script>
<script src="/js/public/google-code-prettify/prettify.js"></script>
<script src="/js/public/scripts.js"></script>

<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1xdEVYy8IZdBKJGQp_QpDWaNQT7ZHGhY">
</script>
<script type="text/javascript">
    function initialize() {
        var mapOptions = {
            zoom: 16,
            center: { lat: 41.048786, lng: 29.027575},
            scrollwheel: false,
            mapTypeControl: false,
            panControl: false,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.LEFT_TOP
            },
            streetViewControl: true,
            streetViewControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.LEFT_TOP
            }
        };
        var map = new google.maps.Map( document.getElementById( "map" ), mapOptions );

        var myLatlng = new google.maps.LatLng(41.048786,29.027575);

        var contentString = '<p><b>MARKAKOD</b></p>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });


        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Markakod'
        });

        infowindow.open(map,marker);

    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

</body>
</html>