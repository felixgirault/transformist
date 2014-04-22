<?php

namespace Transformist;

use PHPUnit_Framework_TestCase;



/**
 *	Test case for Command.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class CommandTest extends PHPUnit_Framework_TestCase {

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
			new CommandResult( 'ls', array( ), 0 ),
			$Command->execute( )
		);
	}



	/**
	 *
	 */

	public function testExecuteWithFlags( ) {

		$Command = new Command( 'ls' );

		$this->assertEquals(
			new CommandResult( 'ls -a -l', array( ), 0 ),
			$Command->execute( array( '-a', '-l' ))
		);
	}



	/**
	 *
	 */

	public function testExecuteWithOptions( ) {

		$Command = new Command( 'ls' );

		$this->assertEquals(
			new CommandResult( 'ls --tabsize 5', array( ), 0 ),
			$Command->execute( array( '--tabsize' => 5 ))
		);
	}



	/**
	 *
	 */

	public function testExecuteWithCustomAssignment( ) {

		$Command = new Command( 'ls', '=' );

		$this->assertEquals(
			new CommandResult( 'ls --tabsize=5', array( ), 0 ),
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
