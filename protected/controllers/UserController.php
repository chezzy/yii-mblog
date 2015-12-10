<?php

class UserController extends CController
{
    /**
     * AccessControl filter
     * @return array
     */
  /*  public function filters()
    {
        return array(
            'accessControl',
        );
    }*/

    /**
     * AccessRules
     * @return array
     */
/*    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('join', 'forgot', 'verify', 'activate', 'resetpassword'),
                'users' => array('*')
            ),
            array('allow',
                'actions' => array('index', 'follow', 'unfollow'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }*/

    public function actionJoin()
    {
        // Auth users shouldn't be able to register
        if (!Yii::app()->user->isGuest)
            $this->redirect($this->createUrl('timeline/index'));

        $form = new JoinForm();
        if (isset($_POST['JoinForm']))
        {
            $form->attributes = $_POST['JoinForm'];

            // Attempt to save user's info
            if ($form->save())
            {
                // Try to automagically log the user in, if we fail
                // trough just redirect them to the login page
                $model = new LoginForm();
                $model->attributes = array(
                    'username' => $form->email,
                    'password' => $form->password,
                );

                if ($model->login())
                {
                    // Set a success flash
                    Yii::app()->user->setFlash('success', 'You successfully registered an account');
                    $this->redirect($this->createUrl('timeline/index'));
                }
                else
                    $this->redirect($this->createUrl('site/index'));
            }
        }

        $this->render('join', array('user' => $form));
    }

    public function actionActivate($id = null)
    {

        if ($id == null)
            throw new CHttpException(400, 'Activation ID is missing');

        $user = User::model()->findByAttributes(array('activation_key' => $id));

        if ($user == null)
            throw new CHttpException(400, 'The activation ID you supplied is invalid');

        // Don't allow activations of users who have a password reset request OR have a change email request in
        // Email Change Requests and Password Reset Requests require an activated account
        if ($user->activated == -1 || $user->activated == -2)
            throw new CHttpException(400, 'There was an error fulfilling your request');

        $user->activated        = 1;
        $user->password         = null;
        $user->activation_key   = null;



        if ($user->save())
        {
            $this->render('activate');
            Yii::app()->end();
        }

        throw new CHttpException(500, 'An error occuring activating your account. Please try again later');
    }

    public function actionForgot()
    {
        $form = new ForgotForm();

        if (isset($_POST['ForgotForm']))
        {
            $form->attributes = $_POST['ForgotForm'];

            if ($form->save())
            {
                $this->render('forgot_success');
                Yii::app()->end();
            }
        }

        $this->render('forgot', array('forgotform' => $form));
    }

    /**
     * Allows the user to change their password if provided with a valid activation ID
     * @param string $id 	The activation ID that was emailed to the user
     */
    public function actionResetPassword($id = NULL)
    {
        if ($id == NULL)
            throw new CHttpException(400, 'Missing Password Reset ID');

        $user = User::model()->findByAttributes(array('activation_key' => $id));

        if ($user == NULL)
            throw new CHttpException(400, 'The password reset id you supplied is invalid');

        $form = new PasswordResetForm;

        if (isset($_POST['PasswordResetForm']))
        {
            $form->attributes = array(
                'user' => $user,
                'password' => $_POST['PasswordResetForm']['password'],
                'password_repeat' => $_POST['PasswordResetForm']['password_repeat']
            );

            if ($form->save())
            {
                $this->render('resetpasswordsuccess');
                Yii::app()->end();
            }
        }

        $this->render('resetpassword', array(
            'passwordresetform' => $form,
            'id' => $id
        ));
    }
}