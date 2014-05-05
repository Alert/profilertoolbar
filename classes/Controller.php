<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller extends Kohana_Controller {

  public function after() {
    $firebugEnabled        = ProfilerToolbar::cfg('firebug.enabled');
    $firebugShowEverywhere = ProfilerToolbar::cfg('firebug.showEverywhere');

    if ($this->request->is_initial() && $firebugEnabled && $firebugShowEverywhere) {
      ProfilerToolbar::firebug();
    }
  }

}
