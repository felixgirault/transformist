<?php

namespace Transformist;

use PHPUnit_Framework_TestCase;
use org\bovigo\vfs\vfsStream;



/**
 *	Test case for Transformist.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class TransformistTest extends PHPUnit_Framework_TestCase {

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

		$Document = new Document(
			new FileInfo( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new FileInfo( vfsStream::url( 'root/writable/converted.html' ), 'text/html' )
		);

		$this->assertTrue( $this->Transformist->canConvert( $Document ));
	}



	/**
	 *
	 */

	public function testCantConvert( ) {

		$Document = new Document(
			new FileInfo( 'foo', 'text/plain' ),
			new FileInfo( 'bar', 'unknown' )
		);

		$this->assertFalse( $this->Transformist->canConvert( $Document ));
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$Document = new Document(
			new FileInfo( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new FileInfo( vfsStream::url( 'root/writable/converted.html' ), 'text/html' )
		);

		$this->Transformist->addDocument( $Document );
		$this->assertTrue( $this->Transformist->run( ));
	}



	/**
	 *
	 */

	public function testConvertFromUnreadableFile( ) {

		$Document = new Document(
			new FileInfo( vfsStream::url( 'root/unreadable.txt' )),
			new FileInfo( vfsStream::url( 'root/writable/foo.bar' ))
		);

		$this->Transformist->addDocument( $Document );
		$this->assertFalse( $this->Transformist->run( ));
	}



	/**
	 *
	 */

	public function testConvertToUnwritableDir( ) {

		$Document = new Document(
			new FileInfo( vfsStream::url( 'root/readable.txt' )),
			new FileInfo( vfsStream::url( 'root/unwritable/converted' ))
		);

		$this->Transformist->addDocument( $Document );
		$this->assertFalse( $this->Transformist->run( ));
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
