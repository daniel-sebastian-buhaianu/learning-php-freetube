import { BASE_URL } from './helper_functions.js';

const Logo = () => {
	const logo = document.getElementById('logo');
	logo.addEventListener('click', () => {
		window.location.href = BASE_URL;
	});
};

export { Logo };