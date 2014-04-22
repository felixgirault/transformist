<?php

namespace Transformist\Container;

use Pimple;
use Transformist\Container\ImageMagick;
use Transformist\Container\Office;



/**
 *	Standard container for converters.
 *
 *	@package Transformist.Container
 *	@author Félix Girault <felix@vtech.fr>
 */

class Container extends Pimple {

	public function __construct( ) {

		parent::__construct( );

		$this['mapping'] = [
			'ImageMagick' => [
				'image/gif' => [
					'image/jpeg',
					'image/png',
					'image/svg+xml',
					'image/tiff'
				],
				'image/jpeg' => [
					'image/gif',
					'image/png',
					'image/svg+xml',
					'image/tiff'
				],
				'image/png' => [
					'image/gif',
					'image/jpeg',
					'image/svg+xml',
					'image/tiff'
				],
				'image/svg+xml' => [
					'image/gif',
					'image/jpeg',
					'image/png',
					'image/tiff'
				],
				'image/tiff' => [
					'image/gif',
					'image/jpeg',
					'image/png',
					'image/svg+xml'
				]
			],
			'Office' => [
				'application/msword' => [
					'application/pdf',
					'application/pdfa'
				],
				'application/pdf' => 'application/pdfa'
			]
		];

		$this['ImageMagick'] = function( ) {
			return new ImageMagick( );
		};

		$this['Office'] = function( ) {
			return new Office( );
		};
	}
}
