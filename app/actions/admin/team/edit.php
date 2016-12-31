<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  endHere();
}

if ( !isset( $actionD ) ) {
  endHere();
  exit();
}

$member = new Team();
if ( $actionD == 'new' ) {
  $member->Create();
}else{
  if (!$member->Load($actionD)) {
    endHere();
    exit();
  }
}


?>
<?php include_once __DIR__ . "/../_header.php"; ?>
  <script src="/js/adm/admin_update_input_fields.js"></script>
  <script src="/js/adm/admin_single_image_uploader.js"></script>

  <div class="bs-docs-header" id="content">
    <div class="container">
      
      <h1>
        <?php echo $actionD == "new" ? "Add Member" : "Edit Member" ?>
      </h1>
      
    </div>
  </div>

  <div class="container">
    <div class="row">

      <div class="col-sm-6">

        <div class="well well-sm well-general">
          <input type="text" class="form-control line jsonupdate"
                 name="name"
                 placeholder="Name"
                 value="<?php echo $member->name ?>"
                 data-id="<?php echo $member->_id ?>"
                 data-url="/administration/team/json"/>
        </div>

        <div class="well well-sm well-general">
          <input type="text" class="form-control line jsonupdate"
                 name="title"
                 placeholder="Title"
                 value="<?php echo $member->title ?>"
                 data-id="<?php echo $member->_id ?>"
                 data-url="/administration/team/json"/>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="well well-sm well-drag">
          <div class="singleimageuploader" data-url="/administration/team/upload/<?php echo $member->_id ?>">
            <p><i class="fa fa-cloud-upload"></i> Image Upload</p>

            <div class="progress" style="margin-bottom:3px; height:5px;">
              <div class="progress-bar progress-bar-success" role="progressbar" style="width:0;"></div>
            </div>
            <img src="<?php echo strlen( $member->image ) ? $member->imageUrl : "http://placehold.it/500x100&text=Image" ?>" style="width:100%;"/>
          </div>
        </div>
      </div>

    </div>
  </div>

<?php include_once __DIR__ . "/../_footer.php"; ?>