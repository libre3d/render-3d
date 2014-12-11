<?php

namespace Libre3d\Test\Render3d;

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
		// TODO: finish
	}

	public function testFileType() {
		// TODO: finish
	}

	public function testDirMask() {
		
	}
}