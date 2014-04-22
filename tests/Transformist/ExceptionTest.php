<?php

namespace Transformist;

use PHPUnit_Framework_TestCase;



/**
 *	Test case for Exception.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class ExceptionTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public function testConstruct( ) {

		$message = 'Hello world!';

		$Exception = new Exception( $message );
		$this->assertEquals( $message, $Exception->getMessage( ));
	}



	/**
	 *
	 */

	public function testConstructFormatted( ) {

		$format = 'Hello %s!';
		$argument = 'world';
		$message = sprintf( $format, $argument );

		$Exception = new Exception( $format, $argument );
		$this->assertEquals( $message, $Exception->getMessage( ));
	}
}
