<?php
class Model_User extends Model_Auth_User {

	public function getUsers($id) {
		$query = ORM::factory('User')
			->where('id', '!=', $id)
			->find_all()
			->as_array();
		return $query;
	}


	public function checkToken($token) {
		$query = ORM::factory('User')
			->where('token', '!=', $token)
			->find();
		return $query;
	}


	public function checkUser($key, $data) {
		$query = ORM::factory('User')
			->where($key, '=', $data)
			->find();
		return $query;
	}
}