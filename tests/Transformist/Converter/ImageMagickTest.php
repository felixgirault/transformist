<?php

namespace Transformist\Converter;

use PHPUnit_Framework_TestCase;
use Transformist\Document;
use Transformist\FileInfo;

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

class ImageMagickTest extends PHPUnit_Framework_TestCase {

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

		$runnable = ImageMagick::isRunnable( );

		if ( $runnable !== true ) {
			$this->markTestSkipped( $runnable );
		}

		cleanDirectory( dirname( IMAGEMAGICK_OUTPUT_FILE ));

		$this->ImageMagick = new ImageMagick( );
		$this->Document = new Document(
			new FileInfo( IMAGEMAGICK_INPUT_FILE ),
			new FileInfo( IMAGEMAGICK_OUTPUT_FILE, 'image/png' )
		);
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$this->ImageMagick->convert( $this->Document );
		$this->assertTrue( $this->Document->isConverted( ));
	}
}
