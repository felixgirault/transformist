<?php

namespace Transformist;

use Transformist\FileInfo;



/**
 *	Represents a document to convert.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Document {

	/**
	 *	Input file.
	 *
	 *	@param FileInfo
	 */

	protected $_Input;



	/**
	 *	Output file.
	 *
	 *	@param FileInfo
	 */

	protected $_Output;



	/**
	 *	Constructs a document given its input and output file infos.
	 *
	 *	@param FileInfo $Input Input file info.
	 *	@param FileInfo $Output Output file info.
	 */

	public function __construct( FileInfo $Input, FileInfo $Output ) {

		$this->_Input = $Input;
		$this->_Output = $Output;
	}



	/**
	 *	Clones the document.
	 */

	public function __clone( ) {

		$this->_Input = clone $this->_Input;
		$this->_Output = clone $this->_Output;
	}



	/**
	 *	Returns the input file info object.
	 *
	 *	@return FileInfo File info.
	 */

	public function input( ) {

		return $this->_Input;
	}



	/**
	 *	Sets the input file info object.
	 *
	 *	@param FileInfo $Input File info.
	 */

	public function setInput( FileInfo $Input ) {

		$this->_Input = clone $Input;
	}



	/**
	 *	Returns the output file info object.
	 *
	 *	@return FileInfo File info.
	 */

	public function output( ) {

		return $this->_Output;
	}



	/**
	 *	Sets the output file info object.
	 *
	 *	@return FileInfo $Output File info.
	 */

	public function setOutput( FileInfo $Output ) {

		$this->_Output = clone $Output;
	}



	/**
	 *	Returns if the document was succesfully converted, i.e. if the output
	 *	file was created.
	 *
	 *	@return boolean True if the document was converted, otherwise false.
	 */

	public function isConverted( ) {

		return $this->_Output->exists( );
	}
}
