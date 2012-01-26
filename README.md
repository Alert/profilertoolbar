ProfilerToolbar v0.0.2 beta for Kohana 3.2
===============
ProfilerToolbar it is another realization of the DebugToolbar written by Aaron Forsander, but has additional features.

**Demo** and description: http://alertdevelop.ru/projects/profilertoolbar

Usage
-----

* Download project and put files into a folder called 'profiletoolbar' under modules.
* Enable Module. **IMPORTANT!** The ProfilerToolbar must be connected before modules of Cached and Database. Because the ProfilerToolbar replaces some files of them.

<pre>
Kohana::modules(array(
   ...
   'profilertoolbar' => MODPATH.'profilertoolbar',
   'cache'           => MODPATH.'cache',
   'database'        => MODPATH.'database',
   ...
));
</pre>

* In the main template write:

~~~
<html>
  <body>
    ...
    content
    ...
    <?php ProfilerToolbar::render(true);?>
  </body>
</html>
~~~

* rejoice!

How to add your data
--------------------
Example:
<pre>
ProfilerToolbar::addData('first tab','test string');
ProfilerToolbar::addData('first tab',rand(1, 1000)/ rand(1, 1000));
ProfilerToolbar::addData('first tab',$user);
ProfilerToolbar::addData('first tab',$this->request->headers());
ProfilerToolbar::addData('second tab','other data');
</pre>
