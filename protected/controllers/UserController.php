<?php

class UserController extends CController
{
    /**
     * AccessControl filter
     * @return array
     */
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /**
     * AccessRules
     * @return array
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('register', 'forgot', 'verify', 'activate', 'resetpassword'),
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
    }

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
        echo $id; die;

        if ($id == null)
            throw new CHttpException(400, 'Activation ID is missing');

        $user = User::model()->findAllByAttributes(array('activation_key' => $id));

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
}