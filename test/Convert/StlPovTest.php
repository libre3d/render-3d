<?php

namespace Libre3d\Test\Render3d\Convert;

use \Libre3d\Render3d\Render3d,
	\Libre3d\Render3d\Convert\StlPov,
	\Libre3d\Test\Render3d\Render3dTestCase;

class StlPovTest extends Render3dTestCase {
	public function testConvertOneStep() {
		$render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['cmd']);

		$render3d->workingDir($this->workingDir);
		$render3d->file('example');
		$render3d->fileType('stl');
		$render3d->options(['SingleStep' => true]);

		// Mock up some steps
		$stl = $this->getGenericConverter($render3d);

		$stl->expects($this->once())
			->method('convert');

		$converter = $this->getMock('\Libre3d\Render3d\Convert\StlPov', ['getStep'], [$render3d]);

		$converter->expects($this->once())
			->method('getStep')
			->with('stl')
			->will($this->returnValue($stl));

		$converter->convert();
	}

	public function testSecondStep() {
		$render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['cmd']);

		$render3d->workingDir($this->workingDir);
		$render3d->file('example');
		$render3d->fileType('pov-inc');
		$render3d->options(['SingleStep' => true]);

		// Mock up some steps
		$inc = $this->getGenericConverter($render3d);

		$inc->expects($this->once())
			->method('convert');

		$converter = $this->getMock('\Libre3d\Render3d\Convert\StlPov', ['getStep'], [$render3d]);

		$converter->expects($this->once())
			->method('getStep')
			->with('pov-inc')
			->will($this->returnValue($inc));

		$converter->convert();
	}

	public function testAllSteps() {
		$render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['cmd']);

		$render3d->workingDir($this->workingDir);
		$render3d->file('example');
		$render3d->fileType('stl');

		// Mock up some steps
		$stl = $this->getGenericConverter($render3d);

		$stl->expects($this->once())
			->method('convert');

		$inc = $this->getGenericConverter($render3d);
		
		$inc->expects($this->once())
			->method('convert');

		$converter = $this->getMock('\Libre3d\Render3d\Convert\StlPov', ['getStep'], [$render3d]);

		$converter->expects($this->at(0))
			->method('getStep')
			->with('stl')
			->will($this->returnValue($stl));

		$converter->expects($this->at(1))
			->method('getStep')
			->with('pov-inc')
			->will($this->returnValue($inc));

		$converter->convert();
	}

	/**
	 * Get a generic converter with convert method mocked out
	 * 
	 * @param Libre3d\Render3d\Render3d $render3d
	 * @return Libre3d\Render3d\Convert\Convert
	 */
	protected function getGenericConverter (Render3d $render3d) {
		return $this->getMock('\Libre3d\Render3d\Convert\Convert', ['convert'], [$render3d]);
	}
}