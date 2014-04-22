<?php

namespace Transformist\Converter\Fake;

use Transformist\Converter\Fake;



/**
 *	@author Félix Girault <felix@vtech.fr>
 */

class Json extends Fake {

	/**
	 *
	 */

	public static function conversions( ) {

		return array( 'application/xml' => 'application/json' );
	}
}
