import { BASE_URL } from './helper_functions.js';

const SignIn = () => {
	try {
		const signInBtn = document.getElementById('signIn');

		signInBtn.addEventListener('click', () => {
			window.location.href = BASE_URL + 'signin.php';
		});
	}
	catch(error)
	{
		console.log('error', error);
	}
};

export { SignIn };