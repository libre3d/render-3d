<?php

namespace Libre3d\Render3d;

/**
 * Common methods useful for any classes that need mockable wrappers for common file operations, such as "copy" or
 * file_exists.
 */
trait FileOperations {
	/**
	 * Mockable method that wraps PHP's mkdir(), used for testing.
	 * 
	 * @param string $pathname
	 * @param int $mode
	 * @param boolean $recursive
	 * @return boolean
	 */
	protected function mkdir($pathname, $mode = 0777, $recursive = false) {
		if (!file_exists($pathname)) {
			return mkdir($pathname, $mode, $recursive);
		}
		if (!is_dir($pathname)) {
			// File exists but is not a directory
			return false;
		}
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