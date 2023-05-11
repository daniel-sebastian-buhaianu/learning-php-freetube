import { Logo } from './logo.component.js';

const main = () => {

	addEventListeners();

	Logo();
};

const addEventListeners = () => {

	document.getElementById('fileInput').addEventListener('change', event => handleFileInputChange(event));
};

main();

const handleFileInputChange = (event) => {

	const clearError = () => {

		if (event.target.nextSibling.nextSibling.getAttribute('class') === 'error')
		{
			event.target.nextSibling.nextSibling.remove();
			return true;
		}

		return false;
	}
	const clearAllErrors = () => {
		let needsMoreCleaning = clearError();
		while (needsMoreCleaning)
		{
			needsMoreCleaning = clearError();
		}
	}

	clearAllErrors();

	const tmp = event.target.value.split('\\');	
	const fileName = tmp[tmp.length - 1];
	const targetFileName = document.getElementById('videoId').value + '.mp4';

	const maxFileSize = document.getElementById('maxFileSize').value;
	const videoId = document.getElementById('videoId').value;

	const form = document.getElementById('uploadVideoForm');
	const btn = document.getElementById('uploadBtn');
	

	if (fileName === targetFileName)
	{
		if (event.target.files[0].size > maxFileSize)
		{
			const maxFileSizeInMb = maxFileSize/1000000 + 'MB';
			alert('Max file size: ' + maxFileSizeInMb);	
			const para = document.createElement('p');
			para.setAttribute('class', 'error');
			para.appendChild(document.createTextNode('Max. file size: ' + maxFileSizeInMb));
			form.insertBefore(para, document.getElementById('uploadBtn'));
		}
		else
		{
			btn.removeAttribute('disabled');
		}
	}
	else
	{
		alert('Wrong file selected. Please follow the instructions!');
		const para = document.createElement('p');
		para.setAttribute('class', 'error');
		para.appendChild(document.createTextNode('Wrong file selected. Please follow the instructions!'));
		form.insertBefore(para, document.getElementById('uploadBtn'));

		if (!btn.hasAttribute('disabled'))
		{
			btn.setAttribute('disabled', 'disabled');
		}
	}
};