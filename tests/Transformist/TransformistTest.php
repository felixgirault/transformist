<?php

namespace Transformist;

use PHPUnit_Framework_TestCase as TestCase;
use org\bovigo\vfs\vfsStream;



/**
 *	Test case for Transformist.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class TransformistTest extends TestCase {

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

	public function setUp( ) {

		if ( !class_exists( '\\org\\bovigo\\vfs\\vfsStream' )) {
			$this->markTestSkipped( 'vfsStream must be enabled.' );
		}

		Runkit::requiredBy( $this );
		Runkit::redefineConstant( 'TRANSFORMIST_ROOT', TRANSFORMIST_TEST_RESOURCE );

		$this->vfs = vfsStream::setup( 'root' );
		$this->vfs->addChild( vfsStream::newFile( 'readable.txt' ));
		$this->vfs->addChild( vfsStream::newFile( 'unreadable.txt', 0000 ));
		$this->vfs->addChild( vfsStream::newDirectory( 'writable' ));
		$this->vfs->addChild( vfsStream::newDirectory( 'unwritable', 0000 ));

		$this->Transformist = new Transformist( );
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
				)
			),
			$this->Transformist->availableConversions( )
		);
	}



	/**
	 *
	 */

	public function testCanConvert( ) {

		$this->assertTrue( $this->Transformist->canConvert(
			new File( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new File( vfsStream::url( 'root/writable/converted.html' ), 'text/html' )
		));
	}



	/**
	 *
	 */

	public function testCantConvert( ) {

		$this->assertFalse( $this->Transformist->canConvert(
			new File( 'foo', 'text/plain' ),
			new File( 'bar', 'unknown' )
		));
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$this->assertTrue( $this->Transformist->convert(
			new File( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new File( vfsStream::url( 'root/writable/converted.html' ), 'text/html' )
		));
	}



	/**
	 *
	 */

	public function testConvertFromUnreadableFile( ) {

		$this->assertFalse( $this->Transformist->convert(
			new File( vfsStream::url( 'root/unreadable.txt' )),
			new File( vfsStream::url( 'root/writable/foo.bar' ))
		));
	}



	/**
	 *
	 */

	public function testConvertToUnwritableDir( ) {

		$this->assertFalse( $this->Transformist->convert(
			new File( vfsStream::url( 'root/readable.txt' )),
			new File( vfsStream::url( 'root/unwritable/converted' ))
		));
	}



	/**
	 *
	 */

	public function testSetup( ) {

		$this->Transformist->setup(
			vfsStream::url( 'root' ),
			array(
				'readable.txt' => 'text/html'
			)
		);

		$this->assertTrue( $this->Transformist->run( ));
	}



	/**
	 *
	 */

	public function tearDown( ) {

		Runkit::resetConstant( 'TRANSFORMIST_ROOT' );
	}
}
