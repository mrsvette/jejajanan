<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $email;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// email and password are required
			array('email, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Email',
			'rememberMe'=>Yii::t('login','Remember me next time'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		$this->_identity = new ClientIdentity($this->email,$this->password);
		if(!$this->_identity->authenticate())
			$this->addError('password','Incorrect email or password.');
	}

	/**
	 * Logs in the user using the given email and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new ClientIdentity($this->email,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===ClientIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->setStateKeyPrefix('client');
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}

	/**
	 * loginx use for admin login as client
	 */
	public function loginx()
	{
		if($this->_identity===null)
		{
			$this->_identity = new XClientIdentity($this->email,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===XClientIdentity::ERROR_NONE)
		{
			$duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->setStateKeyPrefix('client');
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
