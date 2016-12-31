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

$reference = new Reference();
if ( $actionD == 'new' ) {
    $reference->Create();
} else {
    if ( !$reference->Load( sanitize_string( $actionD ) ) ) {
        goBackHeader();
        endHere();
        exit;
    }
}
?>
<?php include_once __DIR__ . "/../_header.php"; ?>
    <script src="/js/adm/admin_update_input_fields.js"></script>
    <script src="/js/adm/admin_single_image_uploader.js"></script>

  <div class="bs-docs-header" id="content">
    <div class="container">

        <h1>
            <?php echo $actionD == "new" ? "Add Reference" : "Edit Reference" ?>
        </h1>

    </div>
  </div>

  <div class="container">
    <div class="row">
        <div class="col-sm-4">

            <div class="well well-sm well-drag">
                <div class="singleimageuploader" data-url="/administration/reference/upload/<?php echo $reference->_id ?>">
                    <p><i class="fa fa-cloud-upload"></i> Image Upload</p>

                    <div class="progress" style="margin-bottom:3px; height:5px;">
                        <div class="progress-bar progress-bar-success" role="progressbar" style="width:0;"></div>
                    </div>
                    <img src="<?php echo strlen( $reference->image ) ? $reference->imageUrl : "http://placehold.it/500x100&text=Background" ?>" style="width:100%;"/>
                </div>
            </div>
        </div>
        <div class="col-sm-8">

            <div class="well well-sm well-general">
                <input type="text" class="form-control line jsonupdate"
                       name="name"
                       placeholder="Name"
                       value="<?php echo $reference->name ?>"
                       data-id="<?php echo $reference->_id ?>"
                       data-url="/administration/reference/json"/>
            </div>


        </div>
    </div>
  </div>

<?php include_once __DIR__ . "/../_footer.php"; ?>