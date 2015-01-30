[![Build Status](https://travis-ci.org/libre3d/render-3d.svg?branch=master)](https://travis-ci.org/libre3d/render-3d) 
[![codecov.io](https://codecov.io/github/libre3d/render-3d/coverage.svg?branch=master)](https://codecov.io/github/libre3d/render-3d?branch=master)

render-3d
=========

Wrapper library to help render common 3d file formats.

Requirements
============

This requires a few things to work.

  * For **Open SCAD** files:  Requires [Open SCAD](http://www.openscad.org/)
  * For the actual rendering, requires [POV Ray](http://www.povray.org/)
  * [Composer](https://getcomposer.org/)
  * ~~**stl2pov v3.2.0+** python script, part of [stltools](http://rsmith.home.xs4all.nl/software/stltools.html))~~
    * No longer required as of 1.2.0.  See issue #4 for details.

Installation
============

If you are using composer, just add `"libre3d/render-3d": "~1.1.0"` to the `require` section, then run `composer update`.

Or if you do not use composer, clone this repository.  Then [get composer](http://getcomposer.com).  Then run
`composer install` from the root folder of this library to install dependencies.


Usage
=====

If you don't already have the composer vendor autoload PHP file included in your project, you will need to include it like:

```php
require 'render-3d/vendor/autoload.php';
```

That path may need to be adjusted.

Then you will need to initialize the Render3d object and let it know the locations of a few things (note that this is
a quick example, there are many options and different ways that files can be rendered using this library):

```php

$render3d = new \Libre3d\Render3d\Render3d();

// this is the working directory, where it will put any files used during the render process, as well as the final
// rendered image.
$render3d->workingDir('/path/to/working/folder/');

// Set paths to the executables on this system
$render3d->executable('openscad', '/path/to/openscad');
$render3d->executable('povray', '/path/to/povray');

try {
	// This will copy in your starting file into the working DIR if you give the full path to the starting file.
	// This will also set the fileType for you.
	$render3d->filename('/path/to/starting/stlfile.stl');

	// Render!  This will do all the necessary conversions as long as the render engine (in this
	// case, the default engine, PovRAY) "knows" how to convert the file into a file it can use for rendering.
	// Note that this is a multi-step process that can be further broken down if you need it to.
	$renderedImagePath = $render3d->render('povray');

	echo "Render successful!  Rendered image will be at $renderedImagePath";
} catch (\Exception $e) {
	echo "Render failed :( Exception: ".$e->getMessage();
}
```

The main workflow:
==================

  * Convert to STL file format (if not starting with an STL file)
  * Convert the STL to a POVRay file format.
  * Render an image using povray and a common scene template.

Options
=======

The `$Render3d->render()` method takes an optional second parameter for `$options`, which is an array of options.  You
can also set the options before hand calling `$Render3d->options(['option1' => 'val1']);`

Here are a few options of note:
  * **buffer**  This controls what is done with output from the commands run on the command line.  The valid values are:
    * `Render3d::BUFFER_OFF` - Default value.  Nothing is displayed and nothing is buffered.
    * `Render3d::BUFFER_ON` - Buffers the output, and saves so that you can later retrieve it with `$Render3d->getBufferAndClean()`
    * `Render3d::BUFFER_STD_OUT` - Sends any output directly to std out (sends to the browser or console)
  * **width** - The width of the rendered image, in pixels.  Defaults to 1600
  * **height** - The height of the rendered image, in pixels.  Defaults to 1200

Version & Changelog
=================================

We adhere to the [Semantic Versioning Specification (SemVer)](http://semver.org/).

**Changelog:**  We use Github issues and milestones to keep track of changes from version to version.  To see what changes were in a
specific version, look at the closed issues for the corresponding milestone.

Credit
======

**Origin**

This library started out as a port of a bash script, though we mainly took the overall "how it works" and re-wrote most
of the fine details.  The original page talking about it is no longer around, but luckily
we found a cached version on [Wayback](https://web.archive.org/web/20110312125335/http://www.robottrouble.com/2009/12/01/auto-rendering-stl-files-to-png/)

You can find the original files still (as of the last time I checked) at http://diyhpl.us/~bryan/irc/stl2pov/ - the `render.sh` is the
overall file that does everything.

We took the "idea" of how the shell script did things, and ported it into a PHP library that made system calls.  The
look of the rendered images was lacking, so the scene's template file was almost completely changed.  We found that
POVRay has a lot of potential behind it if you take the time to learn how to set up the scene and do a little math to
figure out the best camera angle and such.

**src/Scenes/axes_macro.inc**

Like the bash script, we also stuck to using the
[AxesAndGridMacro](http://lib.povray.org/searchcollection/index2.php?objectName=AxesAndGridMacro&contributorTag=SharkD)
to create a nice grid.  We didn't change the inc file but we drastically changed how it was used, it mainly just renders 
a grid on the floor now.  We also made it change the grid size dynamically depending on the size of the model, it will always
be in a scale of 10, like 10 mm, 10cm, etc. depending on how large the model is.

**stl2pov**

Early versions relied on the [stl2pov python script](http://rsmith.home.xs4all.nl/software/stltools.html).  In version 1.2.0
the conversion has been ported into this PHP script.

We want to give a **special thanks** to the author of [stltools](http://rsmith.home.xs4all.nl/software/stltools.html), he
has been a great help with our quest to port the functionality into PHP by answering our questions in-depth.  If you are
looking for conversion tools that use Python, we highly recommend [stltools](http://rsmith.home.xs4all.nl/software/stltools.html).
