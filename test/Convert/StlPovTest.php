<?php

namespace Libre3d\Test\Render3d\Convert;

use \Libre3d\Render3d\Render3d,
	\Libre3d\Render3d\Convert\StlPov,
	\Libre3d\Test\Render3d\Render3dTestCase;

class StlPovTest extends Render3dTestCase {
	public function testConvertBinary() {
		// Note: This convert is entirely "in PHP" so go ahead and test out the full process without stubbing out cmd()

		$render3d = new Render3d();
		$name = 'example-binary';
		$render3d->workingDir($this->workingDir);
		$render3d->file($name);
		$render3d->fileType('stl');

		copy($this->testFilesDir . $name . '.stl', $this->workingDir . $name . '.stl');

		$converter = new StlPov($render3d);

		$currentDir = getcwd();
		chdir($this->workingDir);

		$converter->convert(true);

		chdir($currentDir);
		
		// Make sure it updated the file type when successful
		$this->assertEquals('pov', $render3d->fileType(), 'Ensure that the file type was updated when convert successful');
		$this->assertEquals($name, $render3d->file(), 'Ensure that the filename stayed the same for consistency');
		$this->assertFileExists($this->workingDir . $name . '.pov', 'Ensure that the pov file was created');
	}

	public function testConvertStr() {
		// Note: This convert is entirely "in PHP" so go ahead and test out the full process without stubbing out cmd()

		$render3d = new Render3d();
		$name = 'example';
		$render3d->workingDir($this->workingDir);
		$render3d->file($name);
		$render3d->fileType('stl');

		copy($this->testFilesDir . $name . '.stl', $this->workingDir . $name . '.stl');

		$converter = new StlPov($render3d);

		$currentDir = getcwd();
		chdir($this->workingDir);

		$converter->convert(true);

		chdir($currentDir);
		
		// Make sure it updated the file type when successful
		$this->assertEquals('pov', $render3d->fileType(), 'Ensure that the file type was updated when convert successful');
		$this->assertEquals($name, $render3d->file(), 'Ensure that the filename stayed the same for consistency');
		$this->assertFileExists($this->workingDir . $name . '.pov', 'Ensure that the pov file was created');
	}
}