<?php

namespace Libre3d\Test\Render3d\Convert;

use \Libre3d\Render3d\Render3d,
	\Libre3d\Render3d\Convert\StlPovSteps\Step1Inc,
	\org\bovigo\vfs\vfsStream;

class Step1IncTest extends \PHPUnit_Framework_TestCase {
	public function testConvertOneStep() {
		$root = vfsStream::setup();

		$render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['cmd']);

		$render3d->workingDir(vfsStream::url('root/working/'));
		$render3d->file('filename');
		$render3d->fileType('stl');

		$render3d->expects($this->once())
			->method('cmd')
			->with('stl2pov -s "filename.stl" > "filename.pov-inc"');

		// Must mock up the file being created so that the convert process thinks it was successful
		vfsStream::create([
			'working' => ['filename.pov-inc' => 'file contents']
		], $root);

		$converter = new Step1Inc($render3d);

		$converter->convert(true);

		// Make sure it updated the file type when successful
		$this->assertEquals('pov-inc', $render3d->fileType(), 'Ensure that the file type was updated when convert successful');
		$this->assertEquals('filename', $render3d->file(), 'Ensure that the filename stayed the same for consistency');
	}
}