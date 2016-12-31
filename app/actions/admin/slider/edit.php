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

$slider = new Slider();

if ( $actionD == 'new' ) {
    $slider->Create();
} else {
    if ( !$slider->Load( sanitize_string( $actionD ) ) ) {
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
    <script src="/js/adm/admin-slider-isbutton-activation.js"></script>

    <div class="bs-docs-header" id="content">
        <div class="container">

            <h1>
                <?php echo $actionD == "new" ? "Add Slider Object" : "Edit Slider Object" ?>
            </h1>

        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-sm-8">

                <?php foreach ( $allLanguages as $lang ): ?>
                    <?php $languages = new Language(); ?>
                    <?php $languages->LoadByData( $lang ) ?>
                    <div class="col-sm-6" style="padding: 0 5px; margin: 0;">
                        <div class="well well-sm well-general">
                            <h4>
                                <?php echo $languages->name ?>
                            </h4>
                        <textarea class="form-control line jsonupdate"
                                  name="detail_<?php echo $languages->code ?>"
                                  placeholder="Detail"
                                  data-id="<?php echo $slider->_id ?>"
                                  data-url="/administration/slider/json"><?php if(isset( $slider->detail[$languages->code] ) && $actionD != "new" ) echo $slider->detail[$languages->code]; ?></textarea>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="col-sm-4">
                <div class="well well-sm well-drag">
                    <div class="singleimageuploader" data-url="/administration/slider/upload/<?php echo $slider->_id ?>">
                        <p><i class="fa fa-cloud-upload"></i> Image Upload</p>

                        <div class="progress" style="margin-bottom:3px; height:5px;">
                            <div class="progress-bar progress-bar-success" role="progressbar" style="width:0;"></div>
                        </div>
                        <img src="<?php echo strlen( $slider->image ) ? $slider->imageUrl : "http://placehold.it/500x100&text=Image" ?>" style="width:100%;"/>
                    </div>
                </div>

                <div class="well well-sm well-general">


                    <?php if ( $slider->isButton ): ?>
                        <button class="btn btn-success activatorIsButton btn-sm" data-url="/administration/slider/json"
                                data-id="<?php echo $slider->_id ?>"><i class="fa fa-eye"></i></button>
                    <?php else: ?>
                        <button class="btn btn-default activatorIsButton btn-sm " data-url="/administration/slider/json"
                                data-id="<?php echo $slider->_id ?>"><i class="fa fa-eye-slash"></i></button>
                    <?php endif; ?>Is Button
                </div>
            </div>


        </div>
    </div>


    <script type="text/javascript">
        $( function () {

            // Select file
            $( '.fileupload' ).on( 'click', '.upload_select', function ( e ) {
                e.preventDefault();
                $( this ).closest( ".fileupload" ).find( "input[type='file']" ).trigger( 'click' );
                return false;
            } );

            // File selected
            $( "input[type='file']" ).on( 'change', function () {
                var that = $( this );
                // Get file data
                var file = that.get( 0 ).files[0];
                var reader = new FileReader();
                reader.onload = function ( e ) {
                    var image = new Image();
                    image.src = e.target.result;

                    that.closest( ".fileupload" ).find( ".filethumbnail" ).remove();
                    var width = (image.width > that.closest( ".fileupload" ).width()) ? "100%" : image.width + "px";
                    var thumb = $( '<img>' ).attr( 'src', e.target.result ).addClass( 'filethumbnail' ).css( 'width', width );
                    that.closest( ".fileupload" ).prepend( thumb );
                };
                reader.readAsDataURL( file );
            } );
        } );

    </script>


<?php include_once __DIR__ . "/../_footer.php"; ?>