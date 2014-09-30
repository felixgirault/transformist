<?php

/**
 *	Core constants
 */

if ( !defined( 'DS')) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

if ( !defined( 'TRANSFORMIST_ROOT')) {
	define( 'TRANSFORMIST_ROOT', dirname( __FILE__ ) . DS );
}

if ( !defined( 'TRANSFORMIST_TEST_ROOT' )) {
	define( 'TRANSFORMIST_TEST_ROOT', dirname( __FILE__ ) . DS );
}

if ( !defined( 'TRANSFORMIST_TEST_RESOURCE' )) {
	define( 'TRANSFORMIST_TEST_RESOURCE', TRANSFORMIST_TEST_ROOT . 'Resource' . DS );
}



/**
 *	Autoload
 */

require_once dirname( dirname( __FILE__ )) . DS . 'vendor' . DS . 'autoload.php';



/**
 *	Utility
 */

function cleanDirectory( $path ) {

	if ( is_dir( $path )) {
		foreach( glob( $path . DS . '*' ) as $entry ) {
			unlink( $entry );
		}
	} else {
		mkdir( $path );
	}
}
