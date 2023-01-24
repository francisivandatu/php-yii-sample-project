<?php

/**
 * This is the model class for table "{{state}}".
 *
 * The followings are the available columns in table '{{state}}':
 * @property integer $id
 * @property string $name
 * @property string $abbrev
 */
class State extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{state}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>40),
			array('abbrev', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, abbrev', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'abbrev' => 'Abbrev',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('abbrev',$this->abbrev,true);
 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function getCountries()
	{
		$countries = array (
			1  => 'Afghanistan',
			2  => 'Albania',
			3  => 'Algeria',
			4  => 'Andorra',
			5  => 'Angola',
			6  => 'Antigua and Barbuda',
			7  => 'Argentina',
			8  => 'Armenia',
			9  => 'Australia',
			10  => 'Austria',
			11  => 'Azerbaijan',
			12  => 'Bahamas',
			13  => 'Bahrain',
			14  => 'Bangladesh',
			15  => 'Barbados',
			16  => 'Belarus',
			17  => 'Belgium',
			18  => 'Belize',
			19  => 'Benin',
			20  => 'Bhutan',
			21  => 'Bolivia',
			22  => 'Bosnia and Herzegovina',
			23  => 'Botswana',
			24  => 'Brazil',
			25  => 'Brunei',
			26  => 'Bulgaria',
			27  => 'Burkina Faso',
			28  => 'Burundi',
			29  => 'Cabo Verde',
			30  => 'Cambodia',
			31  => 'Cameroon',
			32  => 'Canada',
			33  => 'Central African Republic (CAR)',
			34  => 'Chad',
			35  => 'Chile',
			36  => 'China',
			37  => 'Colombia',
			38  => 'Comoros',
			39  => 'Democratic Republic of the Congo',
			40  => 'Republic of the Congo',
			41  => 'Costa Rica',
			42  => 'Cote d`Ivoire',
			43  => 'Croatia',
			44  => 'Cuba',
			45  => 'Cyprus',
			46  => 'Czech Republic',
			47  => 'Denmark',
			48  => 'Djibouti',
			49  => 'Dominica',
			50  => 'Dominican Republic',
			51  => 'Ecuador',
			52  => 'Egypt',
			53  => 'El Salvador',
			54  => 'Equatorial Guinea',
			55  => 'Eritrea',
			56  => 'Estonia',
			57  => 'Ethiopia',
			58  => 'Fiji',
			59  => 'Finland',
			60  => 'France',
			61  => 'Fiji',
			62  => 'Finland',
			63  => 'France',
			64  => 'Gabon',
			65  => 'Gambia',
			66  => 'Georgia',
			67  => 'Germany',
			68  => 'Ghana',
			69  => 'Greece',
			70  => 'Grenada',
			71  => 'Guatemala',
			72  => 'Guinea',
			73  => 'Guinea-Bissau',
			74  => 'Guyana',
			75  => 'Haiti',
			76  => 'Honduras',
			77  => 'Hungary',
			78  => 'Iceland',
			79  => 'India',
			80  => 'Indonesia',
			81  => 'Iran',
			82  => 'Iraq',
			83  => 'Ireland',
			84  => 'Israel',
			85  => 'Italy',
			86  => 'Jamaica',
			87  => 'Japan',
			88  => 'Jordan',
			89  => 'Kazakhstan',
			90  => 'Kenya',
			91  => 'Kiribati',
			92  => 'Kosovo',
			93  => 'Kuwait',
			94  => 'Kyrgyzstan',
			95  => 'Laos',
			96  => 'Latvia',
			97  => 'Lebanon',
			98  => 'Lesotho',
			99  => 'Liberia',
			100  => 'Libya',
			101  => 'Liechtenstein',
			102  => 'Lithuania',
			103  => 'Luxembourg',
			104  => 'Macedonia',
			105  => 'Madagascar',
			106  => 'Malawi',
			107  => 'Malaysia',
			108  => 'Maldives',
			109  => 'Mali',
			110  => 'Malta',
			111  => 'Marshall Islands',
			112  => 'Mauritania',
			113  => 'Mauritius',
			114  => 'Mexico',
			115  => 'Micronesia',
			116  => 'Moldova',
			117  => 'Monaco',
			118  => 'Mongolia',
			119  => 'Montenegro',
			120  => 'Morocco',
			121  => 'Mozambique',
			122  => 'Myanmar (Burma)',
			123  => 'Namibia',
			124  => 'Nauru',
			125  => 'Nepal',
			126  => 'Netherlands',
			127  => 'New Zealand',
			128  => 'Nicaragua',
			129  => 'Niger',
			130  => 'Nigeria',
			131  => 'North Korea',
			132  => 'Norway',
			133  => 'Oman',
			134  => 'Pakistan',
			135  => 'Palau',
			136  => 'Palestine',
			137  => 'Panama',
			138  => 'Papua New Guinea',
			139  => 'Paraguay',
			140  => 'Peru',
			141  => 'Philippines',
			142  => 'Poland',
			143  => 'Portugal',
			144  => 'Qatar',
			145  => 'Romania',
			146  => 'Russia',
			147  => 'Rwanda',
			148  => 'Saint Kitts and Nevis',
			149  => 'Saint Lucia',
			150  => 'Saint Vincent and the Grenadines',
			151  => 'Samoa',
			152  => 'San Marino',
			153  => 'Sao Tome and Principe',
			154  => 'Saudi Arabia',
			155  => 'Senegal',
			156  => 'Serbia',
			157  => 'Seychelles',
			158  => 'Sierra Leone',
			159  => 'Singapore',
			160  => 'Slovakia',
			161  => 'Slovenia',
			162  => 'Solomon Islands',
			163  => 'Somalia',
			164  => 'South Africa',
			165  => 'South Korea',
			166  => 'South Sudan',
			167  => 'Spain',
			168  => 'Sri Lanka',
			169  => 'Sudan',
			170  => 'Suriname',
			171  => 'Swaziland',
			172  => 'Sweden',
			173  => 'Switzerland',
			174  => 'Syria',
			175  => 'Taiwan',
			176  => 'Tajikistan',
			177  => 'Tanzania',
			178  => 'Thailand',
			179  => 'Timor-Leste',
			180  => 'Togo',
			181  => 'Tonga',
			182  => 'Trinidad and Tobago',
			183  => 'Tunisia',
			184  => 'Turkey',
			185  => 'Turkmenistan',
			186  => 'Tuvalu',
			187  => 'Uganda',
			188  => 'Ukraine',
			189  => 'United Arab Emirates (UAE)',
			190  => 'United Kingdom (UK)',
			191  => 'United States of America (USA)',
			192  => 'Uruguay',
			193  => 'Uzbekistan',
			194  => 'Vanuatu',
			195  => 'Vatican City (Holy See)',
			196  => 'Venezuela',
			197  => 'Vietnam',
			198  => 'Yemen',
			199  => 'Zambia',
			200  => 'Zimbabwe'
		);
		
		return $countries;
	}
	
	public static function getCountyValue($countryID)
	{
		
		$countries = array (
			1  => 'Afghanistan',
			2  => 'Albania',
			3  => 'Algeria',
			4  => 'Andorra',
			5  => 'Angola',
			6  => 'Antigua and Barbuda',
			7  => 'Argentina',
			8  => 'Armenia',
			9  => 'Australia',
			10  => 'Austria',
			11  => 'Azerbaijan',
			12  => 'Bahamas',
			13  => 'Bahrain',
			14  => 'Bangladesh',
			15  => 'Barbados',
			16  => 'Belarus',
			17  => 'Belgium',
			18  => 'Belize',
			19  => 'Benin',
			20  => 'Bhutan',
			21  => 'Bolivia',
			22  => 'Bosnia and Herzegovina',
			23  => 'Botswana',
			24  => 'Brazil',
			25  => 'Brunei',
			26  => 'Bulgaria',
			27  => 'Burkina Faso',
			28  => 'Burundi',
			29  => 'Cabo Verde',
			30  => 'Cambodia',
			31  => 'Cameroon',
			32  => 'Canada',
			33  => 'Central African Republic (CAR)',
			34  => 'Chad',
			35  => 'Chile',
			36  => 'China',
			37  => 'Colombia',
			38  => 'Comoros',
			39  => 'Democratic Republic of the Congo',
			40  => 'Republic of the Congo',
			41  => 'Costa Rica',
			42  => 'Cote d`Ivoire',
			43  => 'Croatia',
			44  => 'Cuba',
			45  => 'Cyprus',
			46  => 'Czech Republic',
			47  => 'Denmark',
			48  => 'Djibouti',
			49  => 'Dominica',
			50  => 'Dominican Republic',
			51  => 'Ecuador',
			52  => 'Egypt',
			53  => 'El Salvador',
			54  => 'Equatorial Guinea',
			55  => 'Eritrea',
			56  => 'Estonia',
			57  => 'Ethiopia',
			58  => 'Fiji',
			59  => 'Finland',
			60  => 'France',
			61  => 'Fiji',
			62  => 'Finland',
			63  => 'France',
			64  => 'Gabon',
			65  => 'Gambia',
			66  => 'Georgia',
			67  => 'Germany',
			68  => 'Ghana',
			69  => 'Greece',
			70  => 'Grenada',
			71  => 'Guatemala',
			72  => 'Guinea',
			73  => 'Guinea-Bissau',
			74  => 'Guyana',
			75  => 'Haiti',
			76  => 'Honduras',
			77  => 'Hungary',
			78  => 'Iceland',
			79  => 'India',
			80  => 'Indonesia',
			81  => 'Iran',
			82  => 'Iraq',
			83  => 'Ireland',
			84  => 'Israel',
			85  => 'Italy',
			86  => 'Jamaica',
			87  => 'Japan',
			88  => 'Jordan',
			89  => 'Kazakhstan',
			90  => 'Kenya',
			91  => 'Kiribati',
			92  => 'Kosovo',
			93  => 'Kuwait',
			94  => 'Kyrgyzstan',
			95  => 'Laos',
			96  => 'Latvia',
			97  => 'Lebanon',
			98  => 'Lesotho',
			99  => 'Liberia',
			100  => 'Libya',
			101  => 'Liechtenstein',
			102  => 'Lithuania',
			103  => 'Luxembourg',
			104  => 'Macedonia',
			105  => 'Madagascar',
			106  => 'Malawi',
			107  => 'Malaysia',
			108  => 'Maldives',
			109  => 'Mali',
			110  => 'Malta',
			111  => 'Marshall Islands',
			112  => 'Mauritania',
			113  => 'Mauritius',
			114  => 'Mexico',
			115  => 'Micronesia',
			116  => 'Moldova',
			117  => 'Monaco',
			118  => 'Mongolia',
			119  => 'Montenegro',
			120  => 'Morocco',
			121  => 'Mozambique',
			122  => 'Myanmar (Burma)',
			123  => 'Namibia',
			124  => 'Nauru',
			125  => 'Nepal',
			126  => 'Netherlands',
			127  => 'New Zealand',
			128  => 'Nicaragua',
			129  => 'Niger',
			130  => 'Nigeria',
			131  => 'North Korea',
			132  => 'Norway',
			133  => 'Oman',
			134  => 'Pakistan',
			135  => 'Palau',
			136  => 'Palestine',
			137  => 'Panama',
			138  => 'Papua New Guinea',
			139  => 'Paraguay',
			140  => 'Peru',
			141  => 'Philippines',
			142  => 'Poland',
			143  => 'Portugal',
			144  => 'Qatar',
			145  => 'Romania',
			146  => 'Russia',
			147  => 'Rwanda',
			148  => 'Saint Kitts and Nevis',
			149  => 'Saint Lucia',
			150  => 'Saint Vincent and the Grenadines',
			151  => 'Samoa',
			152  => 'San Marino',
			153  => 'Sao Tome and Principe',
			154  => 'Saudi Arabia',
			155  => 'Senegal',
			156  => 'Serbia',
			157  => 'Seychelles',
			158  => 'Sierra Leone',
			159  => 'Singapore',
			160  => 'Slovakia',
			161  => 'Slovenia',
			162  => 'Solomon Islands',
			163  => 'Somalia',
			164  => 'South Africa',
			165  => 'South Korea',
			166  => 'South Sudan',
			167  => 'Spain',
			168  => 'Sri Lanka',
			169  => 'Sudan',
			170  => 'Suriname',
			171  => 'Swaziland',
			172  => 'Sweden',
			173  => 'Switzerland',
			174  => 'Syria',
			175  => 'Taiwan',
			176  => 'Tajikistan',
			177  => 'Tanzania',
			178  => 'Thailand',
			179  => 'Timor-Leste',
			180  => 'Togo',
			181  => 'Tonga',
			182  => 'Trinidad and Tobago',
			183  => 'Tunisia',
			184  => 'Turkey',
			185  => 'Turkmenistan',
			186  => 'Tuvalu',
			187  => 'Uganda',
			188  => 'Ukraine',
			189  => 'United Arab Emirates (UAE)',
			190  => 'United Kingdom (UK)',
			191  => 'United States of America (USA)',
			192  => 'Uruguay',
			193  => 'Uzbekistan',
			194  => 'Vanuatu',
			195  => 'Vatican City (Holy See)',
			196  => 'Venezuela',
			197  => 'Vietnam',
			198  => 'Yemen',
			199  => 'Zambia',
			200  => 'Zimbabwe'
		);
		
		if(!empty($countries[$countryID]))
			return $countries[$countryID];
		else
			return '';
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return State the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
