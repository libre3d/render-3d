<?php

namespace Libre3d\Render3d\Render;

class Povray extends Render {
	public function render() {
		// Allow "chaned" actions so can just call render and this does all the conversion necessary
		$this->preConvert();

		if ($this->Render3d->fileType() !== 'pov') {
			// @todo exception
			return;
		}

		$defaults = [
			'width' => 1600,
			'height' => 1200,
		];
		$defaults['povray'] = $this->Render3d->executable('povray');

		if (strpos($defaults['povray'], '/') !== false) {
			$defaults['PovLibraryIncDir'] = dirname($defaults['povray']) . '/include';
		}
		$defaults['PovOutFile'] = $this->Render3d->workingDir() . $this->Render3d->file() . '.png';

		$opts = array_merge($defaults, $this->Render3d->options());

		$pov = $this->Render3d->filename();
		
		//+I	- input file name
		//+FN	- PNG file format
		//+W	- Width of image
		//+H	- Height of image
		//+O	- output file
		//+Qn	- image quality (0 = rough, 9 = full)
		//+AMn	- use non-adaptive (n=1) or adaptive (n=2) supersampling
		//+A0.n	- perform antialiasing (if color change is above n percent)
		//+L	- Library include directory
		$cmd = "{$opts['povray']} +I\"{$pov}\" +FN +W{$opts['width']} +H{$opts['height']} +O\"{$opts['PovOutFile']}\" +Q9 +AM2 +A0.5";
		if (!empty($opts['PovLibraryIncDir'])) {
			$cmd .= " +L{$opts['PovLibraryIncDir']}";
		}

		$this->cmd($cmd);
		if (!file_exists($opts['PovOutFile'])) {
			return false;
		}

	}

	protected function preConvert () {
		switch ($this->Render3d->fileType()) {
			case 'scad':
				$this->Render3d->convertTo('stl');
				// Break ommited on purpose
			
			case 'stl':
				$this->Render3d->convertTo('pov');
				break;
		}
	}
}