<?php

namespace Transformist\Converter;

use Transformist\Converter;
use Transformist\Document;



/**
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Fake extends Converter {

	/**
	 *
	 */

	public function convert( Document $Document ) {

		file_put_contents(
			$Document->output( )->path( ),
			file_get_contents( $Document->input( )->path( ))
		);
	}
}
