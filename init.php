<?php defined('SYSPATH') or die('No direct script access.');

// include vendor FireBug
if(ProfilerToolbar::cfg('firebug.enabled') && !class_exists('FireBug')){
  require_once Kohana::find_file('vendor/FirePHPCore','FirePHP.class','php');
}

// include vendor GeShi for code highlight
if(!class_exists('GeSHi') && (
      ProfilerToolbar::cfg('html.highlightSQL')       ||
      ProfilerToolbar::cfg('errorPage.highlightSQL')  ||
      ProfilerToolbar::cfg('errorPage.highlightPHP')
    )
  ){
  require_once Kohana::find_file('vendor/geshi','geshi','php');
}

