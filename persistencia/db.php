<?php


switch ($_SERVER['HTTP_HOST']) {
		case 'localhost':
			$MyConect = [
				    'class' => 'yii\db\Connection',
				    'dsn' => 'mysql:host=localhost;dbname=bt5clean',
				    'username' => 'root',
				    'password' => '',
				    'charset' => 'utf8',
				];
				
			break;
		case '127.0.0.1':
				$MyConect = [
				    'class' => 'yii\db\Connection',
				    'dsn' => 'mysql:host=localhost;dbname=bt5clean',
				    'username' => 'root',
				    'password' => '',
				    'charset' => 'utf8',
				];

			break;
		case 'dev.mydesk.digital':
				$MyConect = [
				    'class' => 'yii\db\Connection',
				    'dsn' => 'mysql:host=localhost;dbname=bt5clean',
				    'username' => 'root',
				    'password' => '',
				    'charset' => 'utf8',
				];

			break;
		case 'devel.exportic.com':
				$MyConect = [
				    'class' => 'yii\db\Connection',
				    'dsn' => 'mysql:host=localhost;dbname=bt5clean',
				    'username' => 'root',
				    'password' => '',
				    'charset' => 'utf8',
				];

			break;
	}




return $MyConect;
