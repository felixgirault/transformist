<?php

namespace Transformist\Converter;

use Transformist\Converter;
use Transformist\Command;
use Transformist\Exception;
use Transformist\Registry;



/**
 *	Converts documents through the OpenOffice/LibreOffice conversion system.
 *	This converter relies on the OpenOffice/LibreOffice suite, which must be
 *	installed on the system for the conversion to be done.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Office extends Converter {

	/**
	 *	{@inheritDoc}
	 */

	public function __construct( Map $Extensions ) {

		parent::__construct( $Extensions );

		$this->_Conversions->set( 'application/pdf', 'application/pdfa' );
		$this->_Conversions->set( 'application/msword', [
			'application/pdf',
			'application/pdfa'
		]);
	}



	/**
	 *	Tests if the unoconv command is available on the system.
	 *
	 *	@return boolean True if the command exists.
	 */

	public function test( ) {

		$Unoconv = new Command( 'unoconv' );

		if ( !$Unoconv->exists( )) {
			throw new Exception( 'The unoconv command is not available.' );
		}

		$result = $Unoconv->execute([ '--version' ]);
		$version = 0;

		foreach ( $result->output( ) as $line ) {
			if ( preg_match( '#unoconv\\s+(?P<version>[0-9]\\.[0-9])#i', $line, $matches )) {
				$version = floatval( $matches['version']);
				break;
			}
		}

		if ( $version < 0.6 ) {
			throw new Exception( 'unoconv version must be 0.6 or higher.' );
		}

		return true;
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Document $Document Document to convert.
	 */

	public function convert( File $Input, File $Output ) {

		$inputPath = $Input->path( );
		$workaround = ( $Input->baseName( ) !== $Output->baseName( ));

		if ( $workaround ) {
			// The office command doesn't allow us to specify an output file
			// name.
			// So here's the trick: we're creating a link to the input file,
			// named as the desired output file name, with a unique extension
			// to ensure that the link file name doesn't exists.
			// The we will pass the symlink to the office command, which will
			// use the link name as output file name.
			$linkPath = $Output->dirPath( )
				. DIRECTORY_SEPARATOR
				. $Output->baseName( )
				. uniqid( '.workaround-' );

			if ( !symlink( $inputPath, $linkPath )) {
				throw new Exception( 'Unable to create a symlink.' );
			}

			$inputPath = $linkPath;
		}

		$arguments = [ ];

		if ( $Output->is( 'application/pdfa' )) {
			$arguments['--export'] = 'SelectPdfVersion=1';
		}

		$format = $this->Extensions->get( $Output->type( ));

		if ( $format ) {
			$arguments['--format'] = $format;
		}

		$arguments += [
			'--output' => $Output->dirPath( ),
			$inputPath
		];

		$Unoconv = new Command( 'unoconv' );
		$Unoconv->execute( $arguments );

		if ( $workaround ) {
			// We don't need the symlink anymore.
			unlink( $inputPath );
		}
	}
}
