<?php

namespace Transformist;

use Transformist\File;



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
	 *	@param File
	 */

	protected $_Input;



	/**
	 *	Output file.
	 *
	 *	@param File
	 */

	protected $_Output;



	/**
	 *	Constructs a document given its input and output file infos.
	 *
	 *	@param File $Input Input file info.
	 *	@param File $Output Output file info.
	 */

	public function __construct( File $Input, File $Output ) {

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
	 *	@return File File info.
	 */

	public function input( ) {

		return $this->_Input;
	}



	/**
	 *	Sets the input file info object.
	 *
	 *	@param File $Input File info.
	 */

	public function setInput( File $Input ) {

		$this->_Input = clone $Input;
	}



	/**
	 *	Returns the output file info object.
	 *
	 *	@return File File info.
	 */

	public function output( ) {

		return $this->_Output;
	}



	/**
	 *	Sets the output file info object.
	 *
	 *	@return File $Output File info.
	 */

	public function setOutput( File $Output ) {

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
