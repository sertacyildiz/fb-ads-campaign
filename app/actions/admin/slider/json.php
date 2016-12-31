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
$slider = new Slider();
if (!$slider->Load($id)) {
    echo json_encode(array('OK' => 0, 'MSG' => 'Unable to load item'));
    endHere();
    exit();
}


if ($_POST['name'] == 'order') {
    $val = sanitize_int($_POST['value']);
    $slider->SetOrder($val);
    echo json_encode(array('OK' => 1, 'MSG' => 'Success : Order'));
    endHere();
    exit();
}

if ( $_POST[ 'name' ] == 'activate' ) {
    $active = !$slider->isActive;
    $slider->SetIsActive( $active );
    echo json_encode( array( 'OK' => 1, 'MSG' => 'Success : Active', 'ISACTIVE' => $slider->isActive ? 1 : 0 ) );
    endHere();
    exit();
}

if ( $_POST[ 'name' ] == 'isButton' ) {
    $active = !$slider->isButton;
    $slider->SetIsButton( $active );
    echo json_encode( array( 'OK' => 1, 'MSG' => 'Success : isButton', 'ISBUTTONACTIVE' => $slider->isButton ? 1 : 0 ) );
    endHere();
    exit();
}

if($_POST['name']=='delete'){
    $slider->Delete();
    echo json_encode(array('OK'=>1,'MSG'=>'Success : Delete'));
    endHere();
    exit();
}

$detail = explode('_',$_POST['name']);
$lang =$detail[1];
$name = $detail[0];
if($name == 'detail')
{
    $val = sanitize_string($_POST['value']);
    $slider->SetDetail($lang,$val);
    echo json_encode(array('OK' => 1, 'MSG' => 'Success : Detail'));
    endHere();
    exit();
}

