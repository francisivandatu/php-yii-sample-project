<?php

/**
 * AdminIdentity represents the data needed to identity an admin.
 */
class AdminIdentity extends CUserIdentity
{
	private $_id;
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the email_address and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{		
		$username = strtolower($this->username);
        $account = Account::model()->adminAccount()->find('LOWER(username)=?',array($username));
       
 	    if($account === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if(!$account->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id = $account->id;
            $this->username = $account->username;
            $this->errorCode = self::ERROR_NONE;
        }
		
        return $this->errorCode == self::ERROR_NONE;
	}
	
	/*
	* Override getId() method
	*/
	public function getId()
	{
		return $this->_id;
	}	
}
