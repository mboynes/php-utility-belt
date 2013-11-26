<?php

/**
 * Templates
 *
 * @author Matthew Boynes
 */

function get_header( $title = 'PHP Utility Belt' ) {
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php echo $title ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/css/bootstrap-combined.min.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<style type="text/css" media="screen">
		body { padding-top: 60px; }
		@media (max-width:979px) { body { padding-top: 0; } }
		code { color: black; }
	</style>
	<script type="text/javascript">var PATH = '<?php echo PATH ?>';</script>
</head>
<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="#">Utility Belt</a>
				<div class="nav-collapse">
					<ul class="nav">
						<li class="active"><a href="#home">Home</a></li>
						<li><a href="#passwords">Passwords</a></li>
						<li><a href="#regex">Regular Expressions</a></li>
						<li><a href="#time">Date &amp; Time</a></li>
						<li><a href="#printf">Printf</a></li>
						<li><a href="#serialization">Serialization</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div id="wrapper" class="container">
		<div id="view_wrapper" class="row">

<?php
}


function get_footer() {
	?>

		</div>
	</div>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo PATH ?>assets/application.js"></script>
</body>
</html>
<?php
}

?>