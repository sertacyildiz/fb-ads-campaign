<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  endHere();
}

if ( isset( $_GET[ 'page' ] ) ) {
  $page = sanitize_int( $_GET[ 'page' ] );
}

$reference = new Reference();
$rfrnc = $reference->LoadAll();

?>
<?php include_once __DIR__ . "/../_header.php"; ?>
    <script src="/js/adm/admin_update_input_fields.js"></script>
    <script src="/js/adm/admin_activation_button.js"></script>
    <script src="/js/adm/admin_deleter_button.js"></script>

  <div class="bs-docs-header" id="content">
    <div class="container">
      <h1>Reference</h1>
        <a href="/administration/reference/edit/new" class="btn btn-default">
            <i class="fa fa-plus"></i> Create New Reference
        </a>
    </div>
  </div>

  <div class="container">

    <div class="row">
      <div class="col-sm-12">
        <table class="table table-condensed table-hover">
          <thead>
          <tr>
              <th class="col-sm-1">Order</th>
              <th class="col-sm-3">Image</th>
              <th class="col-sm-4">Name</th>
              <th class="col-sm-4"></th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ( $rfrnc as $item ): ?>
              <?php $reference->LoadByData( $item ) ?>
            <tr class="deletable">

                <td>

                    <div class="well well-sm well-general">
                        <input type="text" class="form-control line jsonupdate"
                               name="order"
                               placeholder="Order"
                               value="<?php echo $reference->order ?>"
                               data-id="<?php echo $reference->_id ?>"
                               data-url="/administration/reference/json"/>
                    </div>
                </td>

            <td>
                <img src="<?php echo $reference->imageUrl ?>" style="max-height: 80px;"/>
            </td>

              <td>
                <p><?php echo $reference->name ?></p>
              </td>

                <td style="text-align: right">
                    <div class="btn-group btn-group-sm">
                        <a href="/administration/reference/edit/<?php echo $reference->_id ?>" class="btn btn-default"><i class="fa fa-fw fa-edit"></i></a>

                        <?php if ( $reference->isActive): ?>
                            <button class="activator btn btn-success" data-id="<?php echo $reference->_id ?>" data-url="/administration/reference/json">
                                <i class="fa fa-eye"></i>
                            </button>
                        <?php else: ?>
                            <button class="activator btn btn-default" data-id="<?php echo $reference->_id ?>" data-url="/administration/reference/json">
                                <i class="fa fa-eye-slash"></i>
                            </button>
                        <?php endif; ?>

                        <button class="deleter btn btn-danger" data-id="<?php echo $reference->_id ?>" data-url="/administration/reference/json">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </td>
            </tr>
          <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <style type="text/css">
    td {
      vertical-align: middle !important;
    }

    h4, p {
      margin: 0;
      padding: 0;
    }

    dl {
      padding: 0;
      margin: 0;
    }
  </style>

<?php include_once __DIR__ . "/../_footer.php"; ?>