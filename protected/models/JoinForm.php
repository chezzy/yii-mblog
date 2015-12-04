<?php

class JoinForm extends CFormModel
{
    public $name;
    public $email;
    public $password;
    public $username;

    public function attributeLabels()
    {
        return array(
            'name'      => 'Your email address',
            'email'     => 'Your Full name',
            'password'  => 'Your password',
            'username'  => 'Your nickname',
        );
    }

    public function rules()
    {
        return array(
            // Email is Required, and must be an email
            array('email, username, name, password', 'required'),
            array('password', 'length', 'min'=>8),
            array('email', 'email'),
            array('username', 'validateUsername'),
            array('email', 'verifyEmailIsUnique')
        );
    }

    /**
     * Validates the username
     * @param array $attributes The attributes
     * @param array $params     The params
     * @return boolean
     */
    public function validateUsername($attributes, $params)
    {
        $user = User::model()->findByAttributes(array('username' => $this->username));

        if ($user === NULL)
            return true;

        $this->addError('username', 'That username has already been registered');
        return false;
    }

    /**
     * Validates the username
     * @param array $attributes The attributes
     * @param array $params     The params
     * @return boolean
     */
    public function verifyEmailIsUnique($attributes, $params)
    {
        $user = User::model()->findByAttributes(array('email' => $this->email));

        if ($user === NULL)
            return true;

        $this->addError('email', 'That email address has already been registered');
        return false;
    }

    public function save()
    {
        if (!$this->validate())
            return false;

        $user = new User();
        $user->attributes = array(
            'name'      => $this->name,
            'email'     => $this->email,
            'password'  => $this->password,
            'username'  => str_replace(' ', '', $this->username),
        );

        if ($user->save())
        {

            // Send an email to the user
/*            $sendgrid   = new SendGrid(Yii::app()->params['includes']['sendgrid']['username'], Yii::app()->params['includes']['sendgrid']['password']);
            $email      = new SendGrid\Email();

            $email->setFrom(Yii::app()->params['includes']['sendgrid']['from'])
                ->addTo($user->email)
                ->setSubject('Activate your mblog account')
                ->setText('Activate your mblog account')
                ->setHtml(Yii::app()->controller->renderPartial('//email/activate', array('user' => $user), true));

            // Send an email
            $sendgrid->send($email);*/

            // Return true if we get to this point
            return true;
        }

        return false;
    }

    public function beforeSave()
    {

    }
}