<?php

/**
 *	Test case for ConverterCollection.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterCollectionTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $ConverterCollection = null;



	/**
	 *
	 */

	public function setUp( ) {

		Runkit::requiredBy( $this );
		Runkit::redefineConstant( 'TRANSFORMIST_ROOT', TRANSFORMIST_TEST_RESOURCE );

		$this->ConverterCollection = new Transformist_ConverterCollection( );
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
			$this->ConverterCollection->names( )
		);
	}



	/**
	 *
	 */

	public function testGet( ) {

		$Converter = $this->ConverterCollection->get( 'Transformist_Converter_Fake_Html' );

		$this->assertTrue( $Converter instanceof Transformist_Converter_Fake_Html );
	}



	/**
	 *
	 */

	public function testGetUnknown( ) {

		$this->assertNull( $this->ConverterCollection->get( 'Unknown' ));
	}



	/**
	 *
	 */

	public function tearDown( ) {

		Runkit::resetConstant( 'TRANSFORMIST_ROOT' );
	}
}
