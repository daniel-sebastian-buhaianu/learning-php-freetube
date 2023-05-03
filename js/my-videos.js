import {
	getDataFromServer,
	decodeHTMLEntities,
	createParagraphWithText,

} from './helper_functions.js';

const handleResponse = (response) => {
	const videos = response;

	const ol = document.getElementById('my_videos');

	videos.forEach(video => {

		const li = document.createElement('li');
		
		const title = decodeHTMLEntities(video['title']);
		const para = createParagraphWithText(title);

		const videoElem = document.createElement('video');
		videoElem.setAttribute('class', 'videos');
		videoElem.setAttribute('controls', 'controls');

		const source = document.createElement('source');
		source.setAttribute('src', `uploads/${video['id']}.mp4`);
		source.setAttribute('type', 'video/mp4');

		videoElem.appendChild(source);

		li.appendChild(para);
		li.appendChild(videoElem);

		ol.appendChild(li);
	});
};

const handleError = (error) => {
	console.log('err', error);
};

getDataFromServer('php/get_uploaded_videos.php').then(handleResponse, handleError);