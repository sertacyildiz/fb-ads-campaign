<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
    endHere();
}


if (!isset($_POST['id'])) {
    echo json_encode(array('OK' => 0, 'MSG' => 'Id is missing'));
    endHere();
    exit();
}

if (!isset($_POST['name']) || !isset($_POST['value'])) {
    echo json_encode(array('OK' => 0, 'MSG' => 'Missing Data'));
    endHere();
    exit();
}

$id = sanitize_string($_POST['id']);
$showcase = new Showcase();
if (!$showcase->Load($id)) {
    echo json_encode(array('OK' => 0, 'MSG' => 'Unable to load item'));
    endHere();
    exit();
}


if ($_POST['name'] == 'order') {
    $val = sanitize_int($_POST['value']);
    $showcase->SetOrder($val);
    echo json_encode(array('OK' => 1, 'MSG' => 'Success : Order'));
    endHere();
    exit();
}

if ( $_POST[ 'name' ] == 'activate' ) {
    $active = !$showcase->isActive;
    $showcase->SetIsActive( $active );
    echo json_encode( array( 'OK' => 1, 'MSG' => 'Success : Active', 'ISACTIVE' => $showcase->isActive ? 1 : 0 ) );
    endHere();
    exit();
}

if($_POST['name']=='delete'){
    $showcase->Delete();
    echo json_encode(array('OK'=>1,'MSG'=>'Success : Delete'));
    endHere();
    exit();
}

if($_POST['name'] == 'imagedelete')
{
    $_id = sanitize_string($_POST['imageId']);
    $showcase->DeleteSingleImage($id,$_id);
    echo json_encode(array('OK' => 1, 'MSG' => 'Success : DeleteImage'));
    endHere();
    exit();
}

$title = explode('_',$_POST['name']);
$lang =$title[1];
$name = $title[0];
if($name == 'title')
{
    $val = sanitize_string($_POST['value']);
    $showcase->SetTitle($lang,$val);
    echo json_encode(array('OK' => 1, 'MSG' => 'Success : Title'));
    endHere();
    exit();
}

$detail = explode('_',$_POST['name']);
$lang =$detail[1];
$name = $detail[0];
if($name == 'detail')
{
    $val = sanitize_string($_POST['value']);
    $showcase->SetDetail($lang,$val);
    echo json_encode(array('OK' => 1, 'MSG' => 'Success : Detail'));
    endHere();
    exit();
}

$imageOrder = explode('_',$_POST['name']);
$id =$imageOrder[1];
$name = $imageOrder[0];
if($name == 'imageorder')
{
    $val = sanitize_int($_POST['value']);
    $showcase->SetImageOrder($id,$val);
    echo json_encode(array('OK' => 1, 'MSG' => 'Success : ImageOrder'));
    endHere();
    exit();
}