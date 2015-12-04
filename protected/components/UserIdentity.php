<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$record = User::model()->findAllByAttributes('email', $this->username);

		// PHP 5.5 BCRYPT
		if ($record == null)
			$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
		else if (password_verify($this->password, $record->password))
		{
			$this->errorCode	= self::ERROR_NONE;
			$this->_id			= $record->id;
			$this->setState('email', $record->email);
			$this->setState('role', $record->role_id);
		}
		else
			$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;

		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}