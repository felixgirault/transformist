<?php

namespace Transformist;



/**
 *
 */

class Map {

	/**
	 *	Internal map.
	 *
	 *	@var array
	 */

	protected $_data = [ ];



	/**
	 *	Constructor.
	 *
	 *	@param array $map Map.
	 */

	public function __construct( $map = [ ]) {

		$this->_data = $map;
	}



	/**
	 *
	 *
	 *	@param string $key Key.
	 *	@return array Values.
	 */

	public function has( $key, $value ) {

		if ( !isset( $this->_data[ $key ])) {
			return false;
		}

		return in_array( $value, $this->_data[ $key ]);
	}



	/**
	 *	Returns the first value for the given key.
	 *
	 *	@param string $key Key.
	 *	@param mixed $default Default value.
	 *	@return mixed Value.
	 */

	public function get( $key, $default = null ) {

		$values = $this->getAll( $key );

		return empty( $values )
			? $default
			: reset( $values );	// returns the first value
	}



	/**
	 *	Returns values for the given key.
	 *
	 *	@param string $key Key.
	 *	@return array Values.
	 */

	public function getAll( $key ) {

		if ( isset( $this->_data[ $key ])) {
			return $this->_data[ $key ];
		}

		return [ ];
	}



	/**
	 *	Maps an key to a value.
	 *
	 *	@param string $key Key.
	 *	@param string $value Value.
	 */

	public function set( $key, $value ) {

		if ( !isset( $this->_data[ $key ])) {
			$this->_data[ $key ] = [ ];
		}

		if ( !in_array( $value, $this->_data[ $key ])) {
			$this->_data[ $key ][ ] = $value;
		}
	}



	/**
	 *	Adds entries by mapping each value with each other.
	 *
	 *	@param array $values Values.
	 */

	public function setMulti( array $values = [ ]) {

		foreach ( $values as $key ) {
			foreach ( $values as $value ) {
				if ( $key !== $value ) {
					$this->add( $key, $value );
				}
			}
		}
	}



	/**
	 *	Returns the internal map.
	 *
	 *	@return array Map.
	 */

	public function toArray( ) {

		return $this->_data;
	}



	/**
	 *	Merges the given map into the internal one.
	 *
	 *	@param Map $Map Map to merge.
	 */

	public function merge( Map $Map ) {

		$this->_data = array_merge_recursive( $this->_data, $Map->_data );
	}
}
