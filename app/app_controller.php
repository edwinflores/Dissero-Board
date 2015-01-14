<?php
class AppController extends Controller
{
    public $default_view_class = 'AppLayoutView';

    function beforeFilter()
    {
      $exclude = array(
    		'user/register',
    		'user/login',
            'user/delete');

    	if (in_array(Param::get(DC_ACTION), $exclude)) {
    		return;
    	}

    	if (!is_logged_in()) {
            redirect_to(url('user/login'));
        }
    }
}
