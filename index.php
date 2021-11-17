<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>One Signal</title>
</head>

<body>
	<?php
	function sendMessage($to, $title, $message, $img)
	{
		$msg = $message;
		$content      = array(
			"en" => $msg
		);
		$headings = array(
			"en" => $title
		);

		if ($img == '') {
			$fields = array(
				'app_id' => APP_ID,
				"headings" => $headings,
				'included_segments' => array($to),
				'large_icon' => "https://www.google.co.in/images/branding/googleg/1x/googleg_standard_color_128dp.png",
				'content_available' => true,
				'contents' => $content
			);
		} else {
			$ios_img = array(
				"id1" => $img
			);

			$fields = array(
				'app_id' => APP_ID,
				"headings" => $headings,
				'included_segments' => array($to),
				'contents' => $content,
				"big_picture" => $img,
				'large_icon' => "https://www.google.co.in/images/branding/googleg/1x/googleg_standard_color_128dp.png",
				'content_available' => true,
				"ios_attachments" => $ios_img
			);
		}
		$fields = json_encode($fields);
		print("\nJSON sent:\n");
		print($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json; charset=utf-8',
			'Authorization: Basic ' . API_KEY
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}

	$response = sendMessage('Subscribed Users', 'Título de mensagem', 'Mensagem teste', 'https://www.google.co.in/images/branding/googleg/1x/googleg_standard_color_128dp.png');
	$return["allresponses"] = $response;
	$return = json_encode($return);

	$data = json_decode($response, true);
	print_r($data);
	$id = $data['id'];
	print_r($id);

	print("\n\nJSON received:\n");
	print($return);
	print("\n");

	?>
</body>

</html>