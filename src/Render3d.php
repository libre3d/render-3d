<?php

namespace Libre3d\Render3d;

class Render3d {
	protected $renderers;

	/**
	 * Array of converter objects.
	 * 
	 * @var array
	 */
	protected $converters;

	/**
	 * Array of executables, key is the executable and value is what to use on the CMD (usually the full path to the executable)
	 * 
	 * @var array
	 */
	protected $executables;

	/**
	 * The absolute path to the working directory, where all the files are being worked on
	 * 
	 * @var string
	 */
	protected $workingDir;

	/**
	 * The absolute path to the Render3d library.  Used internally when loading things like static files.
	 * 
	 * @var string
	 */
	protected $render3dDir;

	/**
	 * The base filename, minus the extension.
	 * 
	 * All converted/rendered files will share same base name, just with different extensions that coorespond to the file type
	 * 
	 * @var string
	 */
	protected $file;

	/**
	 * The file type (file extension)
	 * 
	 * @var string
	 */
	protected $fileType;

	/**
	 * Array of messages.  (TODO: Not yet used)
	 * 
	 * @var string
	 */
	protected $messages;

	/**
	 * The directory mask to use when creating new directories
	 * 
	 * @var integer
	 */
	protected $dirMask = 0755;

	/**
	 * Constructor gonna construct
	 */
	public function __construct() {
		// Initialize all the things
		$this->render3dDir = dirname(__FILE__).'/';
	}

	/**
	 * Get and/or set the current working DIR.
	 * 
	 * @param string $workingDir If passed, will set the current working DIR.  Must be the absolute path.
	 * @return string Returns the currently set working directory
	 */
	public function workingDir ($workingDir = null) {
		if (!empty($workingDir)) {
			$this->workingDir = rtrim($workingDir, '/').'/';
			if (!file_exists($this->workingDir)) {
				mkdir($this->workingDir, $this->dirMask, true);
			}
		}
		return $this->workingDir;
	}

	/**
	 * Get and/or set the relative filename of the current file being worked on.
	 * 
	 * Once a file has been converted or rendered, this will change to the converted or rendered filename.
	 * 
	 * If you pass in a filename, it will set the "file" and "file type" based on the base name and extension.  If it
	 * includes a path (can even be a URL if the PHP environment is configured to allow this), and
	 * the workingDir is already set, it will automatically copy in the file from the specified path into the currently
	 * set working directory as well, or throw an exception if the working directory is not set.
	 * 
	 * @param string $filename If set, will try to set file and filetype accordingly, and possibly copy the file into
	 *   the working directory.
	 * @return string The current filename, relative to the working directory
	 */
	public function filename($filename = null) {
		if (!empty($filename)) {
			$pathInfo = pathinfo($filename);
			if (!empty($pathInfo['dirname']) && $pathInfo['dirname'] !== '.' && file_exists($filename)) {
				if (empty($this->workingDir)) {
					// Set the working dir based on the file path
					// TODO: Error
					throw new \Exception('Working directory required.');
				}
				// Copy it into the working folder
				$copyResult = copy($filename, $this->workingDir . $pathInfo['basename']);
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

	/**
	 * Get and/or set the current base name used for all files being processed.
	 * 
	 * @param string $file If passed in, will set the file to the value.  Cannot include path info.
	 * @return string The current value for the base filename (without the extension)
	 */
	public function file ($file = null) {
		if (!empty($file)) {
			$this->file = $file;
		}
		return $this->file;
	}

	/**
	 * Get and/or set the current file type.
	 * 
	 * In Render3d library, "fileType" is always synonymous with the file extension used.
	 * 
	 * @param string $fileType The file type, without a leading '.'
	 * @return string the current file type (file extension) without the dot.
	 */
	public function fileType($fileType = null) {
		if (!empty($fileType)) {
			$this->fileType = $fileType;
		}
		return $this->fileType;
	}

	/**
	 * Get and/or set the current directory mask used when creating a new directory.
	 * 
	 * @param int $dirMask
	 * @return int
	 */
	public function dirMask($dirMask = null) {
		if (!empty($dirMask)) {
			$this->dirMask = (int)$dirMask;
		}
		return $this->dirMask;
	}

	/**
	 * Gets/Sets the location to use for the given command.
	 * 
	 * If using as a getter (by not passing in $use), and that executable has not previously been set, it returns
	 * the $executable value.
	 * 
	 * @param string $executable The executable name, e.g. "ls"
	 * @param string $use What to use on the command line for that executable, e.g. "/bin/ls"
	 * @return string What to use for the executable
	 */
	public function executable($executable, $use=NULL) {
		if (!empty($use)) {
			$this->executables[$executable] = $use;
		}
		return empty($this->executables[$executable]) ? $executable : $this->executables[$executable];
	}

	/**
	 * Convert from the current file type to the one given.
	 * 
	 * The $singleStep parameter allows you to only process a single step of the conversion in instances when
	 * a conversion requires multiple steps.  (For instance, stl to pov)
	 * 
	 * @param string $fileType The "end" file type to convert to.
	 * @param boolean $singleStep If true, will only do a single step of the conversion.
	 * @return void
	 */
	public function convertTo ($fileType, $singleStep = false) {
		if (empty($this->fileType) || empty($this->workingDir)) {
			// File type or working dir not set
			// TODO: exception
			return false;
		}
		$currentDir = getcwd();
		
		//we need to be in base directory for all the rendering stuff to work...
		chdir($this->workingDir);

		$converter = $this->getConverter($this->fileType, $fileType);
		$result = $converter->convert($singleStep);
		
		// Now go back to the starting dir
		chdir($currentDir);
		return $result;
	}

	/**
	 * Get converter to convert from the "from" to the "to".
	 * 
	 * TODO: update phpdocs
	 * 
	 * @param string $fromType
	 * @param string $toType
	 * @return Object
	 */
	public function getConverter($fromType, $toType) {
		if (!isset($this->converters[$fromType][$toType])) {
			$class = 'Libre3d\Render3d\Convert\\'.ucfirst($fromType).ucfirst($toType);
			$this->registerConverter($class, $fromType, $toType);
		}
		return $this->converters[$fromType][$toType];
	}

	/**
	 * Register a new converter object, possibly over-writing any previously set converters for the given from and to.
	 * 
	 * TODO: update phpdocs
	 * 
	 * @param string|object $class
	 * @param string $fromType
	 * @param string $toType
	 * @return void
	 */
	public function registerConverter($class, $fromType, $toType) {
		// TODO: Make sure class implements the converter
		if (is_string($class)) {
			if (!class_exists($class)) {
				// TODO: exception
			}
			$class = new $class($this);
		}
		// TODO: enforce class extending controller
		$this->converters[$fromType][$toType] = $class;
	}

	/**
	 * Simple wrapper for running commands on command line, used by individual converters and renderers.
	 * 
	 * Useful to easily log results to file, also useful for test mocking.
	 * 
	 * @param string $call
	 */
	public function cmd ($call) {
		system ($call . " 2> {$this->workingDir}last_error.txt", $result);
		
		$errContents = trim(file_get_contents("{$this->workingDir}last_error.txt"));
		if (strlen($errContents)) {
			//print it red so it's noticed
			// @TODO: don't echo, possibly add to messages or something
			echo "<span style='color: red;'>$errContents</span>\n";
		}
		return $result;
	}
}