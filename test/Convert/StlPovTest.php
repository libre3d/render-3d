<?php

namespace Libre3d\Test\Render3d\Convert;

use \Libre3d\Render3d\Render3d,
	\Libre3d\Render3d\Convert\StlPov,
	\org\bovigo\vfs\vfsStream;

class StlPovTest extends \PHPUnit_Framework_TestCase {
	public function testConvertOneStep() {
		$render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['cmd']);

		$render3d->workingDir(vfsStream::url('root/working/'));
		$render3d->file('filename');
		$render3d->fileType('stl');

		// Mock up some steps
		$stl = $this->getMock('\Libre3d\Render3d\Convert\ConvertAbstract', ['convert'], [$render3d]);

		$stl->expects($this->once())
			->method('convert');

		$inc = $this->getMock('\Libre3d\Render3d\Convert\ConvertAbstract', ['convert'], [$render3d]);
		

		$converter = $this->getMock('\Libre3d\Render3d\Convert\StlPov', ['getStep'], [$render3d]);

		$converter->expects($this->once())
			->method('getStep')
			->with('stl')
			->will($this->returnValue($stl));

		$converter->convert(true);
	}

	public function testSecondStep() {
		$render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['cmd']);

		$render3d->workingDir(vfsStream::url('root/working/'));
		$render3d->file('filename');
		$render3d->fileType('pov-inc');

		// Mock up some steps
		$inc = $this->getMock('\Libre3d\Render3d\Convert\ConvertAbstract', ['convert'], [$render3d]);

		$inc->expects($this->once())
			->method('convert');

		$converter = $this->getMock('\Libre3d\Render3d\Convert\StlPov', ['getStep'], [$render3d]);

		$converter->expects($this->once())
			->method('getStep')
			->with('pov-inc')
			->will($this->returnValue($inc));

		$converter->convert(true);
	}

	public function testAllSteps() {
		$render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['cmd']);

		$render3d->workingDir(vfsStream::url('root/working/'));
		$render3d->file('filename');
		$render3d->fileType('stl');

		// Mock up some steps
		$stl = $this->getMock('\Libre3d\Render3d\Convert\ConvertAbstract', ['convert'], [$render3d]);

		$stl->expects($this->once())
			->method('convert');

		$inc = $this->getMock('\Libre3d\Render3d\Convert\ConvertAbstract', ['convert'], [$render3d]);
		
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

		$converter->convert(false);
	}
}