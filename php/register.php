<?php
	header("Content-Type: application/json", true);
    require("common.php");
	
    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

	function checkLength($s, $min, $max) {
		if (strlen($s) > $max) { return 2; }
		elseif (strlen($s) < $min) { return 1; }
		else { return 0; }
	};

	$errors = array();
	$data = array();
	
	// Checking for errors.
    if (empty($_POST['username'])) {  
        $errors['username'] = 'A username is required.';
	} else if (checkLength($_POST['username'], 5,20) > 0) {
        $errors['username'] = '5-20 characters required.';
	} else {
		$query = "SELECT 1 FROM users WHERE username = :username";
        $query_params = array(':username' => $_POST['username']); 
        
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
		$row = $stmt->fetch(); 
        
		if($row){ $errors['username'] = 'This username is already in use.'; }
	}
	
	if (empty($_POST['password'])) {
        $errors['password'] = 'A password is required.'; 
	} else if($_POST['password'] != $_POST['confirmPassword']) {
        $errors['password'] = 'Passwords do not match.';
        $errors['confirmPassword'] = 'Passwords do not match.';
	}
	
    if (empty($_POST['email'])) {
        $errors['email'] = 'An email is required.';
	} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'The specified email is not valid.';
	} else {
       $query = "SELECT 1 FROM users WHERE email = :email";
       $query_params = array(':email' => $_POST['email']); 
        
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $row = $stmt->fetch(); 
        
		if($row){ $errors['email'] = 'This email address is already registered.'; }
	}
	
    if (!empty($errors)) { // Were any errors found? If so do not continue and feed back the errors to HTML.
        $data['success'] = false;
        $data['errors']  = $errors;
		
    } else { //If not then add the user wooo
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
        $password = hash('sha256', $_POST['password'] . $salt); 
        for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password . $salt); } 
        
        $query = "INSERT INTO users (username, password, salt, email, country, rank) VALUES (:username, :password, :salt, :email, :country, 'user');";
        $query_params = array( 
            ':username' => $_POST['username'], 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_POST['email'],
            ':country' => ip_info('Visitor', 'Country')
        ); 
        
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
	
        $data['success'] = true;
    }

    echo json_encode($data);
?>