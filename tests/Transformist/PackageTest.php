<?php

namespace Transformist;

use PHPUnit_Framework_TestCase;
use org\bovigo\vfs\vfsStream;



/**
 *	Test case for Package.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class PackageTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $vfs = null;



	/**
	 *
	 */

	public $Package = null;



	/**
	 *
	 */

	public function setUp( ) {

		if ( !class_exists( '\\org\\bovigo\\vfs\\vfsStream' )) {
			$this->markTestSkipped( 'vfsStream must be enabled.' );
		}

		$this->vfs = vfsStream::setup(
			'root',
			null,
			array(
				'Class.php' => '',
				'PackageFoo' => array(
					'ClassFoo.php' => '',
					'PackageBar' => array(
						'ClassBar.php' => ''
					)
				)
			)
		);

		$this->Package = new Package( vfsStream::url( 'root' ), '_' );
	}



	/**
	 *
	 */

	public function testPath( ) {

		$dir = dirname( __FILE__ );

		$Package = new Package( $dir );
		$this->assertEquals( $dir, $Package->path( ));
	}



	/**
	 *
	 */

	public function testFilePath( ) {

		$dir = dirname( __FILE__ );

		$Package = new Package( __FILE__ );
		$this->assertEquals( $dir, $Package->path( ));
	}



	/**
	 *
	 */

	public function testSeparator( ) {

		$Package = new Package( 'foo', '\\' );
		$this->assertEquals( '\\', $Package->separator( ));
	}



	/**
	 *
	 */

	public function testClasses( ) {

		$this->assertEquals(
			array(
				'Class'
			),
			$this->Package->classes( )
		);
	}



	/**
	 *
	 */

	public function testClassesRecursive( ) {

		$this->assertEquals(
			array(
				'Class',
				'PackageFoo_ClassFoo',
				'PackageFoo_PackageBar_ClassBar'
			),
			$this->Package->classes( array( ), true )
		);
	}



	/**
	 *
	 */

	public function testClassesSubPackage( ) {

		$this->assertEquals(
			array(
				'PackageFoo_ClassFoo'
			),
			$this->Package->classes( array( 'PackageFoo' ))
		);
	}



	/**
	 *
	 */

	public function testClassesSubPackageRecursive( ) {

		$this->assertEquals(
			array(
				'PackageFoo_ClassFoo',
				'PackageFoo_PackageBar_ClassBar'
			),
			$this->Package->classes( array( 'PackageFoo' ), true )
		);
	}
}
