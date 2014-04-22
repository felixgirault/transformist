<?php

namespace Transformist\Converter;

use PHPUnit_Framework_TestCase;



/**
 *	Test case for Collection.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class CollectionTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $Collection = null;



	/**
	 *
	 */

	public function setUp( ) {

		Runkit::requiredBy( $this );
		Runkit::redefineConstant( 'TRANSFORMIST_ROOT', TRANSFORMIST_TEST_RESOURCE );

		$this->Collection = new Collection( );
	}



	/**
	 *
	 */

	public function testNames( ) {

		$this->assertEquals(
			array(
				'Transformist_Converter_Fake_Html',
				'Transformist_Converter_Fake_Json',
				'Transformist_Converter_Fake_Xml'
			),
			$this->Collection->names( )
		);
	}



	/**
	 *
	 */

	public function testGet( ) {

		$Converter = $this->Collection->get( 'Transformist_Converter_Fake_Html' );

		$this->assertTrue( $Converter instanceof Transformist\Converter\Fake\Html );
	}



	/**
	 *
	 */

	public function testGetUnknown( ) {

		$this->assertNull( $this->Collection->get( 'Unknown' ));
	}



	/**
	 *
	 */

	public function tearDown( ) {

		Runkit::resetConstant( 'TRANSFORMIST_ROOT' );
	}
}
