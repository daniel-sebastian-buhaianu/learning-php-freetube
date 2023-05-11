<?php  

require_once('php/config.php'); 
require_once('php/db.php');
session_start(); 

$input['email'] = '';
$input['password'] = '';
$input['confirmPassword'] = '';
$error['alert'] = '';
$error['email'] = '';
$error['password'] = '';
$error['confirmPassword'] = '';

if (isset($_SESSION['userId']))
{
	header('Location: '.BASE_URL.'home.php');
}
else
{
	if (!isset($_POST['signUp']))
	{
		include 'views/v_signUp.php';
	}
	else
	{
		$input['email'] = htmlentities($_POST['email'], ENT_QUOTES);
		$input['password'] = htmlentities($_POST['password'], ENT_QUOTES);
		$input['confirmPassword'] = htmlentities($_POST['confirmPassword'], ENT_QUOTES);

		if (isAnyInputBlank($input) 
			|| !isEmailValid($input['email']) 
			|| !isPasswordStrong($input['password'])
			|| !isPasswordConfirmed($input)
			|| isEmailTaken($input['email']))
		{
			displaySignUpView();
		}
		else
		{
			registerUser($input);
		}
	}
}

function displaySignUpView()
{
	global $error, $input;

	include 'views/v_signUp.php';
}

function isAnyInputBlank($input)
{
	global $error;

	if ($input['email'] == '' || $input['password'] == '' || $input['confirmPassword'] == '')
	{
		if ($input['email'] == '')
		{
			$error['email'] = 'email is required';
		}

		if ($input['password'] == '')
		{
			$error['password'] = 'password is required';
		}

		if ($input['confirmPassword'] == '')
		{
			$error['confirmPassword'] = 'confirm password is required';
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

function isPasswordConfirmed($input)
{
	global $error;

	if ($input['password'] != $input['confirmPassword'])
	{
		$error['confirmPassword'] = 'must be the same as password';
		$error['alert'] = 'Password and Confirm Password must be the same!';
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
		
		return false;
	}
	$check->close();

	$error['alert'] = 'Email is already used by another user.';
	$error['email'] = 'this email is already taken';

	return true;
}

function registerUser($input)
{
	global $mysqli;

	$stmt = $mysqli->prepare('INSERT INTO users (email, password_hash) VALUES (?,?)');
	$stmt->bind_param('ss', $input['email'], password_hash($input['password'], PASSWORD_DEFAULT));
	$stmt->execute();
	$userId = $mysqli->insert_id;
	$stmt->close();

	$_SESSION['userId'] = $userId;
	$_SESSION['last_active'] = time();

	header("Location: home.php");
}

?>