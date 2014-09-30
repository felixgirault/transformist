<?php

namespace Transformist;

use PHPUnit_Framework_TestCase as TestCase;



/**
 *	Test case for Registry.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class RegistryTest extends TestCase {

	/**
	 *
	 */

	public $Map = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->Map = new Map( );
	}



	/**
	 *
	 */

	public function testHas( ) {

		$this->Map->set( 'key', 'value' );

		$this->assertFalse( $this->Map->has( 'null', 'null' ));
		$this->assertTrue( $this->Map->has( 'key', 'value' ));
	}



	/**
	 *
	 */

	public function testGet( ) {

		$this->Map->set( 'key', 'value' );
		$this->Map->set( 'key', 'valueBis' );

		$this->assertEquals([ 'value' ], $this->Map->getAll( 'key' ));
	}



	/**
	 *
	 */

	public function testGetAll( ) {

		$this->Map->set( 'key', 'value' );

		$this->assertEquals([ 'value' ], $this->Map->getAll( 'key' ));
	}



	/**
	 *
	 */

	public function testSet( ) {

		$this->Map->set( 'key', 'value' );
		$this->Map->set( 'key', 'valueBis' );

		$this->assertTrue( $this->Map->has( 'key', 'value' ));
		$this->assertTrue( $this->Map->has( 'key', 'valueBis' ));
	}



	/**
	 *
	 */

	public function testSetMulti( ) {

		$this->Map->setMulti([ 'one', 'two' ]);

		$this->assertTrue( $this->Map->has( 'one', 'two' ));
		$this->assertTrue( $this->Map->has( 'two', 'one' ));
	}



	/**
	 *
	 */

	public function testToArray( ) {

		$this->Map->set( 'one', 'two' );

		$this->assertEquals([ 'one' => [ 'two' ]], $this->Map->toArray( ));
	}



	/**
	 *
	 */

	public function testMerge( ) {

		$Map = new Map( );
		$Map->set( 'key', 'value' );

		$this->Map->set( 'key', 'valueBis' );
		$this->Map->merge( $Map );

		$this->assertTrue( $this->Map->has( 'key', 'value' ));
		$this->assertTrue( $this->Map->has( 'key', 'valueBis' ));
	}
}
