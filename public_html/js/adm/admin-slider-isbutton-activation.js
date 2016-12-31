/**
 * Item activator
 */
$( function () {
    function IsButtonActivator ( dom ) {
        var child = dom.find( 'i' );
        var id = dom.attr( 'data-id' );
        var url = dom.attr( 'data-url' );

        $.ajax( {
            dataType: 'json',
            url: url,
            type: 'post',
            data: {name: 'isButton', id: id, value: ''},
            context: document.body,
            error: function ( xhr, textStatus, errorThrown ) {
                console.log( textStatus, errorThrown );
            },
            success: function ( data, textStatus, xhr ) {
                console.log( data );
                if (data.OK != 1) {
                    alert( data.MSG );
                } else {
                    if (data.ISBUTTONACTIVE != 1) {
                        dom.removeClass( 'btn-danger' ).addClass( 'btn-success' );
                        child.removeClass( 'fa-eye-slash' ).addClass( 'fa-eye' );
                    } else {
                        dom.addClass( 'btn-danger' ).removeClass( 'btn-success' );
                        child.addClass( 'fa-eye-slash' ).removeClass( 'fa-eye' );
                    }
                }
            }
        } );
    }

    $( 'body' ).on( 'click', '.activatorIsButton', function () {
        IsButtonActivator( $( this ) );
    } );
} );