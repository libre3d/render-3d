<?php

namespace Libre3d\Render3d\Render;

/**
 * The render abstract class.  All renderers must extend this.
 */
abstract class Render {
	/**
	 * The Render3d object
	 * 
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
	 * Renders the current file.
	 * 
	 * If render successful, this method should update the Render3d's fileType to match the new file type for the rendered
	 * file.
	 * 
	 * @return string|boolean Return the full path to the rendered image, or boolean false if there are any problems
	 */
	abstract public function render();
}