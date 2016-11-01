<?php

/**
 * ClientIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class XCustomerIdentity extends CUserIdentity
{
	private $_id;

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		
		$user = VCustomer::model()->find('LOWER(email)=?',array(strtolower($this->username)));
		if($user===null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else
		{
			$this->_id = $user->id;
			$this->username = $user->fullName;
			$this->setState('customer',$user);
			$this->errorCode = self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}
