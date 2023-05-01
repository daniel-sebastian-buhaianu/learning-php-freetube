<?php  

require_once('helper_functions.php');

if (!isset($_POST['submit']))
{
	header('Location: '.BASE_URL.'index.php');
}
else
{
	$input['email'] = htmlentities($_POST['email'], ENT_QUOTES);
	$input['password'] = htmlentities($_POST['password'], ENT_QUOTES);

	if (isInputValidForLogin($input) 
		&& isEmailTaken($input['email'])
		&& isPasswordCorrect($input)) 
	{
		loginUser($input['email']);
		
	}
	
	// close db connection
   	$mysqli->close();
}

?>