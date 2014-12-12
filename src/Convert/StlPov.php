<?php

namespace Libre3d\Render3d\Convert;

use Libre3d\Render3d\Render3d;

class StlPov extends ConvertAbstract {
	
	public function convert($singleStep) {
		if ($this->Render3d->fileType() === 'pov') {
			// already at the desired type, nothing more to do!
			return;
		}

		$steps = $this->initSteps($singleStep);
		if (empty($steps)) {
			return false;
		}
		foreach ($steps as $step) {
			$step->convert();
		}
		// Note: each individual step will set the parent's fileType so no need to set it here.
	}

	protected function initSteps($singleStep) {
		$steps = [];

		// Initialize steps based on file type
		switch ($this->Render3d->fileType()) {
			case 'stl':
				$steps[] = new StlPovSteps\Step1Inc($this->Render3d);
				if ($singleStep) {
					// Fall through if NOT $singleStep
					break;
				}
			case 'pov.inc':
				$steps[] = new StlPovSteps\Step2Pov($this->Render3d);
		}
		return $steps;
	}
}