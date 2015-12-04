<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $new_email
 * @property string $password
 * @property string $name
 * @property string $activation_key
 * @property integer $activated
 * @property integer $role_id
 * @property integer $created
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property Followers[] $followers
 * @property Followers[] $followers1
 * @property Likes[] $likes
 * @property Shares[] $shares
 * @property Roles $role
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password, name', 'required'),
			array('activated, role_id, created, updated', 'numerical', 'integerOnly'=>true),
			array('username, email, new_email, password, name, activation_key', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, email, new_email, password, name, activation_key, activated, role_id, created, updated', 'safe', 'on'=>'search'),
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
			'followers' => array(self::HAS_MANY, 'Followers', 'followee_id'),
			'followers1' => array(self::HAS_MANY, 'Followers', 'follower_id'),
			'likes' => array(self::HAS_MANY, 'Likes', 'user_id'),
			'shares' => array(self::HAS_MANY, 'Shares', 'author_id'),
			'role' => array(self::BELONGS_TO, 'Roles', 'role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'email' => 'Email',
			'new_email' => 'New Email',
			'password' => 'Password',
			'name' => 'Name',
			'activation_key' => 'Activation Key',
			'activated' => 'Activated',
			'role_id' => 'Role',
			'created' => 'Created',
			'updated' => 'Updated',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('new_email',$this->new_email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('activation_key',$this->activation_key,true);
		$criteria->compare('activated',$this->activated);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('created',$this->created);
		$criteria->compare('updated',$this->updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}