<?php

namespace Transformist;

use Exception as NativeException;



/**
 *	The base Exception class for Transformist.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Exception extends NativeException {

	/**
	 *	Constructs an Exception.
	 *	This method behaves like sprintf, so it accepts a string as first
	 *	parameter, and a list of arguments to be inserted in the string.
	 *
	 *	@param string $message Exception message.
	 *	@param mixed $arguments Multiple arguments.
	 */

	public function __construct( $message, $arguments = null ) {

		if ( func_num_args( ) > 1 ) {
			$message = vsprintf( $message, array_slice( func_get_args( ), 1 ));
		}

		parent::__construct( $message );
	}
}
