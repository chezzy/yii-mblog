<?php

class ShareController extends CController
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
                'actions' => array('view', 'getshares'),
                'users'=>array('*'),
            ),
            array('allow',
                'actions' => array('create', 'reshare', 'like', 'delete', 'hybrid'),
                'users' => array('@')
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Retrieves the shares for a given user
     * @param int $id     The ID of the user we want to retrieve the shares for
     */
    public function actionGetShares($id = null)
    {
        // Disable the layout rendering
        $this->layout = false;

        if ($id == null)
        {
            if (Yii::app()->user->isGuest)
                throw new CHttpException(400, 'Cannot retrieve shares for that user');

            $id = Yii::app()->user->id;
        }

        $myFollowers = array();

        // CListView for showing shares
        $shares = new Share('search');
        $shares->unsetAttributes();

        if(isset($_GET['Share']))
            $shares->attributes = $_GET['Share'];

        // If this is NOT the current user, then only show stuff that belongs to this user
        if ($id != Yii::app()->user->id)
            $shares->author_id = $id;
        else
        {
            // Alter the criteria to do a search of everyone the current user is following
            $myFollowers[] = Yii::app()->user->id;

            $followers = Follower::model()->findAllByAttributes(array('follower_id' => Yii::app()->user->id));
            if ($followers != NULL)
            {
                foreach ($followers as $follower)
                    $myFollowers[] = $follower->followee_id;
            }
        }

        $this->render('getshares', array('shares' => $shares, 'myFollowers' => $myFollowers));
    }


}