<?php

namespace Transformist;

use PHPUnit_Framework_TestCase;



/**
 *	Test case for Registry.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class RegistryTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public function testUnregisteredExtension( ) {

		$this->assertEmpty( Registry::extension( 'mime/type' ));
	}



	/**
	 *
	 */

	public function testExtension( ) {

		Registry::register( 'ext', 'mime/type' );

		$this->assertEquals( 'ext', Registry::extension( 'mime/type' ));
	}



	/**
	 *
	 */

	public function testRegisterMulti( ) {

		Registry::register(
			array(
				'foo' => 'mime/foo',
				'bar' => 'mime/bar'
			)
		);

		$this->assertEquals( 'foo', Registry::extension( 'mime/foo' ));
		$this->assertEquals( 'bar', Registry::extension( 'mime/bar' ));
	}
}
