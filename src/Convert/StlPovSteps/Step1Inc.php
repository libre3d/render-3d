<?php

namespace Libre3d\Render3d\Convert\StlPovSteps;

use Libre3d\Render3d\Render3d,
	Libre3d\Render3d\Convert\Convert;

class Step1Inc extends Convert {
	public function convert() {
		if ($this->Render3d->fileType() !== 'stl') {
			// TODO: Throw exception?
			return;
		}
		
		$stl2pov = $this->Render3d->executable('stl2pov');
		$file = $this->Render3d->file();
		
		// NOTE: older version syntax.
		$cmd = "{$stl2pov} -s \"{$file}.stl\" > \"{$file}.pov-inc\"";
		
		$this->Render3d->cmd($cmd);

		$filename = $this->Render3d->workingDir().$file.'.pov-inc';
		
		if (!file_exists($filename)) {
			throw new \Exception("Error creating INC file!  Cannot proceed.");
		}
		$inc_contents = file_get_contents($filename);
		if (!strlen($inc_contents)) {
			throw new \Exception("Contents of INC file are empty, convert failed.");
		}
		$this->Render3d->fileType('pov-inc');
	}
}