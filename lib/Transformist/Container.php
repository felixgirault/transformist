<?php

namespace Transformist;

use Pimple;
use Transformist\Converter\Container as ConverterContainer;



/**
 *	Standard container for Transformist.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Container extends Pimple {

	public function __construct( ) {

		parent::__construct( );

		$this['ConverterContainer'] = function( ) {
			return new ConverterContainer( );
		};
	}
}
