<?php

namespace Transformist;

use PHPUnit_Framework_TestCase;
use org\bovigo\vfs\vfsStream;



/**
 *	Test case for File.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class FileTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $vfs = null;



	/**
	 *
	 */

	public $XmlFile = null;
	public $GifFile = null;



	/**
	 *
	 */

	public function setUp( ) {

		if ( !class_exists( '\\org\\bovigo\\vfs\\vfsStream' )) {
			$this->markTestSkipped( 'vfsStream must be enabled.' );
		}

		$this->vfs = vfsStream::setup( 'root' );

		$accessible = vfsStream::newDirectory( 'accessible' );
		$accessible->addChild(
			vfsStream::newFile( 'foo.xml' )
				->withContent( '<?xml version="1.0" encoding="UTF-8"?>' )
		);
		$accessible->addChild(
			vfsStream::newFile( 'empty' )
				->withContent( '' )
		);
		$this->vfs->addChild( $accessible );

		$restricted = vfsStream::newDirectory( 'restricted', 0000 );
		$accessible->addChild(
			vfsStream::newFile( 'bar.gif', 0000 )
				->withContent( 'GIF' )
		);
		$this->vfs->addChild( $restricted );

		$this->XmlFile = new File( vfsStream::url( 'root/accessible/foo.xml' ));
		$this->GifFile = new File( vfsStream::url( 'root/restricted/bar.gif' ));
	}



	/**
	 *
	 */

	public function testExists( ) {

		$this->assertTrue( $this->XmlFile->exists( ));
	}



	/**
	 *
	 */

	public function testBaseName( ) {

		$this->assertEquals( 'foo', $this->XmlFile->baseName( ));
	}



	/**
	 *
	 */

	public function testExtension( ) {

		$this->assertEquals( 'xml', $this->XmlFile->extension( ));
	}



	/**
	 *
	 */

	public function testSetExtension( ) {

		$File = new File( 'foo/bar/foo' );
		$File->setExtension( 'bar' );

		$this->assertEquals( 'bar', $File->extension( ));
	}



	/**
	 *
	 */

	public function testIsReadable( ) {

		$this->assertTrue( $this->XmlFile->isReadable( ));
	}



	/**
	 *
	 */

	public function testIsUnreadable( ) {

		$this->assertFalse( $this->GifFile->isReadable( ));
	}



	/**
	 *
	 */

	public function testIsWritable( ) {

		$this->assertTrue( $this->XmlFile->isWritable( ));
	}



	/**
	 *
	 */

	public function testIsUnwritable( ) {

		$this->assertFalse( $this->GifFile->isWritable( ));
	}



	/**
	 *
	 */

	public function testIsDirReadable( ) {

		$this->assertTrue( $this->XmlFile->isDirReadable( ));
	}



	/**
	 *
	 */

	public function testIsDirUnreadable( ) {

		$this->assertFalse( $this->GifFile->isDirReadable( ));
	}



	/**
	 *
	 */

	public function testIsDirWritable( ) {

		$this->assertTrue( $this->XmlFile->isDirWritable( ));
	}



	/**
	 *
	 */

	public function testIsDirUnwritable( ) {

		$this->assertFalse( $this->GifFile->isDirWritable( ));
	}



	/**
	 *
	 */

	public function testPath( ) {

		$this->assertEquals(
			vfsStream::url( 'root/accessible/foo.xml' ),
			$this->XmlFile->path( )
		);
	}



	/**
	 *
	 */

	public function testDirPath( ) {

		$this->assertEquals(
			dirname( vfsStream::url( 'root/accessible/foo.xml' )),
			$this->XmlFile->dirPath( )
		);
	}



	/**
	 *
	 */

	public function testType( ) {

		$this->assertEquals( 'application/xml', $this->XmlFile->type( ));
	}



	/**
	 *
	 */

	public function testForcedType( ) {

		$File = new File( '', 'application/pdf' );
		$this->assertEquals( 'application/pdf', $File->type( ));
	}



	/**
	 *
	 */

	public function testUndeterminableType( ) {

		$caught = false;

		try {
			$this->GifFile->type( );
		} catch ( Exception $e ) {
			$caught = true;
		}

		$this->assertTrue( $caught );
	}



	/**
	 *
	 */

	public function testTypeWithoutFile( ) {

		Runkit::requiredBy( $this );
		Runkit::reimplementFunction( 'class_exists', '$className', 'return false;' );

		$File = new File( vfsStream::url( 'root/accessible/empty' ));
		$caught = false;

		try {
			$File->type( );
		} catch ( Exception $e ) {
			$caught = true;
		}

		$this->assertTrue( $caught );

		Runkit::resetFunction( 'class_exists' );
	}
}
