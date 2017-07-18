<?php
        $ch = curl_init();
        $auth_data = file_get_contents("secrets.json", true);
		$auth_array = json_decode($auth_data, true); 
		foreach ($auth_array as $key => $value) 
		{
			if($key=="moviedb-api-key")
			{
				$API_Key=$value;
			}
			
		}
		
         
        curl_setopt($ch, CURLOPT_URL, "https://api.themoviedb.org/3/movie/76341?api_key={$API_Key};");

        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);

        
        $output = curl_exec($ch);
        $output = json_decode($output,true);
		
        
		foreach ($output as $key => $value)
		{
			echo $key,PHP_EOL;
		}
        curl_close($ch);      

?>