<?php

namespace Transformist;

use Transformist\Map;
use Transformist\File;



/**
 *	The base class for a Converter.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Converter {

	/**
	 *	Maps mime types to extensions.
	 *
	 *	@var Map
	 */

	protected $_Extensions = null;



	/**
	 *	Maps input mime types to output ones.
	 *
	 *	@var Map
	 */

	protected $_Conversions = null;



	/**
	 *
	 */

	public function __construct( Map $Extensions ) {

		$this->_Extensions = $Extensions;
		$this->_Conversions = new Map( );
	}



	/**
	 *	Runs some tests to determine if the converter can run properly.
	 *	For example, checks if an external software is installed on the system.
	 *
	 *	@return boolean True if everything went good, otherwise false.
	 */

	public function test( ) {

		return true;
	}



	/**
	 *	Returns a map of handled conversions.
	 *
	 *	@return Map Map.
	 */

	public function conversions( ) {

		return $this->_Conversions;
	}



	/**
	 *	Tells if the converter can convert an input file to an output file.
	 *
	 *	@param File $Input Input file.
	 *	@param File $Output Output file.
	 *	@return boolean
	 */

	public function canConvert( File $Input, File $Output ) {

		return $this->_Conversions->has( $Input->type( ), $Output->type( ));
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param File $Input Input file.
	 *	@param File $Output Output file.
	 */

	abstract public function convert( File $Input, File $Output );

}
