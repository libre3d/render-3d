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
		$this->render3d = $this->getMock('\Libre3d\Render3d\Render3d', ['mkdir']);

		parent::setUp();
	}

	public function testWorkingDir() {
		$dir = '/tmp/testDir/';
		$mode = 0755;

		// It should call mkdir
		$this->render3d->expects($this->once())
			->method('mkdir')
			->with($dir, $mode, true);

		$workingDir = $this->render3d->workingDir($dir);

		$this->assertEquals($dir, $workingDir);
		// Make sure it is retained
		$this->assertEquals($dir, $this->render3d->workingDir());
	}

	public function testFilename() {
		// TODO: finish
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