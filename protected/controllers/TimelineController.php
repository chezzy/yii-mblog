<?php

class TimelineController extends CController
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
                'actions' => array('index', 'search'),
                'users'=>array('*'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Main timeline action
     * Allows the user to see a timeline of a particular user
     */
    public function actionIndex($id = NULL)
    {
        // If the ID is not set, set this to the currently logged in user.
        if ($id == NULL)
        {
            if (Yii::app()->user->isGuest)
                $this->redirect($this->createUrl('site/login'));

            $id = Yii::app()->user->username;
        }

        // Get the user's information
        $user = User::model()->findByAttributes(array('username' => $id));
        if ($user == NULL)
            throw new CHttpException(400, 'Unable to find a user with that ID');

        $this->render('index', array(
            'user' => $user,
            'share' => new Share,
            'id' => $user->id
        ));
    }
}