<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

use org\bovigo\vfs\vfsStream;



/**
 *	Test case for Transformist.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_TransformistTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $vfs = null;



	/**
	 *
	 */

	public $Transformist = null;



	/**
	 *
	 */

	public $MultistepTransformist = null;



	/**
	 *
	 */

	public function setUp( ) {

		if ( !class_exists( '\\org\\bovigo\\vfs\\vfsStream' )) {
			$this->markTestSkipped( 'vfsStream must be enabled.' );
		}

		if ( !Runkit::isEnabled( )) {
			$this->markTestSkipped( 'Runkit must be enabled.' );
		}

		Runkit::redefineConstant( 'TRANSFORMIST_ROOT', TRANSFORMIST_TEST_RESOURCE );

		$this->vfs = vfsStream::setup( 'root' );
		$this->vfs->addChild( vfsStream::newFile( 'readable.txt' ));
		$this->vfs->addChild( vfsStream::newFile( 'unreadable.txt', 0000 ));
		$this->vfs->addChild( vfsStream::newDirectory( 'writable' ));
		$this->vfs->addChild( vfsStream::newDirectory( 'unwritable', 0000 ));

		$this->Transformist = new Transformist( );
		$this->MultistepTransformist = new Transformist( array( 'multistep' => true ));
	}



	/**
	 *
	 */

	public function testAvailableConversions( ) {

		$this->assertEquals(
			array(
				'text/plain' => array(
					'text/html'
				),
				'application/xml' => array(
					'application/json'
				),
				'text/html' => array(
					'application/xml'
				),
				'image/svg+xml' => array(
					'application/xml'
				)
			),
			$this->Transformist->availableConversions( )
		);
	}



	/**
	 *
	 */

	public function testAvailableMultistepConversions( ) {

		$this->assertEquals(
			array(
				'text/plain' => array(
					'text/html',
					'application/xml',
					'application/json'
				),
				'application/xml' => array(
					'application/json'
				),
				'text/html' => array(
					'application/xml',
					'application/json'
				),
				'image/svg+xml' => array(
					'application/xml',
					'application/json'
				)
			),
			$this->MultistepTransformist->availableConversions( )
		);
	}



	/**
	 *
	 */

	public function testCanConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new Transformist_FileInfo( vfsStream::url( 'root/writable/converted.html' ), 'text/html' )
		);

		$this->assertTrue( $this->Transformist->canConvert( $Document ));
	}



	/**
	 *
	 */

	public function testCanConvertMultistep( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new Transformist_FileInfo( vfsStream::url( 'root/writable/converted.json' ), 'application/json' )
		);

		$this->assertEquals( 3, $this->MultistepTransformist->canConvert( $Document ));
	}



	/**
	 *
	 */

	public function testCantConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'foo', 'text/plain' ),
			new Transformist_FileInfo( 'bar', 'unknown' )
		);

		$this->assertFalse( $this->Transformist->canConvert( $Document ));
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new Transformist_FileInfo( vfsStream::url( 'root/writable/converted.html' ), 'text/html' )
		);

		$this->Transformist->addDocument( $Document );

		$this->assertTrue( $this->Transformist->convert( ));
	}



	/**
	 *
	 */

	public function testConvertMultistep( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new Transformist_FileInfo( vfsStream::url( 'root/writable/converted.json' ), 'application/json' )
		);

		$this->MultistepTransformist->addDocument( $Document );

		$this->assertTrue( $this->MultistepTransformist->convert( ));
	}



	/**
	 *
	 */

	public function testConvertFromUnreadableFile( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/unreadable.txt' )),
			new Transformist_FileInfo( vfsStream::url( 'root/writable/foo.bar' ))
		);

		$this->Transformist->addDocument( $Document );

		$this->assertFalse( $this->Transformist->convert( ));
	}



	/**
	 *
	 */

	public function testConvertToUnwritableDir( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/readable.txt' )),
			new Transformist_FileInfo( vfsStream::url( 'root/unwritable/converted' ))
		);

		$this->Transformist->addDocument( $Document );

		$this->assertFalse( $this->Transformist->convert( ));
	}



	/**
	 *
	 */

	public function testConvertFluent( ) {

		$converted = $this->Transformist
			->from( vfsStream::url( 'root/readable.txt' ), 'text/plain' )
			->to( vfsStream::url( 'root/writable/converted.html' ), 'text/html' )
			->convert( );

		$this->assertTrue( $converted );
	}



	/**
	 *
	 */

	public function tearDown( ) {

		Runkit::resetConstant( 'TRANSFORMIST_ROOT' );
	}
}
