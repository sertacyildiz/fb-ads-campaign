<?php

if ( !isset( $ping ) || $ping != "pong" ) {
    endHere();
}

if ( isset( $_GET[ 'page' ] ) ) {
    $page = sanitize_int( $_GET[ 'page' ] );
}

$businessPartner = new BusinessPartner();
$bsnssPrtnr = $businessPartner->LoadAll();

$allLangs = Language::LoadAll();
$langs = new Language();
?>
<?php include_once __DIR__ . "/../_header.php"; ?>
    <script src="/js/adm/admin_update_input_fields.js"></script>
    <script src="/js/adm/admin_activation_button.js"></script>
    <script src="/js/adm/admin_deleter_button.js"></script>

    <div class="bs-docs-header" id="content">
        <div class="container">
            <h1>Business Partner</h1>
            <a href="/administration/businesspartner/edit/new" class="btn btn-default">
                <i class="fa fa-plus"></i> Create New Business Partner
            </a>
        </div>
    </div>


    <div class="container">
        <div class="row">


            <table class="table table-condensed table-hover">
                <thead>
                <tr>
                    <th class="col-sm-1">Order</th>
                    <th class="col-sm-2">Image</th>
                    <th class="col-sm-7">Detail</th>
                    <th class="col-sm-2" style="text-align: right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ( $bsnssPrtnr as $p ): ?>
                    <?php
                    $businessPartner->LoadByData( $p );
                    ?>

                    <tr class="deletable">
                        <td>
                            <input type="text"
                                   name="order"
                                   value="<?php echo $businessPartner->order?>"
                                   data-id="<?php echo $businessPartner->_id ?>"
                                   class="form-control line jsonupdate"
                                   data-url="/administration/businesspartner/json"/>
                        </td>

                        <td>
                            <img src="<?php echo strlen( $businessPartner->image ) ? $businessPartner->imageUrl : "http://placehold.it/100x100&text=Image" ?>" width="100" height="100">
                        </td>

                        <td>
                            <table class="table table-condensed table-hover">

                                <?php foreach ( $allLangs as $l ): ?>
                                    <?php $langs->LoadByData( $l ) ?>


                                        <tr>

                                            <td class="inTableTitleColumn">
                                                <?php if ( isset( $businessPartner->detail[ $langs->code ] ) && strlen( $businessPartner->detail[ $langs->code ] ) ): ?>
                                                    <span class="label label-success"><?php echo $langs->code ?></span>
                                                <?php else: ?>
                                                    <span class="label label-warning"><?php echo $langs->code ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="inTableDataColumn">
                                                <?php
                                                    if ( isset( $businessPartner->detail[ $langs->code ] ) && strlen( $businessPartner->detail[ $langs->code ] ) )
                                                        echo $businessPartner->detail[ $langs->code ];
                                                ?>
                                            </td>

                                        </tr>

                                <?php endforeach; ?>

                            </table>

                        </td>

                        <td style="text-align: right">
                            <div class="btn-group btn-group-sm">
                                <a href="/administration/businesspartner/edit/<?php echo $businessPartner->_id ?>" class="btn btn-default"><i
                                        class="fa fa-fw fa-edit"></i></a>
                                <?php if ( $businessPartner->isActive ): ?>
                                    <button class="btn btn-success activator btn-sm activebutton" data-url="/administration/businesspartner/json"
                                            data-id="<?php echo $businessPartner->_id ?>"><i class="fa fa-eye"></i></button>
                                <?php else: ?>
                                    <button class="btn btn-default activator btn-sm activebutton" data-url="/administration/businesspartner/json"
                                            data-id="<?php echo $businessPartner->_id ?>"><i class="fa fa-eye-slash"></i></button>
                                <?php endif; ?>
                                <button class="deleter btn btn-danger" data-id="<?php echo $businessPartner->_id ?>"
                                        data-url="/administration/businesspartner/json">
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


    <style type="text/css">
        .inTableTitleColumn{
            width: 20px;
        }

        .inTableDataColumn{
            width: %100;
        }

        td {
            vertical-align: middle !important;
        }
    </style>

<?php include_once __DIR__ . "/../_footer.php"; ?>