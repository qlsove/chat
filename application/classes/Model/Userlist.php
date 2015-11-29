<?php defined('SYSPATH') or die('No direct script access.');

class Model_Userlist extends ORM {

    protected $_table_name = 'users';

    public function getUsers($id) { 
        $query = DB::select()
            ->from($this->_table_name)
            ->where('id', '!=',  $id)
            ->execute()
            ->as_array();
            return $query;
    }

}