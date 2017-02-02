<?php
	if(isset($_GET['id'])&&intval($_GET['id'])<1){
		header('Location: /error.php'); die();
	}
	$id=(int)$_GET['id'];
	if(!is_file(getcwd().'/../upload/'.$id.'.png')){
		header('Location: /error.php'); die();
	}
	$image='/upload/'.$id.'.png';

	// get image sizes
	// -----------------
	$size = getimagesize($_SERVER['DOCUMENT_ROOT'].$image);
	$sizeW = $size[0];
	$sizeH = $size[1];
	// -----------------
	unset($_GET['id']);
	unset($id);
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.1.1/css/mdb.min.css">
    <link href="/assets/vendor/literallycanvas-0.4.14/css/literallycanvas.css" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/main.css">
	<script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-with-addons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-dom.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js"></script>
    <script src="/assets/vendor/literallycanvas-0.4.14/js/literallycanvas.js"></script>
	<link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon" />
	<title>Visinly Screenshot Extension</title>
</head>

<body>
	<div class="container-fluid view">
		<main class="row view">
			<div class="col-sm-12 view">
				<div id="root">
<!--					<div class="logo">-->
<!--						<a href="http://visinly.com"><img src="/assets/img/logo.png" alt="Visinly"></a>-->
<!--					</div>-->
					<div class="spinner">
						<i class="fa fa-spinner rotating" aria-hidden="true"></i>
					</div>
				</div>
				<?
				echo '<script> var imgIn = "' . $image . '";</script>';
				echo '<script> var imgSizeW =' . $sizeW . ';</script>';
				echo '<script> var imgSizeH =' . $sizeH . ';</script>';
				?>

				<script>
					$(document).ready(function(){

						var thisW = $('#root').width();
						var thisH = $('#root').height();
						var backgroundShape;
						var lc;
						$('#root').width(imgSizeW + 61);

						if ( imgIn ) {
							var img = new Image();
							img.src = imgIn;

							LC.util.addImageOnload(img, function(){

							   lc = LC.init(document.getElementById('root'), {
								   imageURLPrefix: '/assets/vendor/literallycanvas-0.4.14/img',
								   imageSize: {width: thisW, height: thisH},
								   toolbarPosition: 'top',
								   backgroundShapes: [LC.createShape('Image', {x: 0, y: 0, image: img})]
							   });

							   $('#root .lc-picker-contents').append('<button id="saveImg" class="lc-pick-tool toolbar-button thin-button save-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>');
							   $('#root').prepend('<div class="logo"><a href="http://visinly.com"><img src="/assets/img/logo.png" alt="Visinly"></a></div>');

							   console.log(lc.backgroundShapes[0].image);
						   });
						}

						$('#root').on('click', '#saveImg',function(ev){
							ev.preventDefault();
							var snapshot = lc.getSnapshot();
							var newImg = LC.renderSnapshotToImage(snapshot, {
								rect: {
									x: 0,
									y: 0,
									width: imgSizeW,
									height: thisH
								}
							});
							console.log(newImg.toDataURL())
							window.open(newImg.toDataURL());
						});

						function saveImage(base64string) {
							console.log(base64string);
							var imageData = base64string.split(',')[1];
							var a = $("<a>").attr("href", "data:Application/base64," + imageData )
								.attr("download","image.png")
								.appendTo("body");

							a[0].click();

							a.remove();
						}

					});

					// when file is uploaded - show the image in div#root block
					// ----------------------------------------------------------
					// $(document).ready(function(){
					// 	$('#fileforsending2').on('change', function(e){
					// 		console.log(e);
					// 		if ( this.files && this.files[0] ) {
					// 			var FR= new FileReader();
					// 			FR.onload = function(e) {
					// 				var img = new Image();
					// 				img.src = FR.result;
					// 				console.log(img.src);

					// 				backgroundShape = LC.createShape(
					// 					'Image', {x: 0, y: 0, image: img});

					// 				$('#root').literallycanvas({
					// 					backgroundShapes: [backgroundShape],
					// 					imageURLPrefix: 'vendor/literallycanvas-0.4.14/img'
					// 				});
					// 			};
					// 			FR.readAsDataURL( this.files[0] );
					// 		}
					// 	});
					// });
				</script>
			</div>
		</main>
	</div>

	<!-- //<img src="<?=$image;?>"> -->

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.1.1/js/mdb.min.js"></script>
</body>
</html>