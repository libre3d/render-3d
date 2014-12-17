<?php

namespace Libre3d\Test\Render3d\Convert;

use \Libre3d\Render3d\Render3d,
	\Libre3d\Render3d\Convert\StlPovSteps\Step2Pov,
	\Libre3d\Test\Render3d\Render3dTestCase;

class Step2PovTest extends Render3dTestCase {
	public function testConvert() {
		// Note: This step is entirely "in PHP" so go ahead and test out the full process without stubbing out cmd()

		$render3d = new Render3d();

		$render3d->workingDir($this->workingDir);
		$render3d->file('example');
		$render3d->fileType('pov-inc');

		copy($this->testFilesDir . 'example.pov-inc', $this->workingDir . 'example.pov-inc');

		$converter = new Step2Pov($render3d);

		$currentDir = getcwd();
		chdir($this->workingDir);

		$converter->convert(true);

		chdir($currentDir);

		// Make sure it updated the file type when successful
		$this->assertEquals('pov', $render3d->fileType(), 'Ensure that the file type was updated when convert successful');
		$this->assertEquals('example', $render3d->file(), 'Ensure that the filename stayed the same for consistency');
		$this->assertFileExists($this->workingDir . 'example.pov');
	}
}