<?php

namespace Transformist;

use PHPUnit_Framework_TestCase;



/**
 *	Test case for ClassLoader.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class ClassLoaderTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $ClassLoader = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->ClassLoader = new ClassLoader( TRANSFORMIST_TEST_RESOURCE );
		$this->ClassLoader->register( );
	}



	/**
	 *
	 */

	public function testRegister( ) {

		$this->assertTrue(
			in_array(
				array( $this->ClassLoader, 'load' ),
				spl_autoload_functions( )
			)
		);
	}



	/**
	 *
	 */

	public function testLoad( ) {

		$this->assertTrue( class_exists( 'Transformist\\Converter\\Fake\\Html' ));
	}



	/**
	 *
	 */

	public function testLoadUndefined( ) {

		$this->assertFalse( class_exists( 'Transformist\\Converter\\Undefined' ));
	}
}
