<?php

define( 'CONVERTER_INPUT_TYPE', 'application/xml' );
define( 'CONVERTER_OUTPUT_TYPE', 'application/pdf' );



/**
 *	Test case for Converter.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $Converter = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->Converter = new Transformist_ConcreteConverter( );
	}



	/**
	 *
	 */

	public function testInputTypes( ) {

		$this->assertEquals( array( CONVERTER_INPUT_TYPE ), $this->Converter->inputTypes( ));
	}



	/**
	 *
	 */

	public function testOutputType( ) {

		$this->assertEquals( CONVERTER_OUTPUT_TYPE, $this->Converter->outputType( ));
	}
}



/**
 *
 */

class Transformist_ConcreteConverter extends Transformist_Converter {

	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return array Types.
	 */

	public static function inputTypes( ) {

		return array( CONVERTER_INPUT_TYPE );
	}



	/**
	 *	Returns the type of files that the converter produces.
	 *
	 *	@return string Type.
	 */

	public static function outputType( ) {

		return CONVERTER_OUTPUT_TYPE;
	}



	/**
	 *
	 */

	public function convert( Transformist_Document $Document ) { }

}
