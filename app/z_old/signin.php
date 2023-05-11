<?php  

require_once('php/config.php'); 
require_once('php/db.php');
session_start(); 

$input['email'] = '';
$input['password'] = '';
$error['alert'] = '';
$error['email'] = '';
$error['password'] = '';

if (isset($_SESSION['userId']))
{
	header('Location: '.BASE_URL.'home.php');
}
else
{
	if (!isset($_POST['signIn']))
	{
		include 'views/v_signIn.php';
	}
	else
	{
		$input['email'] = htmlentities($_POST['email'], ENT_QUOTES);
		$input['password'] = htmlentities($_POST['password'], ENT_QUOTES);

		if (isAnyInputBlank($input) 
			|| !isEmailValid($input['email']) 
			|| !isPasswordStrong($input['password'])
			|| !isEmailTaken($input['email'])
			|| !isPasswordCorrect($input))
		{
			displaySignInView();
		}
		else
		{
			loginUser($input['email']);
		}
	}
}

function displaySignInView()
{
	global $error, $input;

	include 'views/v_signIn.php';
}

function isAnyInputBlank($input)
{
	global $error;

	if ($input['email'] == '' || $input['password'] == '')
	{
		if ($input['email'] == '')
		{
			$error['email'] = 'email is required';
		}

		if ($input['password'] == '')
		{
			$error['password'] = 'password is required';
		}

		$error['alert'] = 'Please fill in the required fields!';

		return true;
	}

	return false;
}

function isEmailValid($email)
{
	global $error;

	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$error['email'] = 'invalid email address';
		$error['alert'] = 'Please enter a valid email address!';

		return false;
	}

	return true;
}

function isPasswordStrong($password)
{
	global $error;

	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) 
	{
	    $error['password'] = 'password is not strong enough';
	    $error['alert'] = 'Password must be at least 8 characters in length. It must include at least one upper case letter, one number and one special character.';

	    return false;
	}

	return true;
}

function isEmailTaken($email)
{
	global $mysqli, $error;

	$check = $mysqli->prepare('SELECT email FROM users WHERE email = ?');
	$check->bind_param('s', $email);
	$check->execute();
	$check->store_result();
	if ($check->num_rows == 0)
	{
		$check->close();

		$error['alert'] = 'Email or password is incorrect!';

		return false;
	}
	$check->close();

	return true;
}

function isPasswordCorrect($input)
{
	global $mysqli, $error;

	$stmt = $mysqli->prepare('SELECT password_hash FROM users WHERE email = ?');
	$stmt->bind_param('s', $input['email']);
	$stmt->execute();
	$stmt->bind_result($hash);
	$stmt->fetch();
	$stmt->close();

	if (!password_verify($input['password'], $hash))
	{
		$error['alert'] = 'Email or password is incorrect!';

		return false;
	}

	return true;
}

function getUserIdByEmail($email)
{
	global $mysqli;

	$stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ?');
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->bind_result($userId);
	$stmt->fetch();
	$stmt->close();

	return $userId;
}

function loginUser($email)
{
	$userId = getUserIdByEmail($email);

	$_SESSION['userId'] = $userId;
	$_SESSION['last_active'] = time();

	header("Location: home.php");
}





?>