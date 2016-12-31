<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
    endHere();
}

$languages = Language::LoadAll();


?>
<?php include_once __DIR__ . "/../_header.php"; ?>
<script src="/js/adm/admin_update_input_fields.js"></script>
<script src="/js/adm/admin_activation_button.js"></script>
<script src="/js/adm/admin_deleter_button.js"></script>
<div class="bs-docs-header" id="content">
    <div class="container">
        <h1>Languages</h1>
        <a id="btnaddlang" class="btn btn-default">
            <i class="fa fa-flag-o"></i> Add A Language
        </a>
    </div>
</div>

<div class="container">

    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <table class="table table-condensed table-hover">
                <thead>
                <tr>
                    <th class="col-sm-2">Order</th>
                    <th class="col-sm-4">Name</th>
                    <th class="col-sm-4">Code</th>
                    <th class="col-sm-2">Actions</th>
                </tr>
                </thead>
                <tbody id="languagetablebody">
                  <?php foreach($languages as $l):?>
                      <?php $lang = new Language(); ?>
                      <?php $lang->Load($l['_id']) ?>

                      <tr class="deletable">
                        <td>
                          <input type="text"
                                 name="order"
                                 value="<?php echo $lang->order?>"
                                 data-id="<?php echo $lang->_id ?>"
                                 class="form-control line jsonupdate"
                                 data-url="/administration/languages/json"/>
                        </td>
                        
                        <td>
                          <input type="text"
                                 name="name"
                                 value="<?php echo $lang->name?>"
                                 data-id="<?php echo $lang->_id ?>"
                                 class="form-control line jsonupdate"
                                 data-url="/administration/languages/json"/>
                        </td>
                        <td>
                          <input type="text"
                                 name="code"
                                 value="<?php echo $lang->code?>"
                                 data-id="<?php echo $lang->_id ?>"
                                 class="form-control line jsonupdate"
                                 data-url="/administration/languages/json"/>
                        </td>
                        <td>
                          <div class="btn-group btn-group-sm">
                            <?php if ( $lang->isActive ): ?>
                              <button class="btn btn-success activator btn-sm activebutton" data-url="/administration/languages/json"
                                      data-id="<?php echo $lang->_id ?>"><i class="fa fa-eye"></i></button>
                            <?php else: ?>
                              <button class="btn btn-default activator btn-sm activebutton" data-url="/administration/languages/json"
                                      data-id="<?php echo $lang->_id ?>"><i class="fa fa-eye-slash"></i></button>
                            <?php endif; ?>
                            <button class="deleter btn btn-danger" data-id="<?php echo $lang->_id ?>"
                                    data-url="/administration/languages/json">
                              <i class="fa fa-times"></i>
                            </button>

                          </div>
                        </td>
                        
                        
                      </tr>
                      
                      
                  <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<style type="text/css">
    td {
        vertical-align: middle !important;
    }

    .buttons {
        text-align: right;
    }
</style>
<script src="/js/adm/admin-language-add.js"></script>
<?php include_once __DIR__ . "/../_footer.php"; ?> 