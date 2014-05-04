## 0.2.8 (2012-09-10)
* fixed bug FOUND_ROWS() (issue: #18)

## 0.2.7 (2012-04-29)
* fixed bug with check existence of class FirePHP

## 0.2.6 (2012-04-14)
* fixed bug with displaying arrays of variables GET/POST

## 0.2.5 (2012-04-13)
* fixed css bug

## 0.2.4 (2012-03-19)
* added support transactions (begin,commit,rollback) for mysql driver
  this is not an ideal solution because system profiler group the same queries
* fixed bug with displaying data in HMVC

## 0.2.3 (2012-03-13)
* added support work with "xdebug"

## 0.2.2 (2012-03-12)
* fixed css bug of border artifacts and jitter in opera

## 0.2.1 (2012-03-11)
* change JavaScript highlighter to server side solution
* add PHP highlighter on error page
* add SQL highlighter in html toolbar
* add on/off highlight settings to config

## 0.2.0 (2012-03-08)
* add output ProfilerToolbar to error page
* add custom error page with SQL syntax highlighter

## 0.1.6 (2012-03-07)
* change output format of request params (routes tab)
* Firebug: show use route in group tab

## 0.1.5 (2012-03-07)
* change parameters order of ProfilerToolbar::addData() method
* fixed css bug of \<pre> tag in YOUR tab

## 0.1.4 (2012-02-14)
* add htmlspecialchars() to output vars

## 0.1.3 (2012-02-08)
* add support PDO
* fixed some bugs

## 0.1.2 (2012-02-04)
* override "after" method of base Controller for display FireBug info at all Controllers
* add "firebug.showEverywhere" param in config

## 0.1.1 beta (2012-02-02)
* added FireBug support for use AJAX
* added normal config file where you can:
 * enable/disable html output
 * enable/disable firebug output
 * enable/disable display all elements separately
* changed the directory structure in VIEWS to avoid overriding templates

## 0.0.3 (2012-01-28)
* replaced short tags to long form <?php ?>
* fixed css bug of incorrect display tab border line in different browsers
* fixed error when absence of the variable $_SESSION
* info panel fixed like a menu to top of window

## 0.0.2 beta (2012-01-26)
* fixed some bugs
* changed README.md

## 0.0.1 beta (2012-01-17)
* First version