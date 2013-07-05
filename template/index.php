<?php
	//configurations
	$secret_key = '413a64cb0773aa7137021c8bbc51d023';

	$signed_request = isset($_POST['signed_request']) ? $_POST['signed_request'] : '';	
	
	if($signed_request)
	{
		$data = parse_signed_request($signed_request, $secret_key);
		
		//init data from signed request
		$page_id 			= $data['page']['id'];
		$user_liked_page 	= $data['page']['liked'];
		$user_is_admin		= $data['page']['admin']; 
		$app_data			= isset($data['app_data']) ? $data['app_data'] : '';

		if(!$user_liked_page)
			header('location: like_gate.htm');
		else
		{
			if($app_data)
				header('location: '.$app_data.'.htm');
			else
				header('location: home.htm');
		}
	}
	else
	{
		if($app_data)
			header('location: '.$app_data.'.htm');
		else
			header('location: home.htm');
	}
?>
<?php
	function parse_signed_request($signed_request, $secret)
	{
		list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
	
		// decode the data
		$sig 	= base64_url_decode($encoded_sig);
		$data 	= json_decode(base64_url_decode($payload), true);
	
		if(strtoupper($data['algorithm']) !== 'HMAC-SHA256')
		{
			error_log('Unknown algorithm. Expected HMAC-SHA256');
			return null;
		}
	
		// check sig
		$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
		if ($sig !== $expected_sig)
		{
			error_log('Bad Signed JSON signature!');
			return null;
		}
	
		return $data;
	}

	function base64_url_decode($input)
	{
		return base64_decode(strtr($input, '-_', '+/'));
	}
?>