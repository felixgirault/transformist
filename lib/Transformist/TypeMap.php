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
	 */

	public function add( $from, $to ) {

		if ( !isset( $this->_map[ $from ])) {
			$this->_map[ $from ] = [ ];
		}

		if ( !in_array( $to, $this->_map[ $from ])) {
			$this->_map[ $from ][ ] = $to;
		}
	}



	/**
	 *
	 *
	 *	@param array $types Types.
	 */

	public function addNetwork( array $types = [ ]) {

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

	public function convertsTo( $type ) {

		return $this->_map[ $type ];
	}
}
