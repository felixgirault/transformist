<?php

namespace Transformist\Converter\Fake;

use Transformist\Converter\Fake;



/**
 *	@author Félix Girault <felix@vtech.fr>
 */

class Html extends Fake {

	/**
	 *
	 */

	public static function conversions( ) {

		return array( 'text/plain' => 'text/html' );
	}
}
