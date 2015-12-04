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
}