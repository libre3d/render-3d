<?php

namespace Libre3d\Render3d\Convert\StlPovSteps;

use Libre3d\Render3d\Render3d,
	Libre3d\Render3d\Convert\Convert;

class Step2Pov extends Convert {
	/**
	 * TODO: refactor
	 * @var boolean
	 */
	protected $silent = false;

	protected $min = [];

	protected $max = [];

	public function convert() {
		if ($this->Render3d->fileType() !== 'pov-inc') {
			// TODO: Throw exception?
			return;
		}

		$inc_contents = file_get_contents($this->Render3d->filename());
		if (!strlen($inc_contents)) {
			return $this->error("Contents of INC file are empty...");
		}
		//need to figure out the model name, which will be in the generated inc file...
		preg_match('/#declare ([^ ]+)/', $inc_contents, $matches);
		$modelname = $matches[1];

		$cleanName = trim(preg_replace('/[^_a-zA-Z0-9]+/','_',$modelname), '_');
		if (empty($modelname) || empty($cleanName)) {
			return $this->error("Error retrieving model name...  Matches: ".print_r($matches,1));
		}

		if ($modelname !== $cleanName) {
			// Have to fix this!!!  It doesn't like certain chars in the solid name
			$inc_contents = str_replace($modelname, $cleanName, $inc_contents);

			// Update the inc file contents to re-name the object
			file_put_contents($this->Render3d->filename(), $inc_contents);
			$modelname = $cleanName;
		}
		unset($cleanName);
		
		//figure out min / max for x, y, z
		
		preg_replace_callback('/<([-0-9.]+), ([-0-9.]+), ([-0-9.]+)>/', array($this,'parseCords'), $inc_contents);
		//preg_match_all('/<([-0-9.]+), ([-0-9.]+), ([-0-9.]+)>/',$inc_contents,$cord_matches);
		unset($inc_contents);
		
		$diff['x'] = abs($this->max['x'] - $this->min['x']);
		$diff['y'] = abs($this->max['y'] - $this->min['y']);
		$diff['z'] = abs($this->max['z'] - $this->min['z']);
		
		//generate contents
		/**
		 * The template vars used by our layout template
		 * 
		 * @var array
		 */
		$tplVars = [];

		//insert the include file...
		$tplVars['includeFile'] = $this->Render3d->workingDir() . $this->Render3d->filename();
		
		$tplVars['modelname'] = $modelname;

		$tplVars['sceneDir'] = $this->Render3d->sceneDir();
		
		$tplVars['x'] = $diff['x'];
		$tplVars['y'] = $diff['y'];
		$tplVars['z'] = $diff['z'];
		
		//figure out what to use for the Z multipliers...
		
		//first one is for how far up (on z axis) to stick the camera...
		//default is a little above the top of the item...
		$mult = '1.2';
		
		$slopeThreshold = .33;
		
		//Figure out the "run" for the slope...  it's basically a triangle...
		$x = $diff['x']*2;
		$y = $diff['y']*2;
		$z = $diff['z']*$mult;
		// use pythagorean theorem
		// x^2 + y^2 = h^2 ... (x^2 + y^2)^0.5 = h
		$h = sqrt($x*$x + $y*$y);
		
		// now use h (hypotenuse) as the run.. and z as the rise...  See if the slope is less than our threshhold
		if (($diff['z']*$mult)/$h < $slopeThreshold) {
			// slope is not acceptable!  Figure out what to use a roughly 40% slope or so...
				
			// (z*mult) / h = .4 (z is "original z" pre-multiplier...) and solve for mult:
			$mult = ($h * 0.4) / $diff['z'];
		}
		$tplVars['zMult'] = round($mult, 2);
		
		// figure out things for the grid...
		
		// This is figuring out how large to make the grid, we only want to take up a part of the floor
		// (the part that the object takes up)
		$axesSize = 100;
		$axesMult = ceil( max($diff['x'],$diff['y']) / ($axesSize));
		
		$tplVars['axesSize'] = $axesSize * $axesMult;
		
		$povContents = $this->generatePov($tplVars);
		if (empty($povContents)) {
			// Error generating contents
			return $this->error('Problem generating contents.');
		}

		//attempt to write it to file
		$file = $this->Render3d->file() . '.pov';
		if (!file_put_contents($file, $povContents)) {
			return $this->error('Problem writing to file.'.$this->file_pov);
		}
		if (!strlen(file_get_contents($file))) {
			return $this->error('File contents empty!  Pov file failed.');
		}
		$this->Render3d->fileType('pov');
		return true;
	}

	/**
	 * Generate the POV file contents
	 * 
	 * @param array $tplVars
	 * @return string The POV contents to use
	 */
	protected function generatePov($tplVars) {
		$options = $this->Render3d->options();

		$defaultLayoutFile = $this->Render3d->sceneDir() . 'Pov/layout.php';

		$layoutTemplate = (empty($options['PovLayoutTemplate']))? $defaultLayoutFile : $options['PovLayoutTemplate'];

		// Extract the tpl vars so make it easier to use them in the template
		extract($tplVars);

		ob_start();

		require $layoutTemplate;

		return ob_get_clean();
	}

	protected function parseCords ($matches) {
		if (!isset($this->min['x']) || $matches[1]<$this->min['x']) {
			$this->min['x'] = $matches[1];
		}
		if (!isset($this->min['y']) || $matches[2]<$this->min['y']) {
			$this->min['y'] = $matches[2];
		}
		if (!isset($this->min['z']) || $matches[3]<$this->min['z']) {
			$this->min['z'] = $matches[3];
		}
		
		if (!isset($this->max['x']) || $matches[1]>$this->max['x']) {
			$this->max['x'] = $matches[1];
		}
		if (!isset($this->max['y']) || $matches[2]>$this->max['y']) {
			$this->max['y'] = $matches[2];
		}
		if (!isset($this->max['z']) || $matches[3]>$this->max['z']) {
			$this->max['z'] = $matches[3];
		}
		//NOTE: we are just using this as way to parse the contents...  after
		//it is done, value doesn't matter...
		return '';
	}
	
	protected function error($msg) {
		echo $msg;
	}
}