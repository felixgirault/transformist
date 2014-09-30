<?php

namespace Transformist\Converter;

use Transformist\Converter;
use Transformist\Command;
use Transformist\Exception;
use Transformist\Registry;
use Transformist\File;



/**
 *	Converts documents using ImageMagick.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class ImageMagick extends Converter {

	/**
	 *	{@inheritDoc}
	 */

	public function __construct( Map $Extensions ) {

		parent::__construct( $Extensions );

		$this->_Conversions->setMulti([
			'image/gif',
			'image/jpeg',
			'image/png',
			'image/svg+xml',
			'image/tiff'
		]);
	}



	/**
	 *	Tests if the convert command is available on the system.
	 *
	 *	@return boolean True if the command exists.
	 */

	public function test( ) {

		$Convert = new Command( 'convert' );

		if ( !$Convert->exists( )) {
			throw new Exception(
				'The convert command (from imagemagick) is not available.'
			);
		}

		return true;
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Document $Document Document to convert.
	 */

	public function convert( File $Input, File $Output ) {

		$Convert = new Command( 'convert' );

		$Convert->execute([
			$this->_stringify( $input ),
			$this->_stringify( $output )
		]);
	}



	/**
	 *
	 */

	protected function _stringify( File $File ) {

		$string = $this->Extensions->get( $File->type( ));

		if ( !empty( $string )) {
			$string .= ':';
		}

		return $string . $File->path( );
	}
}
