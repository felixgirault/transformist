<?php

namespace Transformist;

use Transformist\Command\Output;



/**
 *	A simplistic interface to execute commands.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Command {

	/**
	 *	Command name.
	 *
	 *	@var string
	 */

	protected $_name = '';



	/**
	 *	Assignment operator.
	 *
	 *	@var string
	 */

	protected $_assignment = '';



	/**
	 *	Constructs a command with the given name.
	 *
	 *	@param string $name Command name.
	 *	@param string $assignment An assignment character that will be used to
	 *		associate long options and their values. It is generally a space
	 *		or an equals sign.
	 */

	public function __construct( $name, $assignment = ' ' ) {

		$this->_name = $name;
		$this->_assignment = $assignment;
	}



	/**
	 *	Returns if the command is available on the system, relying on the
	 *	'command' utility, which should be installed on most systems.
	 *
	 *	@return boolean True if it is available, otherwise false.
	 */

	public function exists( ) {

		$Command = new Command( 'command' );
		$Output = $Command->execute([ '-v' => $this->_name ]);

		return $Output->isSuccess( );
	}



	/**
	 *	Executes the command with the given options.
	 *
	 *	@param array $options Command options.
	 *	@return Output Informations about the executed command.
	 */

	public function execute( array $options = array( )) {

		$command = $this->_name;
		$command .= $this->_inline( $options );

		@exec( $command . ' 2>&1', $output, $status );

		return new Output( $command, $output, $status );
	}



	/**
	 *
	 *
	 *	@param array $options Command options.
	 *	@return string Arguments.
	 */

	protected function _inline( array $options ) {

		$command = '';

		foreach ( $options as $key => $value ) {
			$command .= ' ';

			if ( is_string( $key )) {
				$command .= $key . $this->_assignment;
			}

			$command .= $value;
		}

		return $command;
	}
}
