<?php

namespace Libre3d\Test\Render3d;

use \Libre3d\Render3d\Render3d;

class Render3dTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Render3d object
	 * 
	 * @var \Libre3d\Render3d\Render3d
	 */
	public $render3d;

	public function setUp() {
		$this->render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['mkdir', 'copy', 'fileExists']);

		parent::setUp();
	}

	public function testWorkingDir() {
		$dir = '/tmp/testDir/';
		$mode = 0755;

		// It should call mkdir
		$this->render3d->expects($this->once())
			->method('mkdir')
			->with($dir, $mode, true)
			->will($this->returnValue(true));

		$workingDir = $this->render3d->workingDir($dir);

		$this->assertEquals($dir, $workingDir);
		// Make sure it is retained
		$this->assertEquals($dir, $this->render3d->workingDir());
	}

	public function testFilename() {
		$workingDir = '/tmp/testDir/';

		// Test normal filename
		$filename = $this->render3d->filename('filename.ext');
		$this->assertEquals('filename.ext', $filename);
		$this->assertEquals('filename', $this->render3d->file());
		$this->assertEquals('ext', $this->render3d->fileType());

		// Test absolute filename
		// It should call copy
		$this->render3d->expects($this->once())
			->method('copy')
			->with('/path/another_file.ext', $workingDir.'another_file.ext')
			->will($this->returnValue(true));
		
		// Make file_exists return true
		$this->render3d->expects($this->once())
			->method('fileExists')
			->will($this->returnValue(true));

		$this->render3d->workingDir($workingDir);
		$filename = $this->render3d->filename('/path/another_file.ext');
		$this->assertEquals('another_file.ext', $filename);
		$this->assertEquals('another_file', $this->render3d->file());
		$this->assertEquals('ext', $this->render3d->fileType());
	}

	public function testFile() {
		// Without seeing anything, file should be empty
		$this->assertEmpty($this->render3d->file());
		$this->assertEquals('file1', $this->render3d->file('file1'));
		// make sure it retains value
		$this->assertEquals('file1', $this->render3d->file());

		$this->render3d->file('file2');

		$this->assertEquals('file2', $this->render3d->file());
	}

	public function testFileType() {
		// Without seeing anything, it should be empty
		$this->assertEmpty($this->render3d->fileType());
		$this->assertEquals('ext1', $this->render3d->fileType('ext1'));
		// make sure it retains value
		$this->assertEquals('ext1', $this->render3d->fileType());

		$this->render3d->fileType('ext2');

		$this->assertEquals('ext2', $this->render3d->fileType());
	}

	public function testDirMask() {
		// Without seeing anything, it should be empty
		$this->assertEquals(0755, $this->render3d->dirMask());
		$this->assertEquals(0765, $this->render3d->dirMask(0765));
		// make sure it retains value
		$this->assertEquals(0765, $this->render3d->dirMask());

		$this->render3d->dirMask(0111);

		$this->assertEquals(0111, $this->render3d->dirMask());
	}

	public function testExecutable() {
		// Without seeing anything, it should return command
		$this->assertEquals('exe1', $this->render3d->executable('exe1'));
		$this->assertEquals('/bin/exe1', $this->render3d->executable('exe1', '/bin/exe1'));
		// make sure it retains value
		$this->assertEquals('/bin/exe1', $this->render3d->executable('exe1'));

		$this->render3d->executable('exe2', '/usr/bin/exe2');

		$this->assertEquals('/usr/bin/exe2', $this->render3d->executable('exe2'));
	}

	/**
	 * TODO: INCOMPLETE
	 * 
	 * @return void
	 */
	public function _testConvertTo() {
		$stl = '/home/vagrant/shared/Fairlead.stl';

		$render = new Render3d();

		$render->workingDir('/tmp/3dTest/');
		$render->filename($stl);
		// TODO: Just double check that stl2pov is called
		$render->executable('stl2pov', '/home/vagrant/shared/libre3d/src/render/stl2pov');

		$render->convertTo('pov', true);

	}
}