<?php

namespace Transformist;

use Transformist\Container;
use Transformist\Exception;
use Transformist\File;



/**
 *	A high level API to handle file conversions.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist {

	/**
	 *	A collection of converters.
	 *
	 *	@var ConverterCollection
	 */

	protected $_converters = null;



	/**
	 *	Constructs Transformist, given an array of configuration options.
	 *	These options will be merged with Transformist::$_defaults.
	 *
	 *	@see Transformist::configure( )
	 *	@param array $options Configuration options.
	 */

	public function __construct( Container $Container = null ) {

		if ( $Container === null ) {
			$Container = new Container( );
		}

		$this->_converters = $Container['converters'];
	}



	/**
	 *	Runs a test on every converter and returns the results of these tests.
	 *
	 *	@return array Test results, boolean values indexed by converters name.
	 */

	public function testConverters( ) {

		return array_map( function( $Converter ) {
			try {
				return $Converter->test( );
			} catch ( $Exception ) {
				return $Exception->getMessage( );
			}
		}, $this->_converters );
	}



	/**
	 *	Returns an array of all available conversions.
	 *
	 *	@param Map Available conversions.
	 */

	public function availableConversions( ) {

		$Conversions = new Map( );

		foreach ( $this->_converters as $Converter ) {
			$Conversions->merge( $Converter->conversions( ));
		}

		return $Conversions;
	}



	/**
	 *	Checks if there is a way to convert the given document.
	 *
	 *	@param Document $Document Document to convert.
	 *	@return boolean|integer True if the document can be converter, otherwise
	 *		false. If deep conversions are enabled, the method will return
	 *		the number of conversions that will be done to achieve the full
	 *		conversion.
	 */

	public function canConvert( File $Input, File $Output ) {

		return ( $this->_converterFor( $Input, $Output ) !== null );
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param File $Input Input file.
	 *	@param File $Output Output file.
	 *	@return boolean Conversion status.
	 */

	public function convert( File $Input, File $Output ) {

		if ( !$Input( )->isReadable( )) {
			throw new Exception(
				'The file ' . $Input( )->path( ) . ' is not readable.'
			);
		}

		if ( !$Output( )->isDirWritable( )) {
			throw new Exception(
				'The directory ' . $Output( )->dirPath( ) . ' is not writable.'
			);
		}

		$Converter = $this->_converterFor( $Document );

		return $Converter
			? $Converter->convert( $Document )
			: false;
	}



	/**
	 *	Finds and returns a converter which can convert the given document.
	 *
	 *	@param Document $Document Document to convert.
	 *	@return Converter|null A suitable converter, or null if none were found.
	 */

	protected function _converterFor( File $Input, File $Output ) {

		foreach ( $this->_converter as $Converter ) {
			if ( $Converter->canConvert( $Input, $Output )) {
				return $Converter;
			}
		}

		return null;
	}
}
