<!DOCTYPE html>
<head>
	<meta charset='UTF-8' />
	<link rel='stylesheet' type='text/css' href='/banner/css/style.css' />

	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<script src="/banner/js/swipe.js"></script>

</head>

<body>

<div id="page-wrap">

	<section class="image-gallery group">

		<div id="mySwipe" class="left swipe slider">
			<div class="swipe-wrap">
				<div>
					<figure tabindex="1">
						<img class="i1" src="/banner/images/300x250/300x250-1.png" alt="" />
						<img class="i2" src="/banner/images/600x400/600x400-1.png" alt="" />
					</figure>
				</div>

				<div>
				<figure tabindex="2">
					<img class="i1" src="/banner/images/300x250/300x250-2.png" alt="" />
					<img class="i2" src="/banner/images/600x400/600x400-2.png" alt="" />
				</figure>
				</div>
				<div>

				<figure tabindex="3">
					<img class="i1" src="/banner/images/300x250/300x250-3.png" alt="" />
					<img class="i2" src="/banner/images/600x400/600x400-3.png" alt="" />
				</figure>
				</div>
				<div>

				<figure tabindex="4">
					<img class="i1" src="/banner/images/300x250/300x250-4.png" alt="" />
					<img class="i2" src="/banner/images/600x400/600x400-4.png" alt="" />
				</figure>
				</div>

				<div>
				<figure tabindex="5">
					<img class="i1" src="/banner/images/300x250/300x250-5.png" alt="" />
					<img class="i2" src="/banner/images/600x400/600x400-5.png" alt="" />
				</figure>
				</div>

				<div>
				<figure tabindex="6">
					<img class="i1" src="/banner/images/300x250/300x250-6.png" alt="" />
					<img class="i2" src="/banner/images/600x400/600x400-6.png" alt="" />
				</figure>
				</div>

				<div>
				<figure tabindex="7">
					<img class="i1" src="/banner/images/300x250/300x250-7.png" alt="" />
					<img class="i2" src="/banner/images/600x400/600x400-7.png" alt="" />
				</figure>
				</div>

				<div>
				<figure tabindex="8">
					<img class="i1" src="/banner/images/300x250/300x250-8.png" alt="" />
					<img class="i2" src="/banner/images/600x400/600x400-8.png" alt="" />
				</figure>
				</div>
				<div>
			</div>
		</div>
	</section>

</div>

<script>
	// pure JS
	var elem = document.getElementById('mySwipe');
	window.mySwipe = Swipe(elem, {
		startSlide: 0,
		auto: 1800,
		continuous: true
		// disableScroll: true,
		// stopPropagation: true,
		// callback: function(index, element) {},
		// transitionEnd: function(index, element) {}
	});

	// with jQuery
	// window.mySwipe = $('#mySwipe').Swipe().data('Swipe');

</script>

</body>

</html>