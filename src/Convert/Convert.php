<?php

namespace Libre3d\Render3d\Convert;

/**
 * The convert abstract class.  All converters must extend this.
 */
abstract class Convert {
	/**
	 * The Render3d object
	 * @var Libre3d\Render3d\Render3d
	 */
	protected $Render3d;

	/**
	 * Constructor gonna construct.
	 * 
	 * @param Libre3d\Render3d\Render3d $render3d 
	 * @return void
	 */
	public function __construct(\Libre3d\Render3d\Render3d $render3d) {
		$this->Render3d = $render3d;
	}

	/**
	 * Converts the current file.
	 * 
	 * Since converters can have multiple steps, and it is possible to "step through" individual steps, it is up to
	 * each converter to "check" the current file type to make sure it knows how to convert that.
	 * 
	 * If conversion successful, this method should update the Render3d's fileType to match the new file type.
	 * 
	 * @return void
	 */
	abstract public function convert();
}