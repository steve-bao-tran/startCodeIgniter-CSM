<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class PageModel extends MY_Model {

	public $table = 'page';
	public $primaryKey = 'page_id';

	function __construct()
	{
		parent::__construct();
	}

}