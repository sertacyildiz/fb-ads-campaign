<?php
// Simple security check
if (!isset($ping) || $ping != "pong") {
    endHere();
}

if (!isset($actionC)) {
    goBackHeader();
    endHere();
    exit;
}

$showcase = new Showcase();

if ($actionD == 'new') {
    $showcase->Create();
} else {
    if (!$showcase->Load(sanitize_string($actionD))) {
        goBackHeader();
        endHere();
        exit;
    }
}

$allLanguages = Language::LoadAll();

?>
<?php include_once __DIR__ . "/../_header.php"; ?>
    <script src="/js/adm/admin_multiple_file_uploader.js"></script>
    <script src="/js/adm/admin_update_input_fields.js"></script>
    <script src="/js/adm/admin_image_deleter_button.js"></script>

    <div class="bs-docs-header" id="content">
        <div class="container">

            <h1>
                <?php echo $actionD == "new" ? "Add Showcas" : "Edit Showcase" ?>
            </h1>

        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-sm-8">

                <?php foreach ($allLanguages as $lang): ?>
                    <?php $languages = new Language(); ?>
                    <?php $languages->LoadByData($lang) ?>
                    <div class="col-sm-6" style="padding: 0 5px; margin: 0;">
                        <div class="well well-sm well-general">
                            <h4>
                                <?php echo $languages->name ?>
                            </h4>
                            <input class="form-control line jsonupdate"
                                   name="title_<?php echo $languages->code ?>"
                                   placeholder="Title"
                                   value="<?php if (isset($showcase->title[$languages->code]) && $actionD != "new") echo $showcase->title[$languages->code]; ?>"
                                   data-id="<?php echo $showcase->_id ?>"
                                   data-url="/administration/showcase/json"/>

                        <textarea class="form-control line jsonupdate"
                                  name="detail_<?php echo $languages->code ?>"
                                  placeholder="Detail"
                                  data-id="<?php echo $showcase->_id ?>"
                                  data-url="/administration/showcase/json"><?php if (isset($showcase->detail[$languages->code]) && $actionD != "new") echo $showcase->detail[$languages->code]; ?></textarea>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="well well-sm well-drag">
                    <div class="multifileuploader"
                         data-url="/administration/showcase/upload/<?php echo $showcase->_id ?>">
                        <p><i class="fa fa-cloud-upload"></i> Image Upload</p>

                        <div class="uploads">
                            <?php foreach ($showcase->image as $photo): ?>

                                <div class="fileitem deletable">
                                    <input type="text"
                                           name="imageorder_<?php echo $photo['_id'] ?>"
                                           value="<?php echo $photo['order'] ?>"
                                           data-id="<?php echo $showcase->_id ?>"
                                           data-url="/administration/showcase/json"
                                           class="form-control line jsonupdate">

                                    <img src="<?php echo SHOWCASE_IMAGES_URL.'/'.$photo['name'] ?>" style="">

                                    <button data-id="<?php echo $showcase->_id ?>" data-image-id="<?php echo $photo['_id'] ?>" data-url="/administration/showcase/json" class="deleter btn btn-danger btn-xs">
                                        <i class="fa fa-times-circle"></i>
                                    </button>

                                </div>

                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(function () {

            // Select file
            $('.fileupload').on('click', '.upload_select', function (e) {
                e.preventDefault();
                $(this).closest(".fileupload").find("input[type='file']").trigger('click');
                return false;
            });

            // File selected
            $("input[type='file']").on('change', function () {
                var that = $(this);
                // Get file data
                var file = that.get(0).files[0];
                var reader = new FileReader();
                reader.onload = function (e) {
                    var image = new Image();
                    image.src = e.target.result;

                    that.closest(".fileupload").find(".filethumbnail").remove();
                    var width = (image.width > that.closest(".fileupload").width()) ? "100%" : image.width + "px";
                    var thumb = $('<img>').attr('src', e.target.result).addClass('filethumbnail').css('width', width);
                    that.closest(".fileupload").prepend(thumb);
                };
                reader.readAsDataURL(file);
            });
        });

    </script>


<?php include_once __DIR__ . "/../_footer.php"; ?>