<?php

namespace Libre3d\Render3d\Convert;

use Libre3d\Render3d\Render3d;

class ScadStl extends ConvertAbstract {
	
	public function convert($singleStep = false) {
		if ($this->Render3d->fileType() !== 'scad') {
			// Not the right file type to convert
			return;
		}

		//convert using scad
		$openscad = $this->Render3d->executable('openscad');
		$file_stl = $this->Render3d->file() . '.stl';
		$file_scad = $this->Render3d->filename();
		$cmd = "{$openscad} -o \"{$file_stl}\" \"{$file_scad}\"";
		
		$this->Render3d->cmd($cmd);
		
		if (!file_exists($file_stl)) {
			return $this->error("Error creating STL file from SCAD!  Cannot proceed.");
		}
		$stl_contents = file_get_contents($file_stl);
		if (!strlen($stl_contents)) {
			return $this->error("Contents of STL file are empty...");
		}
		// Success!  Update the file type
		$this->Render3d->fileType('stl');
	}

	public function error($msg) {
		// @todo: throw exception
		echo $msg;
	}
}