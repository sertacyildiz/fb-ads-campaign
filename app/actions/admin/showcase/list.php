<?php

if ( !isset( $ping ) || $ping != "pong" ) {
    endHere();
}

if ( isset( $_GET[ 'page' ] ) ) {
    $page = sanitize_int( $_GET[ 'page' ] );
}

$showcase = new Showcase();
$shwcs = $showcase->LoadAll();

$allLangs = Language::LoadAll();
$langs = new Language();
?>
<?php include_once __DIR__ . "/../_header.php"; ?>
    <script src="/js/adm/admin_update_input_fields.js"></script>
    <script src="/js/adm/admin_activation_button.js"></script>
    <script src="/js/adm/admin_deleter_button.js"></script>

    <div class="bs-docs-header" id="content">
        <div class="container">
            <h1>Showcase</h1>
            <a href="/administration/showcase/edit/new" class="btn btn-default">
                <i class="fa fa-plus"></i> Create New Showcase
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
                    <th class="col-sm-3">Title</th>
                    <th class="col-sm-4">Detail</th>
                    <th class="col-sm-2" style="text-align: right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ( $shwcs as $p ): ?>
                    <?php
                    $showcase->LoadByData( $p );
                    ?>

                    <tr class="deletable">
                        <td>
                            <input type="text"
                                   name="order"
                                   value="<?php echo $showcase->order?>"
                                   data-id="<?php echo $showcase->_id ?>"
                                   class="form-control line jsonupdate"
                                   data-url="/administration/showcase/json"/>
                        </td>

                        <td>
                            <?php echo count($showcase->image) ?> Image
                        </td>

                        <td>
                            <table class="table table-condensed table-hover">

                                <?php foreach ( $allLangs as $l ): ?>
                                    <?php $langs->LoadByData( $l ) ?>


                                    <tr>

                                        <td class="inTableTitleColumn">
                                            <?php if ( isset( $showcase->title[ $langs->code ] ) && strlen( $showcase->title[ $langs->code ] ) ): ?>
                                                <span class="label label-success"><?php echo $langs->code ?></span>
                                            <?php else: ?>
                                                <span class="label label-warning"><?php echo $langs->code ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="inTableDataColumn">
                                            <?php
                                            if ( isset( $showcase->title[ $langs->code ] ) && strlen( $showcase->title[ $langs->code ] ) )
                                                echo $showcase->title[ $langs->code ];
                                            ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </table>

                        </td>

                        <td>
                            <table class="table table-condensed table-hover">

                                <?php foreach ( $allLangs as $l ): ?>
                                    <?php $langs->LoadByData( $l ) ?>


                                    <tr>

                                        <td class="inTableTitleColumn">
                                            <?php if ( isset( $showcase->detail[ $langs->code ] ) && strlen( $showcase->detail[ $langs->code ] ) ): ?>
                                                <span class="label label-success"><?php echo $langs->code ?></span>
                                            <?php else: ?>
                                                <span class="label label-warning"><?php echo $langs->code ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="inTableDataColumn">
                                            <?php
                                            if ( isset( $showcase->detail[ $langs->code ] ) && strlen( $showcase->detail[ $langs->code ] ) )
                                                echo $showcase->detail[ $langs->code ];
                                            ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </table>

                        </td>

                        <td style="text-align: right">
                            <div class="btn-group btn-group-sm">
                                <a href="/administration/showcase/edit/<?php echo $showcase->_id ?>" class="btn btn-default"><i
                                        class="fa fa-fw fa-edit"></i></a>
                                <?php if ( $showcase->isActive ): ?>
                                    <button class="btn btn-success activator btn-sm activebutton" data-url="/administration/showcase/json"
                                            data-id="<?php echo $showcase->_id ?>"><i class="fa fa-eye"></i></button>
                                <?php else: ?>
                                    <button class="btn btn-default activator btn-sm activebutton" data-url="/administration/showcase/json"
                                            data-id="<?php echo $showcase->_id ?>"><i class="fa fa-eye-slash"></i></button>
                                <?php endif; ?>
                                <button class="deleter btn btn-danger" data-id="<?php echo $showcase->_id ?>"
                                        data-url="/administration/showcase/json">
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