<?php

namespace Libre3d\Test\Render3d;

use \Libre3d\Render3d\Render3d,
	\org\bovigo\vfs\vfsStream;

class Render3dTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Render3d object
	 * 
	 * @var \Libre3d\Render3d\Render3d
	 */
	protected $render3d;

	public function setUp() {
		$this->render3d = new Render3d();

		parent::setUp();
	}

	public function testWorkingDir() {
		$root = vfsStream::setup();

		$this->assertFalse($root->hasChild('working'));

		$this->render3d->workingDir(vfsStream::url('root/working/'));

		$this->assertTrue($root->hasChild('working'));
		// Make sure it is retained
		$this->assertEquals(vfsStream::url('root/working/'), $this->render3d->workingDir());
	}

	public function testFilename() {
		$root = vfsStream::setup();
		$workingDir = '/tmp/testDir/';

		// Test normal filename
		$filename = $this->render3d->filename('filename.ext');
		$this->assertEquals('filename.ext', $filename);
		$this->assertEquals('filename', $this->render3d->file());
		$this->assertEquals('ext', $this->render3d->fileType());

		// Set up an existing file
		vfsStream::create([
			'path' => ['another_file.ext' => 'contents']
		], $root);

		$this->render3d->workingDir(vfsStream::url('root/working/'));

		$this->assertFileNotExists(vfsStream::url('root/working/another_file.ext'));

		$filename = $this->render3d->filename(vfsStream::url('root/path/another_file.ext'));

		// Make sure it "copied" the file
		$this->assertFileExists(vfsStream::url('root/working/another_file.ext'));
		$this->assertFileEquals(vfsStream::url('root/path/another_file.ext'), vfsStream::url('root/working/another_file.ext'));

		// Make sure params got set correctly
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

	public function testConvertTo() {
		$converter = $this->getMock('\Libre3d\Convert\ConvertAbstract', ['convert']);

		$converter->expects($this->once())
			->method('convert')
			->with(false);

		$this->render3d->registerConverter($converter, 'from-type', 'to-type');

		$this->render3d->fileType('from-type');
		$this->render3d->workingDir('/tmp/testDir/');

		$this->render3d->convertTo('to-type');
	}
}