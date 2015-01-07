<?php

namespace Libre3d\Test\Render3d\Convert;

use \Libre3d\Render3d\Render3d,
	\Libre3d\Render3d\Convert\StlPovSteps\Step1Inc,
	\Libre3d\Test\Render3d\Render3dTestCase;

class Step1IncTest extends Render3dTestCase {
	public function testConvert() {
		$render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['cmd']);

		$render3d->workingDir($this->workingDir);
		$render3d->file('example');
		$render3d->fileType('stl');

		$render3d->expects($this->once())
			->method('cmd')
			->with('stl2pov "example.stl"; mv "example.inc" "example.pov-inc"');

		// Must mock up the file being created so that the convert process thinks it was successful
		file_put_contents($this->workingDir . 'example.pov-inc', 'file contents');

		$converter = new Step1Inc($render3d);

		$converter->convert(true);

		// Make sure it updated the file type when successful
		$this->assertEquals('pov-inc', $render3d->fileType(), 'Ensure that the file type was updated when convert successful');
		$this->assertEquals('example', $render3d->file(), 'Ensure that the filename stayed the same for consistency');
	}
}