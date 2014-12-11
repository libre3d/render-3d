<?php

namespace Libre3d\Render3d;

class Render3d {
	protected $renderers;

	protected $converters;

	protected $filters;

	protected $files;

	protected $workingDir;

	protected $render3dDir;

	protected $file;

	protected $fileType;

	protected $stopAt;

	protected $messages;

	protected $dirMask = 0755;


	public function __construct() {
		// Initialize all the things
		$this->render3dDir = dirname(__FILE__).'/';
	}

	public function workingDir ($workingDir = null) {
		if (!empty($workingDir)) {
			$this->workingDir = rtrim($workingDir, '/').'/';
			$this->mkdir($this->workingDir, $this->dirMask, true);
		}
		return $this->workingDir;
	}

	public function filename($filename = null) {
		if (!empty($filename)) {
			$pathInfo = pathinfo($filename);
			if (!empty($pathInfo['dirname']) && $pathInfo['dirname'] !== '.' && $this->fileExists($filename)) {
				if (empty($this->workingDir)) {
					// Set the working dir based on the file path
					// TODO: Error
					throw new \Exception('Working directory required.');
				}
				// Copy it into the working folder
				$copyResult = $this->copy($filename, $this->workingDir . $pathInfo['basename']);
				if (!$copyResult) {
					// TODO: Error
					throw new \Exception('Copying file to working directory failed.');
				}
			}
			// NOTE: Filename will be minus the extension
			$this->file = $pathInfo['filename'];
			$this->fileType = empty($pathInfo['extension']) ? '' : $pathInfo['extension'];
		}
		return $this->file . '.' . $this->fileType;
	}

	public function file ($file = null) {
		if (!empty($file)) {
			$this->file = $file;
		}
		return $this->file;
	}

	public function fileType($fileType = null) {
		if (!empty($fileType)) {
			$this->fileType = $fileType;
		}
		return $this->fileType;
	}

	public function dirMask($dirMask = null) {
		if (!empty($dirMask)) {
			$this->dirMask = (int)$dirMask;
		}
		return $this->dirMask;
	}

	public function stopAt ($fileType) {

	}

	/**
	 * Mockable method that wraps PHP's mkdir(), used for testing.
	 * 
	 * @param string $pathname
	 * @param int $mode
	 * @param boolean $recursive
	 * @return boolean
	 */
	protected function mkdir($pathname, $mode = 0777, $recursive = false) {
		return mkdir($pathname, $mode, $recursive);
	}

	/**
	 * Mockable method that wraps PHP's copy(), used for testing.
	 * 
	 * @param string $from 
	 * @param string $to 
	 * @return boolean
	 */
	protected function copy($from, $to) {
		return copy($from, $to);
	}

	/**
	 * Mockable method that wraps PHP's file_exists(), used for testing.
	 * 
	 * @param string filename 
	 * @return boolean
	 */
	protected function fileExists($filename) {
		return file_exists($filename);
	}
}