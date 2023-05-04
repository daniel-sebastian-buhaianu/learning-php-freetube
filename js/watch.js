import {
	getDataFromServer,
	decodeHTMLEntities,
} from './helper_functions.js';

const BASE_URL = 'http://localhost/spotube/';

const displayVideos = (videos) => {

	const wrapper = document.getElementById('videos');

	for (let video of videos)
	{
		const div = document.createElement('div');
		div.setAttribute('class', 'video');

		const img = document.createElement('img');
		img.setAttribute('src', `https://i.ytimg.com/vi/${video['yt_id']}/mqdefault.jpg`);

		const p = document.createElement('p');
		const title = decodeHTMLEntities(video['title']);
		p.appendChild(document.createTextNode(title));

		div.appendChild(img);
		div.appendChild(p);
		div.addEventListener('click', () => {
			window.location.href = BASE_URL + `watch.php?v=${video['id']}`;
		});
		wrapper.appendChild(div);
	}
}

const video = document.getElementById('video');
const videoId = video.dataset.videoId;
getDataFromServer(`php/get_videos.php?fromId=1&count=5&exclude=${videoId}`)
	.then(
		response => displayVideos(response), 
		error => console.log('error', error)
	);

const logo = document.getElementById('logo');
logo.addEventListener('click', () => {
	window.location.href = BASE_URL;
});