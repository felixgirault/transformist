<?php

namespace Transformist;

use PHPUnit_Framework_TestCase as TestCase;
use Transformist\Command\Output;



/**
 *	Test case for Command.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class CommandTest extends TestCase {

	/**
	 *
	 */

	public function setUp( ) {

		Runkit::requiredBy( $this );
		Runkit::reimplementFunction(
			'exec',
			'$command, &$output, &$status',
			'$output = array( ); $status = 0;'
		);
	}



	/**
	 *
	 */

	public function testExecute( ) {

		$Command = new Command( 'ls' );

		$this->assertEquals(
			new Output( 'ls', array( ), 0 ),
			$Command->execute( )
		);
	}



	/**
	 *
	 */

	public function testExecuteWithFlags( ) {

		$Command = new Command( 'ls' );

		$this->assertEquals(
			new Output( 'ls -a -l', array( ), 0 ),
			$Command->execute( array( '-a', '-l' ))
		);
	}



	/**
	 *
	 */

	public function testExecuteWithOptions( ) {

		$Command = new Command( 'ls' );

		$this->assertEquals(
			new Output( 'ls --tabsize 5', array( ), 0 ),
			$Command->execute( array( '--tabsize' => 5 ))
		);
	}



	/**
	 *
	 */

	public function testExecuteWithCustomAssignment( ) {

		$Command = new Command( 'ls', '=' );

		$this->assertEquals(
			new Output( 'ls --tabsize=5', array( ), 0 ),
			$Command->execute( array( '--tabsize' => 5 ))
		);
	}



	/**
	 *
	 */

	public function tearDown( ) {

		Runkit::resetFunction( 'exec' );
	}
}
