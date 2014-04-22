<?php

namespace Transformist\Converter;

use ReflectionClass;
use Transformist\Converter\Container;



/**
 *	A collection of converters.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Collection {

	/**
	 *	A container for Converters.
	 *
	 *	@var array
	 */

	protected $_Container = array( );



	/**
	 *	A list of loaded converters.
	 *
	 *	@var array
	 */

	protected $_converters = array( );



	/**
	 *	Constructs the collection.
	 *
	 *	@see ConverterCollection::configure( )
	 *	@param array $options Configuration options.
	 */

	public function __construct( Container $Container ) {

		$this->_Container = $Container;
	}



	/**
	 *	Returns the name of all converters.
	 *
	 *	@return array Names.
	 */

	public function names( ) {

		return array_keys( $this->_converters );
	}



	/**
	 *	If necessary, loads the corresponding Converter and returns it.
	 *
	 *	@param string $name A Converter name, as returned by converterNames( ).
	 *	@return Converter|null An instance of the requested
	 *		converter, or null if it can't be found.
	 */

	public function get( $name ) {

		if ( !array_key_exists( $name, $this->_converters )) {

		}

		$Converter = $this->_converters[ $name ];

		if ( $Converter === null ) {
			$Converter = new $name( );
			$this->_converters[ $name ] = $Converter;
		}

		return $Converter;
	}
}
