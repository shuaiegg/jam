<?php 

namespace app\controllers;

use yii\web\Controller;
use yii\log\FileTarget;

class ErrorController extends Controller{	
	public function actionError(){
		//记录错误信息到文件和数据库
		$error = \yii::$app->errorHandler->exception;
		$err_msg=' ';
		if($error){
			$file = $error->getFile();
			$line = $error->getLine();
			$message = $error->getMessage();
			$code = $error->getCode();
			$log = new FileTarget();
			$log->logFile = \yii::$app->getRuntimePath() . "/logs/err.log";
			$err_msg = $message ." [file:{$file}][line:{$line}][code:{$code}][url:{$_SERVER['REQUEST_URL']}][POST_DATA:".http_build_query($_POST)."]";
		$log->message[] = [
			$err_msg,
			1,	
			'application',
			microtime( true )
		];

		$log->export();
		//to do 写入数据库
		}

		return '错误页面<br/>错误信息：'.$err_msg;


 	}
}
	

