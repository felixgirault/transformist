<?php

namespace Transformist\Converter;

use PHPUnit_Framework_TestCase as TestCase;

define(
	'OFFICE_INPUT_FILE',
	TRANSFORMIST_TEST_RESOURCE . 'File' . DS . 'Input' . DS . 'sample.doc'
);

define(
	'OFFICE_OUTPUT_FILE',
	TRANSFORMIST_TEST_RESOURCE . 'File' . DS . 'Output' . DS . 'converted.pdf'
);



/**
 *	Test case for Office.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class OfficeTest extends TestCase {

	/**
	 *
	 */

	public $Office = null;



	/**
	 *
	 */

	public $Document = null;



	/**
	 *
	 */

	public function setUp( ) {

		$runnable = Office::isRunnable( );

		if ( $runnable !== true ) {
			$this->markTestSkipped( $runnable );
		}

		cleanDirectory( dirname( OFFICE_OUTPUT_FILE ));

		$this->Office = new Office( );
		$this->Document = new Document(
			new File( OFFICE_INPUT_FILE ),
			new File( OFFICE_OUTPUT_FILE, 'application/pdf' )
		);
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$this->Office->convert( $this->Document );
		$this->assertTrue( $this->Document->isConverted( ));
	}
}
