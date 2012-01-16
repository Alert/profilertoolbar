ProfilerToolbar v0.0.1 beta for Kohana 3.2
===============
ProfilerToolbar it is another realization of the DebugToolbar written by Aaron Forsander, but has additional features.

Usage
-----
1. Download project and put files into a folder called 'profiletoolbar' under modules
2. Enable Module
   IMPORTANT: The ProfilerToolbar must be connected before modules of Cached and Database. Because the ProfilerToolbar replaces some files of them.

    Kohana::modules(array(
      ...
      'profilertoolbar' => MODPATH.'profilertoolbar',
      'cache'           => MODPATH.'cache',
      'database'        => MODPATH.'database',
      ...
    ));

3. In the main template write:

    ProfilerToolbar::render(true);

4. rejoice!