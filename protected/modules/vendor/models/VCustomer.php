<?php

/**
 * This is the model class for table "{{customer}}".
 *
 * The followings are the available columns in table '{{customer}}':
 * @property integer $id
 * @property integer $vendor_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property string $status
 * @property integer $tax_exempt
 * @property string $gender
 * @property string $birthday
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $postcode
 * @property string $country
 * @property string $notes
 * @property string $currency
 * @property string $lang
 * @property string $ip
 * @property string $date_entry
 * @property string $date_update
 *
 * The followings are the available model relations:
 * @property Invoice[] $invoices
 */
class VCustomer extends CActiveRecord
{
    const ACTIVE                    = 'active';
    const SUSPENDED                 = 'suspended';
    const CANCELED                  = 'canceled';
    const UNVERIFIED                = 'unverified';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{customer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vendor_id, name, email', 'required'),
			array('email','email','on'=>'create'),
			array('password, gender, birthday, phone, address, status','required','on'=>'create'),
			array('vendor_id, customer_group_id, tax_exempt', 'numerical', 'integerOnly'=>true),
			array('name, email, password, salt', 'length', 'max'=>255),
			array('status', 'length', 'max'=>30),
			array('gender', 'length', 'max'=>20),
			array('phone, city, state, postcode, country', 'length', 'max'=>100),
			array('currency, lang', 'length', 'max'=>10),
			array('ip', 'length', 'max'=>45),
			array('birthday, address, notes, date_entry, date_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vendor_id, name, email, password, salt, status, tax_exempt, gender, birthday, phone, address, city, state, postcode, country, notes, currency, lang, ip, date_entry, date_update', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'invoices' => array(self::HAS_MANY, 'Invoice', 'customer_id'),
			'group_rel' => array(self::BELONGS_TO, 'VCustomerGroup', 'customer_group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vendor_id' => 'Vendor',
			'name' => 'Name',
			'email' => 'Email',
			'password' => 'Password',
			'salt' => 'Salt',
			'status' => 'Status',
			'tax_exempt' => 'Tax Exempt',
			'gender' => 'Gender',
			'birthday' => 'Birthday',
			'phone' => 'Phone',
			'address' => 'Address',
			'city' => 'City',
			'state' => 'State',
			'postcode' => 'Postcode',
			'country' => 'Country',
			'notes' => 'Notes',
			'currency' => 'Currency',
			'lang' => 'Lang',
			'ip' => 'Ip',
			'date_entry' => 'Date Entry',
			'date_update' => 'Date Update',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('tax_exempt',$this->tax_exempt);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('lang',$this->lang,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('date_entry',$this->date_entry,true);
		$criteria->compare('date_update',$this->date_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VCustomer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @param string $title, $exceptions 
	 * @return array of product
	 */
	public function getItems($title = null,$exceptions = array())
	{
		$items = array();
		if(isset($title))
			$items[''] = $title;
		$criteria = new CDbCriteria;
		$criteria->compare('vendor_id',Yii::app()->user->id);
		$criteria->compare('status',self::ACTIVE);
		$criteria->order = 'id ASC';

		$models = self::model()->findAll($criteria);
		foreach($models as $model){
			if(!in_array($model->id,$exceptions))
				$items[$model->id] = $model->name;
		}
		return $items;
	}

	/**
	 * @param string $sex, default to null
	 * @return array of genders
	 */
	public function getGenders($sex=null)
	{
		$types = array(
				'male'=>Yii::t('VendorModule.client','Male'),
				'female'=>Yii::t('VendorModule.client','Female'),
			);
		if(empty($sex))
			return $types;
		else
			return $types[$sex];
	}

	/**
	 * @param string $status, default to null
	 * @return array of statuses
	 */
	public function getStatuses($status=null)
	{
		$types = array(
				self::ACTIVE=>Yii::t('VendorModule.client','Active'),
				self::SUSPENDED=>Yii::t('VendorModule.client','Suspended'),
				self::CANCELED=>Yii::t('VendorModule.client','Canceled'),
				self::UNVERIFIED=>Yii::t('VendorModule.client','Unverified'),
			);
		if(empty($status))
			return $types;
		else
			return $types[$status];
	}

	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->password;
	}

	/**
	 * Generates the password hash.
	 * @param string password
	 * @param string salt
	 * @return string hash
	 */
	public function hashPassword($password,$salt)
	{
		return md5($salt.$password);
	}

	/**
	 * Generates a salt that can be used to generate a password hash.
	 * @return string the salt
	 */
	public function generateSalt()
	{
		return uniqid('',true);
	}

		/**
     * Returns list of world countries
     * 
     * @return array
     */
    public function getCountries($code=null)
    {
        //default countries
        $countries = array(
            "US" => "United States",
            "AF" => "Afghanistan",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua And Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia And Herzegowina",
            "BW" => "Botswana",
            "BR" => "Brazil",
            //          "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            //          "CD" => "Congo, The Democratic Republic Of The",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D'Ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "TP" => "East Timor",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            //          "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GA" => "Gabon",
            "GB" => "Great Britain",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "EL" => "Hellenic Republic (Greece)",
            //          "HM" => "Heard And Mc Donald Islands",
            //          "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            //          "KP" => "Korea, Democratic People's Republic Of",
            "KR" => "Korea, Republic Of",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            //          "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macau",
            //          "MK" => "Macedonia, Former Yugoslav Republic Of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            //          "FM" => "Micronesia, Federated States Of",
            "MD" => "Moldova, Republic Of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "KN" => "Saint Kitts And Nevis",
            "LC" => "Saint Lucia",
            //          "VC" => "Saint Vincent And The Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome And Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            //          "GS" => "South Georgia, South Sandwich Islands",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SH" => "St. Helena",
            "PM" => "St. Pierre And Miquelon",
            "SD" => "Sudan",
            "SR" => "Suriname",
            //          "SJ" => "Svalbard And Jan Mayen Islands",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania",
            "TH" => "Thailand",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad And Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            //          "TC" => "Turks And Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            //          "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands (British)",
            "VI" => "Virgin Islands (U.S.)",
            //          "WF" => "Wallis And Futuna Islands",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "YU" => "Yugoslavia",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        );
		if(empty($code))
			return $countries;
		else
			return $countries[$code];
	}

	public function getCurrencies($cur=null)
	{
		$types = array(
				'IDR'=>'Rupiah',
				'USD'=>'Dolar',
			);
		if(empty($cur))
			return $types;
		else
			return $types[$cur];
	}

	public function getCount($status=null)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('vendor_id', Yii::app()->user->profile->id);
		if(!empty($status))
			$criteria->compare('status',$status);
		$count = self::model()->count($criteria);
		return $count;
	}
}
