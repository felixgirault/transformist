<?php

namespace Transformist;

use PHPUnit_Framework_TestCase as TestCase;



/**
 *	Test case for Converter.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class ConverterTest extends TestCase {

	/**
	 *
	 */

	public $Converter = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->Converter = new ConverterImplementation( );
	}



	/**
	 *
	 */

	public function testCanConvert( ) {


	}
}



/**
 *
 */

class ConverterImplementation extends Converter {

	/**
	 *
	 */

	public function convert( File $Input, File $Output ) { }

}
