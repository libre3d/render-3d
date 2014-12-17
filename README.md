render-3d
=========

Wrapper library to help render common 3d file formats.

This is currently just an early preview.  I will be updating as time permits.

This is still in a very **volatile state**, I still have a **lot of cleanup** to do.  Namespaces, classes, method names are likely to change.  Once it is cleaned up enough to re-use in some kind of semi-stable state, I will officially make a 0.1 version release.

Requirements
============

This requires a few things to work.

  * The stl2pov python script, part of [stltools](http://rsmith.home.xs4all.nl/software/stltools.html)
  * For **Open SCAD** files:  Requires [Open SCAD](http://www.openscad.org/)
  * For the actual rendering, requires [POV Ray](http://www.povray.org/)
  * [Composer](https://getcomposer.org/)

Installation
============

  - Download the library by cloning the repo.  NOTE:  Once the library is no longer "in progress" it will be available by adding to composer.json of your project.
  - Run `composer install` from inside the library's base folder.

Usage
=====

If you don't already have the composer vendor autoload PHP file included in your project, you will need to include it like:

```php
require 'vendor/autoload.php';
```

That will need to be adjusted to require the `autoload.php` file from the vendor directory.

Then you will need to initialize the Render3d object and let it know the locations of a few things:

```php

$render3d = new \Libre3d\Render3d\Render3d();

$render3d->workingDir('/path/to/working/folder/');
$render3d->executable('stl2pov', '/path/to/stl2pov');
$render3d->executable('openscad', '/path/to/openscad');
$render3d->executable('povray', '/path/to/povray');

// Shortcut: this will copy in your starting file into the working DIR if you give the full path to the starting file.
// This will also set the fileType for you.
$render3d->filename('/path/to/starting/stlfile.stl');

// Render!  This is another shortcut, it will do all the necessary conversions as long as the render engine (in this
// case, the default engine, PovRAY) "knows" how to convert the file into a file it can use for rendering.  note that
// if needed, you can do a single step of the process.  For instance, usage on [libre3d.com](http://libre3d.com) only
// does the first step, converting to pov file "on the fly", then adds to a queue to do the rest of the rendering using
// a cron job.  This is because some of the steps can take a long time depending on the complexity of the object.
$renderedImagePath = $render3d->render('povray');

if ($renderedImagePath) {
	echo "Render successful!  Rendered image will be at $renderedImagePath";
} else {
	// NOTE: We're still cleaning up what happens when there is a problem, so how you debug will likely change
	// At the moment, it echos debug output.  That will be changing.
	echo "Some problem occured.";
}
```

The main workflow:
==================

  * Convert/export to STL file format (if not starting with an STL file)
  * Convert the STL to a POVRay file format using the `stl2pov` library.
  * Render an image using povray and a common scene template.

