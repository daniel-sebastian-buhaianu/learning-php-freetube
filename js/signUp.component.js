import { BASE_URL } from './helper_functions.js';

const SignUp = () => {
	const signUpBtn = document.getElementById('signUp');

	signUpBtn.addEventListener('click', () => {
		window.location.href = BASE_URL + 'signup.php';
	});
};

export { SignUp };