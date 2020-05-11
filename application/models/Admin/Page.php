<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use Tightenco\Collect\Support\Collection;

class Page extends MY_model
{
    public $primaryKey = 'page_id';
    public $hasData = true;
    public $hasOne = [
        "user" => ['user_id', 'Admin/User', 'user'],
        'pages_type' => ['page_type_id', 'Admin/Page_type', 'Page_type'],
    ];
    public $page_data = [];

    /**
     * Page status:
     * 0 => deleted 
     * 1 => published
     * 2 => draft
     * 3 => archived
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Return all records found on a table or false if nothing is found
     * @return Collection
     */
    public function all()
    {
        $sql = 'SELECT p.*, pt.`page_type_name`, u.`username`, ug.`name`, ug.`level`
                FROM page p
                INNER JOIN USER u ON p.`user_id` = u.`user_id`
                INNER JOIN usergroup ug ON ug.`usergroup_id` = u.`usergroup_id`
                INNER JOIN page_type pt ON pt.`page_type_id` = p.`page_type_id`';

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return new Collection($query->result());
        }
        return false;
    }
}
