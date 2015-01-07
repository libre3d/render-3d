<?php

namespace Libre3d\Test\Render3d\Render;

use \Libre3d\Render3d\Render3d,
	\Libre3d\Render3d\Render\Povray,
	\Libre3d\Test\Render3d\Render3dTestCase;

class ScadStlTest extends Render3dTestCase {
	/**
	 * Tests that render process runs all of the conversion needed to go all the way from scad to pov file type.
	 * 
	 * @return void
	 */
	public function testRenderConverts() {
		$render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['cmd', 'convertTo']);

		$render3d->expects($this->at(0))
			->method('convertTo')
			->with('stl')
			->will($this->returnCallback(function () use ($render3d) {$render3d->fileType('stl');}));

		$render3d->expects($this->at(1))
			->method('convertTo')
			->with('pov')
			->will($this->returnCallback(function () use ($render3d) {$render3d->fileType('pov');}));

		$render3d->workingDir($this->workingDir);
		$render3d->fileType('scad');
		$render3d->file('example');

		// Must mock up the file being created so that the render process thinks it was successful
		file_put_contents($this->workingDir . 'example.png', 'file contents');

		$render = new Povray($render3d);
		$render->render();
	}

	/**
	 * Makes sure render returns the path
	 * 
	 * @return void
	 */
	public function testRenderReturn() {
		$render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['cmd', 'convertTo']);

		$render3d->expects($this->never())
			->method('convertTo');

		$render3d->expects($this->once())
			->method('cmd');

		$render3d->workingDir($this->workingDir);
		$render3d->fileType('pov');
		$render3d->file('example');

		// Must mock up the file being created so that the render process thinks it was successful
		file_put_contents($this->workingDir . 'example.png', 'file contents');

		$render = new Povray($render3d);
		$path = $render->render();
		$this->assertEquals($this->workingDir . 'example.png', $path);
	}

	/**
	 * Test that exception is thrown when render seems to fail
	 * @return void
	 */
	public function testRenderFail() {
		$render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['cmd', 'convertTo']);

		$render3d->expects($this->never())
			->method('convertTo');

		$render3d->expects($this->once())
			->method('cmd');

		$render3d->workingDir($this->workingDir);
		$render3d->fileType('pov');
		$render3d->file('example');

		// do NOT write contents to file...  so it should throw an exception when it sees that file does not exist

		$render = new Povray($render3d);
		$this->setExpectedException('\Exception');
		$render->render();
	}
}