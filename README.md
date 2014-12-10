render-3d
=========

Wrapper library to help render common 3d file formats.

This is currently just an early preview.  I will be updating as time permits.

This is still in a very **volatile state**, I still have a **lot of cleanup** to do.  Namespaces, classes, method names are likely to change.  Once it is cleaned up enough to re-use in some kind of semi-stable state, I will officially make a 0.1 version release.

The main workflow:
==================

  * Convert/export to STL file format (if not starting with an STL file)
  * Convert the STL to a POVRay file format using the `stl2pov` library.
  * Render an image using povray and a common scene template.

