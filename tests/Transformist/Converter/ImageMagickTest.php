<?php

namespace Transformist\Converter;

use PHPUnit_Framework_TestCase as TestCase;
use Transformist\Document;
use Transformist\File;

define(
	'IMAGEMAGICK_INPUT_FILE',
	TRANSFORMIST_TEST_RESOURCE . 'File' . DS . 'Input' . DS . 'sample.jpg'
);

define(
	'IMAGEMAGICK_OUTPUT_FILE',
	TRANSFORMIST_TEST_RESOURCE . 'File' . DS . 'Output' . DS . 'converted.png'
);



/**
 *	Test case for ImageMagick.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class ImageMagickTest extends TestCase {

	/**
	 *
	 */

	public $ImageMagick = null;



	/**
	 *
	 */

	public $Document = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->ImageMagick = new ImageMagick( );
		$runnable = $this->ImageMagick->isRunnable( );

		if ( $runnable !== true ) {
			$this->markTestSkipped( $runnable );
		}

		cleanDirectory( dirname( IMAGEMAGICK_OUTPUT_FILE ));
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$Input = new File( IMAGEMAGICK_INPUT_FILE );
		$Output = new File( IMAGEMAGICK_OUTPUT_FILE, 'image/png' );

		$this->assertFalse( $Output->exists( ));
		$this->ImageMagick->convert( $Input, $Output );
		$this->assertTrue( $Output->exists( ));
	}
}
