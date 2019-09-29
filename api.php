<?php


switch ($_REQUEST['api']){
	case 'generate_winner':
		$id = r($_POST['id']);
		$code = $db -> query("SELECT * FROM codes WHERE project_id='$id' LIMIT 1") -> fetch_object() -> code;
		$res = $db -> query("SELECT * FROM codes_data WHERE codes_id='$code' AND state='0'");
		
		$tmp = [];
		
		while ($r = $res -> fetch_object()){
			$tmp[] = $r;
		}
		
		
		$winner = rand(0, count($tmp)-1);
		
		$db -> query("UPDATE codes_data state='2' WHERE id='{$winner->id}'");
		
		
		break;
	case 'mark_as_payed':
		$id = r($_POST['id']);
		$res = $db -> query("UPDATE codes_data SET state='1' WHERE id='$id'");
		break;
	case 'generate_codes':
		$id = r($_POST['id']);
		$res = $db -> query("SELECT id FROM projects WHERE id='$id' AND user_id='{$user -> id}'");
		
		if ($res -> num_rows == 0){
			die();
		}
		
		$db -> query("DELETE FROM codes WHERE project_id='".$id."'");
		$images = array();
		switch (intval($_POST['project_type'])){
			case '1':
				$name = md5(time().rand(0, 100));
				QRcode::png($name, 'codes/'.$name.'.png');
				$db -> query("INSERT INTO codes VALUES (null, '$id', '$name', '".r('codes/'.$name.'.png')."')");
				echo $db -> error;
				$images[] = 'codes/'.$name.'.png';
				break;
			case '2':
				for ($i = 0; $i < intval($_POST['project_qr_count']); $i++){
					$name = md5(time().rand(0, 100));
					QRcode::png($name, 'codes/'.$name.'.png');
					$db -> query("INSERT INTO codes VALUES (null, '$id', '$name', '".r('codes/'.$name.'.png')."')");
					$images[] = 'codes/'.$name.'.png';
				}
				break;
		}
		
		echo json_encode($images);
		
		
		break;
	case 'get_project':
		$res = $db -> query("SELECT * FROM projects WHERE id='".r($_POST['id'])."' AND user_id='{$user -> id}'");
		if ($res -> num_rows == 0){
			die();
		}
		
		$project = $res -> fetch_object();
		require_once 'right_side.php';
		break;
	case 'update_project':
		$res = $db -> query("UPDATE projects SET qr_count='".r($_POST['project_qr_count'])."' ,project_name='".r($_POST['project_name'])."', type='".intval($_POST['project_type'])."' WHERE id='".r($_POST['id'])."' AND user_id='{$user -> id}'");	
		
		break;
	case 'remove_project':
		$db -> query("DELETE FROM projects WHERE id='".r($_POST['id'])."' AND user_id='{$user -> id}'");
		echo $db -> insert_id;
		break;
	case 'add_project':
		$db -> query("INSERT INTO projects VALUES (null, '{$user -> id}', '', 0, 0)");
		echo $db -> insert_id;
		break;
	case 'login': 
		$data = explode('-', $_POST['val']);
		$res = $db -> query("SELECT * FROM users WHERE user_name='".r($data[0])."' AND user_key='".r($data[1])."'");

		if ($res -> num_rows > 0){
			$u = $res -> fetch_object();
			$token = md5(time().rand(0, 100));
			setcookie('at', $token, time()+ 24*3600, '/');
			$res = $db -> query("UPDATE users SET user_token='{$token}' WHERE id='{$u -> id}'");
			echo 1;
		}
		break;
	case 'signup':
		$str = 'qwretyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
		
		do {
			$tmp = '';
			for ($i = 0; $i < 4; $i++){
				$tmp .= $str[rand(0, strlen($str) - 1)];
			}
			$res = $db -> query("SELECT * FROM users WHERE user_key='$tmp'");
		} while ($res -> num_rows > 0);
		$token = md5(time().rand(0, 100));
		setcookie('at', $token, time()+ 24*3600, '/');
		$db -> query("INSERT INTO users VALUES (null, '".r($_POST['val'])."', '$tmp', '$token', 0)");
		echo $_POST['val'].'-'.$tmp;
		break;
	case 'logout':
		setcookie('at', '1', 1, '/');
		header('location: /');
		break;
	case 'show_login':
		if (!isset($user)){
			die();
		}
		echo $user -> user_name.'-'.$user -> user_key;
		
		break;
		
}
die();