<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for Command.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_CommandTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $commands = array(

		// simple command
		array(
			'name' => 'ls',
			'options' => array( ),
			'assignment' => ' ',
			'expected' => 'ls'
		),

		// command with short options
		array(
			'name' => 'ls',
			'options' => array( '-a', '-b' ),
			'assignment' => ' ',
			'expected' => 'ls -a -b'
		),

		// command with long options
		array(
			'name' => 'ls',
			'options' => array(
				'--color' => 'never',
				'--width' => '80'
			),
			'assignment' => ' ',
			'expected' => 'ls --color \'never\' --width \'80\''
		),

		// command with mixed options and a custom assignment character
		array(
			'name' => 'ls',
			'options' => array(
				'-a',
				'--width' => '80'
			),
			'assignment' => '=',
			'expected' => 'ls -a --width=\'80\''
		)
	);



	/**
	 *
	 */

	public function testExecute( ) {

		foreach ( $this->commands as $command ) {
			extract( $command );

			Transformist_Command::execute( $name, $options, $assignment );
			$this->assertEquals( $expected, Transformist_Command::last( ));
		}
	}



	/**
	 *
	 */

	public function testExecuted( ) {

		$expected = array( );

		foreach ( $this->commands as $command ) {
			$expected[] = $command['expected'];
		}

		$this->assertEquals( $expected, Transformist_Command::executed( ));
	}



	/**
	 *
	 */

	public function testLast( ) {

		$last = count( $this->commands ) - 1;
		$expected = $this->commands[ $last ]['expected'];

		$this->assertEquals( $expected, Transformist_Command::last( ));
	}
}
