<?php

class SiteController extends CController
{
	public $layout = 'signin';

	public function actionError()
	{
		$this->layout = 'main';

		if($error=Yii::app()->errorHandler->error)
			$this->render('error', array('error' => $error));
	}

	public function actionIndex()
	{
		$this->layout = 'main';
		$this->render('index');
	}

	public function actionLogin()
	{
		$model = new LoginForm();

		if (isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];

			if ($model->login())
				$this->redirect($this->createUrl('timeline/index'));
		}

		$this->render('login', array(
			'model' => $model
		));
	}
}