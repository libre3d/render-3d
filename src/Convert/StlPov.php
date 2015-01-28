<?php

namespace Libre3d\Render3d\Convert;

use Libre3d\Render3d\Render3d;

class StlPov extends Convert {
	
	public function convert() {
		$options = $this->Render3d->options();
		$singleStep = !empty($options['SingleStep']) && $options['SingleStep'];
		
		if ($this->Render3d->fileType() === 'pov') {
			// already at the desired type, nothing more to do!
			return;
		}
		if ($this->Render3d->executable('stl2pov') === 'native') {
			// use ported native functionality
			$steps = [$this->getStep('native')];
		} else {
			$steps = $this->initSteps($singleStep);
		}
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
				$steps[] = $this->getStep('stl');
				if ($singleStep) {
					// Fall through if NOT $singleStep
					break;
				}
			case 'pov-inc':
				$steps[] = $this->getStep('pov-inc');
		}
		return array_filter($steps);
	}

	/**
	 * Seperate out the process of creating a step based on file type so that it is easily mockable for tests.
	 * 
	 * @param string $fromType
	 * @return Libre3d\Render3d\Convert\Convert|boolean The step to use, or boolean false if no step found for
	 *   that type.
	 */
	protected function getStep($fromType) {
		switch($fromType) {
			case 'native':
				return new StlPovSteps\Step0Pov($this->Render3d);
				break;

			case 'stl':
				return new StlPovSteps\Step1Inc($this->Render3d);
				break;

			case 'pov-inc':
				return new StlPovSteps\Step2Pov($this->Render3d);
				break;
		}
		return false;
	}
}