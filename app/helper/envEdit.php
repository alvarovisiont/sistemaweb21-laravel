<?
	function setEnvValue($envKey, $envValue)
	{
	    $envFile = app()->environmentFilePath();
	    $str = file_get_contents($envFile);

	    $oldValue = env($envKey);
	   	//echo $envKey." ".$oldValue." ".$envValue;
	   	//exit();
	    $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);

	    $fp = fopen($envFile, 'w');
	    fwrite($fp, $str);
	    fclose($fp);
	}

	function select_db($tipo_db = null)
	{

		$db = '';

		switch ($tipo_db) {
			
			case '1':
				$db = 'pgsql';
			break;

			case '2':
				$db = 'admin';
			break;
			
			default:
				$db = session('db') ? session('db') : 'pgsql';
				$tipo_db = session('tipo_db') ? session('tipo_db') : '1';
			break;
		}

        session(['tipo_db' => $tipo_db, 'db' => $db]);

        setEnvValue('DB_CONNECTION', $db);
	}

?>