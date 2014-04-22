<?php

namespace Transformist;

use PHPUnit_Framework_TestCase;
use org\bovigo\vfs\vfsStream;



/**
 *	Test case for Document.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class DocumentTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $vfs = null;



	/**
	 *
	 */

	public $Document = null;



	/**
	 *
	 */

	public $Input = null;



	/**
	 *
	 */

	public $Output = null;



	/**
	 *
	 */

	public function setUp( ) {

		if ( !class_exists( '\\org\\bovigo\\vfs\\vfsStream' )) {
			$this->markTestSkipped( 'vfsStream must be enabled.' );
		}

		$this->vfs = vfsStream::setup( 'root', null, array( 'input.txt' ));

		$this->Input = new FileInfo( vfsStream::url( 'root/input.txt' ));
		$this->Output = new FileInfo( vfsStream::url( 'root/output.doc' ));
		$this->Document = new Document( $this->Input, $this->Output );
	}



	/**
	 *
	 */

	public function testInput( ) {

		$this->assertEquals( $this->Input, $this->Document->input( ));
	}



	/**
	 *
	 */

	public function testOutput( ) {

		$this->assertEquals( $this->Output, $this->Document->output( ));
	}



	/**
	 *
	 */

	public function testIsConverted( ) {

		$this->vfs->addChild( vfsStream::newFile( 'output.doc' ));
		$this->assertTrue( $this->Document->isConverted( ));
	}



	/**
	 *
	 */

	public function testIsntConverted( ) {

		$this->assertFalse( $this->Document->isConverted( ));
	}
}
