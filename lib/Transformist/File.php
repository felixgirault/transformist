<?php

namespace Transformist;

use finfo;
use Transformist\Exception;



/**
 *	Wraps some functionnalities of SplFile, and adds some pretty useful stuff.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class File {

	/**
	 *	File path.
	 *
	 *	@var string
	 */

	protected $_path = '';



	/**
	 *	MIME type of the file.
	 *
	 *	@var string
	 */

	protected $_type = '';



	/**
	 *	Constructs a new File object.
	 *
	 *	@param string $fileName Path to the file.
	 *	@param string $type MIME type of the file to avoid auto detection.
	 */

	public function __construct( $filePath, $type = '' ) {

		$this->_path = self::absolutePath( $filePath );
		$this->_type = $type;
	}



	/**
	 *	Returns the absolute path of the given path.
	 *
	 *	@param string $path Orignal path.
	 *	@return string Absolute path.
	 */

	public static function absolutePath( $path ) {

		$absolutePath = realpath( $path );

		if ( $absolutePath === false ) {
			$absolutePath = $path;
		}

		return $absolutePath;
	}



	/**
	 *	Returns if the file exists.
	 *
	 *	@return boolean True if the file exists, otherwise false.
	 */

	public function exists( ) {

		return file_exists( $this->_path );
	}



	/**
	 *	Returns the base name of the file, directory, or link without path
	 *	info or extension.
	 *
	 *	@return string File name.
	 */

	public function baseName( ) {

		return basename( $this->_path, '.' . $this->extension( ));
	}



	/**
	 *	Returns the file extension.
	 *
	 *	@return string Extension.
	 */

	public function extension( ) {

		return pathinfo( $this->_path, PATHINFO_EXTENSION );
	}



	/**
	 *	Sets the file extension.
	 *
	 *	@todo FIND A BETTER IMPLEMENTATION. THIS IS CRAP.
	 *	@param string $extension Extension.
	 */

	public function setExtension( $extension ) {

		$this->_path = dirname( $this->_path )
			. DIRECTORY_SEPARATOR . $this->baseName( ) . '.' . $extension;
	}



	/**
	 *	Returns if the file is readable.
	 *
	 *	@return boolean True if the file is readable, otherwise false.
	 */

	public function isReadable( ) {

		return is_readable( $this->_path );
	}



	/**
	 *	Returns if the file is writable.
	 *
	 *	@return boolean True if the file is writable, otherwise false.
	 */

	public function isWritable( ) {

		return is_writable( $this->_path );
	}



	/**
	 *	Returns if the directory containing the file is readable.
	 *
	 *	@return boolean True if the directory is readable, otherwise false.
	 */

	public function isDirReadable( ) {

		return is_readable( dirname( $this->_path ));
	}



	/**
	 *	Returns if the directory containing the file is writable.
	 *
	 *	@return boolean True if the directory is writable, otherwise false.
	 */

	public function isDirWritable( ) {

		return is_writable( dirname( $this->_path ));
	}



	/**
	 *	Returns the absolute path to the file.
	 *
	 *	@return string Path.
	 */

	public function path( ) {

		return $this->_path;
	}



	/**
	 *	Returns the absolute path to the directory containing the file.
	 *
	 *	@return string Path.
	 */

	public function dirPath( ) {

		return dirname( $this->_path );
	}



	/**
	 *	Returns the MIME type of the file.
	 *
	 *	@return string MIME type.
	 *	@throws Exception
	 */

	public function type( ) {

		if ( $this->_type === '' ) {
			$this->_detectType( );
		}

		return $this->_type;
	}



	/**
	 *	Forces a MIME type for the file.
	 *
	 *	@param string $type MIME type.
	 */

	public function setType( $type ) {

		$this->_type = $type;
	}



	/**
	 *	Attempts to detect the MIME type of the file.
	 *
	 *	@throws Exception
	 */

	protected function _detectType( ) {

		if ( !class_exists( 'finfo' )) {
			throw new Exception(
				'MIME type detection requires the File extension.'
			);
		}

		$info = new finfo( FILEINFO_MIME );
		$type = @$info->file( $this->_path );

		if ( $type === false ) {
			throw new Exception( 'Unable to detect MIME type.' );
		}

		// finfo can return MIME types in the form 'application/msword; charset=binary'.
		// In this case, we keep the only part that matters to us: 'application/msword'.

		$semicolon = strpos( $type, ';' );

		if ( $semicolon !== false ) {
			$type = array_shift( explode( ';', $type ));
		}

		$this->_type = $type;
	}
}
