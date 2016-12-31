$( function () {

  function MultiFileUploader ( dom ) {
    var parent = dom;
    var url = parent.attr( 'data-url' );
    var uploads = dom.find( '.uploads' );
    var click = parent.find( 'p' );

    var uploadFile = function ( file, holder ) {
      var progress = holder.find( '.progress-bar' );

      var size = file.size;
      var xhr = new XMLHttpRequest();
      xhr.open( 'post', url, true );
      xhr.setRequestHeader( 'X-File-Name', file.name );
      xhr.setRequestHeader( 'X-File-Size', file.size );
      xhr.setRequestHeader( 'X-File-Type', file.type );

      xhr.onload = function ( e ) {
        var response = JSON.parse( e.target.response );
        console.log( response );
        if (response.ERR == 0) {
          var id = response.ID;
          var or = response.ORD;
          var im = response.IMG;

          holder.find( '.progress' ).remove();

          holder.find( 'input' ).attr( {
            'data-id': id,
            'value': or
          } ).show();

          holder.find( 'img' ).attr( {
            'src': im
          } ).show();

          holder.find( 'button' ).attr( {
            'data-id': id
          } ).show();

        } else {
          // Error
          progress.css( {
            'width': '100%'
          } ).removeClass( 'progress-bar-info progress-bar-success' ).addClass( 'progress-bar-danger' );
        }
      };

      xhr.onerror = function ( e ) {
        progress.css( {
          'width': '100%'
        } ).removeClass( 'progress-bar-info progress-bar-success' ).addClass( 'progress-bar-danger' );
      };

      xhr.upload.onprogress = function ( e ) {
        var percent = (e.loaded / size) * 100;
        progress.css( 'width', percent + '%' );
      };

      xhr.upload.onloadstart = function ( e ) {
        progress.css( {
          'width': '0%'
        } ).removeClass( 'progress-bar-danger progress-bar-success' ).addClass( 'progress-bar-info' );
      };

      xhr.send( file );
    };

    var buildDom = function ( file ) {
      var holder = $( '<div>' ).addClass( 'fileitem deletable' );

      var order = $( '<input>' ).attr( {
        'type': 'text',
        'name': 'imageorder',
        'value': '0',
        'data-id': '',
        'data-url': '/administration/showcase/json'
      } ).addClass( 'form-control line jsonupdate' );

      var img = $( '<img>' );
      img.attr( {
        'src': ''
      } );

      var button = $( '<button>' );
      button.attr( {
        'data-id': '',
        'data-url': '/administration/showcase/json'
      } ).addClass( 'deleter btn btn-danger btn-xs' );
      var i = $( '<i>' ).addClass( 'fa fa-times-circle' );
      button.append( i );

      var progress = $( '<div>' );
      progress.attr( {
        'style': 'margin-bottom:3px; height:5px;'
      } ).addClass( 'progress' );
      var progressBar = $( '<div>' );
      progressBar.attr( {
        'role': 'progressbar',
        'style': 'width:0px;'
      } ).addClass( 'progress-bar progress-bar-success' );
      progress.append( progressBar );

      order.hide();
      img.hide();
      button.hide();
      progress.show();

      holder.append( order, img, button, progress );
      uploads.append( holder );

      uploadFile( file, holder );
    };

    // Dragged over
    click.on( 'dragover', function ( e ) {
      e.preventDefault();
      parent.addClass( 'drop' );
    } );

    // Dragging left
    click.on( 'dragleave', function ( e ) {
      e.preventDefault();
      parent.removeClass( 'drop' );
    } );

    // Drop event
    click.on( 'drop', function ( e ) {
      e.preventDefault();
      e.stopPropagation();

      parent.removeClass( 'drop' );

      var files = event.dataTransfer.files;
      if (!files || !files.length) {
        return false;
      }

      for (var i = 0; i < files.length; i++) {
        buildDom( files[i] );
      }
      return false;
    } );

    // On click start drop event
    click.on( 'click', function () {
      parent.find( 'input[type="file"]' ).remove();
      var input = $( '<input>' ).attr( {
        'type': 'file',
        'name': 'file',
        'style': 'visibility:hidden; width:0; height:0',
        'multiple': 'multiple'
      } );

      input.on( 'change', function () {
        event = {
          dataTransfer: {}
        };
        event.dataTransfer.files = $( this ).get( 0 ).files;
        parent.append( input );
        click.trigger( 'drop' );
      } );
      input.trigger( 'click' );
    } );
  }

  $( '.multifileuploader' ).each( function () {
    new MultiFileUploader( $( this ) );
  } );

} );