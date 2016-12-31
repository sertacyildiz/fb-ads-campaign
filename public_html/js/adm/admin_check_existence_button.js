$( function () {
  $( ".checkexistence" ).on( "click", function () {
    var that = $( this );
    var id = $( this ).attr( "data-id" );
    $.ajax( {
      dataType: 'json',
      url: '/administration/team/detail/checkexistence',
      type: 'post',
      data: {id: id},
      context: document.body,
      error: function ( xhr, textStatus, errorThrown ) {
        console.log( textStatus, errorThrown );
      },
      success: function ( data, textStatus, xhr ) {
        console.log( data );
        if (data.id == 0) {
          // Deleted
          that.html( "Deleted!" );
          that.addClass( "btn-danger" );
        } else {
          that.html( "Exists.." );
          that.addClass( "btn-success" );
        }
      }
    } );
  } );
} );