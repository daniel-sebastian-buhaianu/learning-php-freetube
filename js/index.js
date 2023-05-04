// import {
// 	getValueFromElement,
// 	memoizeSearchVideos,
// 	removeFirstChildFromParent,
// 	displayVideos,
// 	initGapiClient,
// 	loadGapiClient,

// } from './helper_functions.js';


// // Main
// const applyJS = () => {

// 	const handleSearch = (searchFunc) => {
// 		const searchQuery = getValueFromElement(document.getElementById('search_query'));
		
// 		searchFunc(searchQuery, 'php/get_yt_videos.php').then(videos => {
			
// 			const divWrapper = document.getElementById('search_results');
// 			removeFirstChildFromParent(divWrapper);
// 			displayVideos(videos, divWrapper, false);

// 			const cardBtns = document.getElementsByClassName('card_btn');
// 			for (let btn of cardBtns)
// 			{
// 				btn.addEventListener('click', () => alert('To download videos, you need to log in.'));
// 			}
// 		});


// 	};

// 	const handleCardBtnClick = (event) => {
// 		alert('To download any video, please log in.');
// 	}

// 	const addEventListeners = () => {

// 		const searchFunc = memoizeSearchVideos();
// 		document.getElementById('search_btn').addEventListener('click', () => handleSearch(searchFunc));
		
// 		document.getElementById('search_query').addEventListener('keydown', (event) => {
// 		if (event.keyCode === 13)
// 		{
// 			return handleSearch(searchFunc);
// 		}
// 	});

		

// 	}

// 	addEventListeners();	

// };

// gapi.load('client', () => {
// 	initGapiClient()
// 		.then(loadGapiClient())
// 			.then(applyJS);
// })

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

getDataFromServer('php/get_videos.php?fromId=1&count=3')
	.then(
		response => displayVideos(response), 
		error => console.log('error', error)
	);