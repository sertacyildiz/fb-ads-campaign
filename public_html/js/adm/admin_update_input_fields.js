/**
 * Update json input fields
 */
$( function () {

  function Updater ( dom ) {
    var that = dom;
    var role = dom.attr( 'role' );
    var value = dom.val();
    var name = dom.attr( 'name' );
    var id = dom.attr( 'data-id' );
    var url = dom.attr( 'data-url' );

    if (dom.attr( 'type' ) == 'checkbox') {
      // Value as array
      value = $( 'input[role="' + role + '"].jsonupdate:checked' ).map( function () {
        return $( this ).val();
      } ).get();
    }

    if (dom.prop( "tagName" ).toLowerCase().trim() == 'select') {
      value = dom.find( 'option:selected' ).val();
    }

    that.css( 'border-bottom', ' 2px solid #FFD163' );
    $.ajax( {
      dataType: 'json',
      url: url,
      type: 'post',
      data: {name: name, id: id, value: value},
      context: document.body,
      error: function ( xhr, textStatus, errorThrown ) {
        console.log( textStatus, errorThrown );
        that.css( 'border-bottom', ' 2px solid #FF1865' );
      },
      success: function ( data, textStatus, xhr ) {
        console.log( data );
        if (data.OK != 1) {
          that.css( 'border-bottom', '2px solid #FF4418' );
        } else {
          that.css( 'border-bottom', '2px solid #90CF2A' );
        }
      }
    } );
  }

  var body = $( 'body' );
  body.on( 'keyup', '.jsonupdate', function () {
    Updater( $( this ) );
  } );
  body.on( 'change', 'input[type="checkbox"].jsonupdate', function () {
    Updater( $( this ) );
  } );
  body.on( 'change', 'select.jsonupdate', function () {
    Updater( $( this ) );
  } );
} );