$( function () {

  var Animate = function ( dom ) {
    var parent = dom;

    var canvas = parent.getElementsByTagName( 'canvas' )[0];
    var fpsInput = parent.getElementsByTagName( 'input' )[0];

    var ctx = canvas.getContext( '2d' );

    var images = [];
    var imagesLength = 0;

    var playing = false;
    var frame = 0;

    var fps = parseInt( fpsInput.value );
    var now;
    var then = Date.now();
    var interval = 1000 / fps;
    var delta;

    canvas.width = canvas.clientWidth;
    canvas.height = canvas.clientHeight;
    var w = canvas.width;
    var h = canvas.height;

    var drawImageOnCanvas = function ( ctx, image, item ) {
      // image,
      // start clipping from x, start clipping from y
      // width of clipped image
      // height of clipped image
      // x coord of image on canvas
      // y coord of image on canvas
      // width to stretch
      // height to stretch
      ctx.drawImage( image, item.x, item.y, item.w, item.h, item.pX, item.pY, item.w, item.h );
    };

    function updateCurrentValues () {
      var fileItems = parent.getElementsByClassName( 'fileitem' );

      images = [];
      for (var i = 0; i < fileItems.length; i++) {
        var orderInput = parseInt( fileItems[i].getElementsByTagName( 'input' )[0].value );
        var image = fileItems[i].getElementsByTagName( 'img' )[0];
        images.push( {
          'order': orderInput,
          'image': image
        } );
      }
      imagesLength = images.length;

      images.sort( function ( a, b ) {
        var keyA = a.order;
        var keyB = b.order;

        if (keyA < keyB) return -1;
        if (keyA > keyB) return 1;
        return 0;
      } );

      fps = parseInt( fpsInput.value );
      then = Date.now();
      interval = 1000 / fps;

      canvas.width = canvas.clientWidth;
      canvas.height = canvas.clientHeight;
      w = canvas.width;
      h = canvas.height;
    }

    window.requestAnimFrame = (function () {
      return window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        window.oRequestAnimationFrame ||
        window.msRequestAnimationFrame ||
        function ( callback ) {
          window.setTimeout( callback, 1000 / 60 );
        };
    })();

    function render () {
      ctx.fillStyle = "#FFFFFF";
      ctx.clearRect( 0, 0, w, h );
      ctx.fillRect( 0, 0, w, h );

      if (frame >= imagesLength) frame = 0;
      var img = images[frame].image;
      frame++;

      var item = {
        x: 0,
        y: 0,
        w: img.width,
        h: img.height,
        pX: w / 2 - img.width / 2,
        pY: h / 2 - img.height / 2
      };
      drawImageOnCanvas( ctx, img, item );
    }

    function animLoop () {
      if (!playing) {
        render();
        return;
      }

      now = Date.now();
      delta = now - then;
      if (delta > interval) {
        render();
        then = now - (delta % interval);
      }

      requestAnimFrame( animLoop );
    }

    canvas.onclick = function () {
      updateCurrentValues();
      playing = !playing;

      if (imagesLength > 0) {
        now = Date.now();
        delta = now - then;
        render();
        animLoop();
      }
    };
  };

  $( '.animate' ).each( function () {
    var that = $( this ).parent().get( 0 );
    new Animate( that );
  } );

} );