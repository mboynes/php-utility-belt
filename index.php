<?php

if ( !defined( 'PATH' ) )
	define( 'PATH', '' );

if ( !defined( 'DIR' ) )
	define( 'DIR', dirname( __FILE__ ) . '/' );


require_once DIR . 'lib/belt.php';

get_header();

require_once DIR . 'pages/home.php';

get_footer();

