<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
    endHere();
}

if ( !isset( $actionC ) ) {
    goBackHeader();
    endHere();
    exit;
}

$about = new About();

if ( $actionD == 'new' ) {
    $about->Create();
} else {
    if ( !$about->Load( sanitize_string( $actionD ) ) ) {
        goBackHeader();
        endHere();
        exit;
    }
}

$allLanguages = Language::LoadAll();

?>
<?php include_once __DIR__ . "/../_header.php"; ?>
    <script src="/js/adm/admin_update_input_fields.js"></script>
    <script src="/js/adm/admin_single_image_uploader.js"></script>

    <div class="bs-docs-header" id="content">
        <div class="container">

            <h1>
                <?php echo $actionD == "new" ? "Add About" : "Edit About" ?>
            </h1>

        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-sm-12">

                <?php foreach ( $allLanguages as $lang ): ?>
                    <?php $languages = new Language(); ?>
                    <?php $languages->LoadByData( $lang ) ?>
                    <div class="col-sm-4" style="padding: 0 5px; margin: 0;">
                        <div class="well well-sm well-general">
                            <h4>
                                <?php echo $languages->name ?>
                            </h4>
                        <textarea class="form-control line jsonupdate"
                                  name="detail_<?php echo $languages->code ?>"
                                  placeholder="Detail"
                                  data-id="<?php echo $about->_id ?>"
                                  data-url="/administration/about/json"><?php if(isset( $about->detail[$languages->code] ) && $actionD != "new" ) echo $about->detail[$languages->code]; ?></textarea>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>


        </div>
    </div>


<?php include_once __DIR__ . "/../_footer.php"; ?>