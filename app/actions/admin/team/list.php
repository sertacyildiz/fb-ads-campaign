<?php

if ( !isset( $ping ) || $ping != "pong" ) {
    endHere();
}

$page = 1;
if ( isset( $_GET[ 'page' ] ) ) {
    $page = sanitize_int( $_GET[ 'page' ] );
}

$team = new Team();
$team = $team->LoadAll();

?>
<?php include_once __DIR__ . "/../_header.php"; ?>
<script src="/js/adm/admin_update_input_fields.js"></script>
<script src="/js/adm/admin_activation_button.js"></script>
<script src="/js/adm/admin_deleter_button.js"></script>

<div class="bs-docs-header" id="content">
    <div class="container">
        <h1>Team</h1>
        <a href="/administration/team/edit/new" class="btn btn-default">
            <i class="fa fa-plus"></i> Create New Person
        </a>
    </div>
</div>


<div class="container">
    <div class="row">



        <table class="table table-condensed table-hover">
            <thead>
            <tr>
                <th class="col-sm-2">Order</th>
                <th class="col-sm-3">Name</th>
                <th class="col-sm-3">Title</th>
                <th class="col-sm-1">Photo</th>
                <th class="col-sm-3" style="text-align: right">Actions</th>
            </tr>
            </thead>
            <tbody>
              <?php foreach($team as $t):?>
                  <?php $member = new Team(); ?>
                  <?php $member->Load($t['_id']) ?>

                  <tr class="deletable">
                    <td>
                      <input type="text"
                             name="order"
                             value="<?php echo $member->order?>"
                             data-id="<?php echo $member->_id ?>"
                             class="form-control line jsonupdate"
                             data-url="/administration/team/json"/>
                    </td>

                    <td>
                      <?php echo $member->name ?>
                    </td>

                    <td>
                      <?php echo  $member->title?>
                    </td>

                    <td>
                      <img src="<?php echo $member->imageUrl ?>" width="100" height="100" alt=""/>
                    </td>

                    <td>
                      <div class="btn-group btn-group-sm">
                        <a href="/administration/team/edit/<?php echo $member->_id ?>" class="btn btn-default"><i
                              class="fa fa-fw fa-edit"></i></a>
                        <?php if ( $member->isActive ): ?>
                          <button class="btn btn-success activator btn-sm activebutton" data-url="/administration/team/json"
                                  data-id="<?php echo $member->_id ?>"><i class="fa fa-eye"></i></button>
                        <?php else: ?>
                          <button class="btn btn-default activator btn-sm activebutton" data-url="/administration/team/json"
                                  data-id="<?php echo $member->_id ?>"><i class="fa fa-eye-slash"></i></button>
                        <?php endif; ?>
                        <button class="deleter btn btn-danger" data-id="<?php echo $member->_id ?>"
                                data-url="/administration/team/json">
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

    .completed {
        opacity: 0.3;
    }

    .dl-horizontal dt {
        width: 70px;
    }

    .dl-horizontal dd {
        margin-left: 80px;
    }

    .date {
        margin: 0;
        padding: 5px;
        font-size: 12px;
        text-align: center;
    }
</style>

<?php include_once __DIR__ . "/../_footer.php"; ?>