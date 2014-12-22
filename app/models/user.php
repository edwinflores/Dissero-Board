<?php

class User extends AppModel
{
	private $is_login_valid = true;

	const MIN_NAME_CHARACTERS = 8;
	const MAX_NAME_CHARACTERS = 20;

	const MIN_PASSWORD_CHARACTERS = 8;
	const MAX_PASSWORD_CHARACTERS = 20;

	public $validate = array(
		'username' => array(
			'length' => array(
				'validate_between', self::MIN_NAME_CHARACTERS, self::MAX_NAME_CHARACTERS,
				),
			),
		'password' => array(
			'length' => array(
				'validate_between', self::MIN_PASSWORD_CHARACTERS, self::MAX_PASSWORD_CHARACTERS,
				),
		)
	);

	//Adds a user
	public function register()
	{
		if (!$this->validate())
		{
			throw new ValidationException('Invalid username or password input');
		}

		$input = array(
			'username' => $this->username,
			'password' => $this->password
		);

		$db = DB::conn();
		$db->insert('user', $input);
	}

	//Verifies login credentials
	public function verify()
	{
		$query = "SELECT id, username FROM user WHERE username = ? AND password = ?";

		$db = DB::conn();
		$row = $db->row($query, array($this->username, $this->password));

		if(!$row)
		{
			$this->is_login_valid = false;
			throw new UserNotFoundException('Wrong username or password. Please try again');
		}

		return $row;
	}

	//Called to check if the login is valid or not
	public function isLoginValid()
	{
		return $this->is_login_valid;
	}
}