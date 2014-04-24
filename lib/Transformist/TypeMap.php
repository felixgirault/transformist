<?php

namespace Transformist;



/**
 *
 */

class TypeMap {

	/**
	 *
	 */

	protected $_map = [ ];



	/**
	 *
	 */

	public function __construct( ) {

	}



	/**
	 *
	 *
	 *	@param string $type Input type.
	 *	@return array Output types.
	 */

	public function has( $input, $output ) {

		if ( !isset( $this->_map[ $input ])) {
			return false;
		}

		return in_array( $output, $this->_map[ $input ]);
	}



	/**
	 *	Maps an input type to an output type.
	 *
	 *	@param string $input Input type.
	 *	@param string $output Output type.
	 */

	public function map( $input, $output ) {

		if ( !isset( $this->_map[ $input ])) {
			$this->_map[ $input ] = [ ];
		}

		if ( !in_array( $output, $this->_map[ $input ])) {
			$this->_map[ $input ][ ] = $output;
		}
	}



	/**
	 *
	 *
	 *	@param array $types Types.
	 */

	public function mapMultiway( array $types = [ ]) {

		foreach ( $types as $type ) {
			foreach ( $types as $otherType ) {
				if ( $type !== $otherType ) {
					$this->add( $type, $otherType );
				}
			}
		}
	}



	/**
	 *
	 *
	 *	@param string $type Input type.
	 *	@return array Output types.
	 */

	public function outputTypes( $input ) {

		return $this->_map[ $input ];
	}
}
