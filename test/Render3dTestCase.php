<?php

namespace Libre3d\Test\Render3d;

class Render3dTestCase extends \PHPUnit_Framework_TestCase {
	/**
	 * The full path to the Tests/Files/ folder.
	 * 
	 * @var string
	 */
	protected $testFilesDir;

	/**
	 * The full path to a temporary working directory to use for tests.
	 * 
	 * Note that the working directory starts out not created (so that it can test creating the directory)
	 * 
	 * @var string
	 */
	protected $workingDir;

	/**
	 * If set to true, will not clean up after itself by removing working dir
	 * 
	 * @var boolean
	 */
	protected $keepWorkingDir = false;


	public function setUp() {
		$this->workingDir = sys_get_temp_dir() . '/Render3dTests/';
		$this->testFilesDir = dirname(__FILE__) . '/Files/';

		// Make sure the directory did not stick around
		$this->removeWorkingDir();

		parent::setUp();
	}

	public function tearDown() {
		// Remove any files created
		$this->removeWorkingDir();

		parent::tearDown();
	}

	/**
	 * Removes the currently set working directory and all contents.
	 * 
	 * @return void
	 */
	protected function removeWorkingDir () {
		if (!$this->keepWorkingDir && $this->workingDir && file_exists($this->workingDir)) {
			array_map('unlink', glob($this->workingDir . '*'));
			rmdir($this->workingDir);
		}
	}
}