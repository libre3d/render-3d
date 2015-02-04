<?php

namespace Libre3d\Render3d\Convert;

/**
 * The convert abstract class.  All converters must extend this.
 */
abstract class Convert {
	/**
	 * The Render3d object
	 * @var Libre3d\Render3d\Render3d
	 */
	protected $Render3d;

	protected $fwriteBuffers = [];

	/**
	 * Constructor gonna construct.
	 * 
	 * @param Libre3d\Render3d\Render3d $render3d 
	 * @return void
	 */
	public function __construct(\Libre3d\Render3d\Render3d $render3d) {
		$this->Render3d = $render3d;
	}

	/**
	 * Write to a file, using a buffer size, to reduce number of writes to a file.
	 * 
	 * This essencially implements our own file write buffer, as the one built in is not always reliable.  Doing this
	 * way shaves time off of writing larger files.
	 * 
	 * To write remaining buffer to the file, or to simply not use buffering, pass in 0 for $bufferSize.
	 * 
	 * @param resource $handle
	 * @param string $contents Contents to write to file
	 * @param string $fn Filename being written, only used as array key to store the buffer
	 * @param integer $bufferSize Set to 0 to write any remaining in the buffer to the file
	 * @return void
	 */
	protected function fwriteBuffer($handle, $contents, $fn, $bufferSize = 8000) {
		if (!isset($this->fwriteBuffers[$fn])) {
			$this->fwriteBuffers[$fn] = '';
		}
		$this->fwriteBuffers[$fn] .= $contents;
		if (strlen($this->fwriteBuffers[$fn]) > $bufferSize) {
			if ($bufferSize) {
				fwrite($handle, $this->fwriteBuffers[$fn], $bufferSize);
				$this->fwriteBuffers[$fn] = substr($this->fwriteBuffers[$fn], $bufferSize);
			} else {
				fwrite($handle, $this->fwriteBuffers[$fn]);
				$this->fwriteBuffers[$fn] = '';
			}
		}
	}

	/**
	 * Converts the current file.
	 * 
	 * Since converters can have multiple steps, and it is possible to "step through" individual steps, it is up to
	 * each converter to "check" the current file type to make sure it knows how to convert that.
	 * 
	 * If conversion successful, this method should update the Render3d's fileType to match the new file type.
	 * 
	 * @return void
	 */
	abstract public function convert();
}