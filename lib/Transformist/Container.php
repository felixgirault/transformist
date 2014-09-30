<?php

namespace Transformist;

use Pimple\Container as PimpleContainer;
use Transformist\Map;
use Transformist\Converter\ImageMagick;
use Transformist\Converter\Office;



/**
 *	Standard container for Transformist.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Container extends PimpleContainer {

	/**
	 *	Constructor.
	 */

	public function __construct( ) {

		parent::__construct( );

		$this['extensionsFile'] = function( ) {
			return dirname( dirname( dirname( __FILE__ )))
				. DIRECTORY_SEPARATOR
				. 'config'
				. DIRECTORY_SEPARATOR
				. 'extensions.json';
		};

		$this['ExtensionsMap'] = function( $Container ) {
			return new Map( $Container['extensionsFile']);
		};

		$this['ImageMagick'] = function( $Container ) {
			return new ImageMagick( $Container['ExtensionsMap']);
		};

		$this['Office'] = function( $Container ) {
			return new Office( $Container['ExtensionsMap']);
		};

		$this['converters'] = function( $Container ) {
			return [
				'ImageMagick' => $Container['ImageMagick'],
				'Office' => $Container['Office']
			];
		};
	}
}
