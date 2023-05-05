import { BASE_URL } from './helper_functions.js';

const SignIn = () => {
	const signInBtn = document.getElementById('signIn');

	signInBtn.addEventListener('click', () => {
		window.location.href = BASE_URL + 'sign-in.php';
	});
};

export { SignIn };