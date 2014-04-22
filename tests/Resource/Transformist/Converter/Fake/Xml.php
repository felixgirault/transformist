<?php

namespace Transformist\Converter\Fake;

use Transformist\Converter\Fake;



/**
 *	@author Félix Girault <felix@vtech.fr>
 */

class Xml extends Fake {

	/**
	 *
	 */

	public static function conversions( ) {

		return array( 'text/html' => 'application/xml' );
	}
}
