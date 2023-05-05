import { googleApiKey } from './config.js';


// Global variables
const youtubeApiUrl = 'https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest';
const BASE_URL = 'http://localhost/spotube/';


const initGapiClient = async () => {
	const response = await gapi.client.init({ 'apiKey': googleApiKey });
	return response;
};

const loadGapiClient = async () => {
	const response = await gapi.client.load(youtubeApiUrl);
	return response;
};

const loadGapi = (cb) => {
	// Load Google API, then run callback fn
	gapi.load('client', () => {
		initGapiClient()
			.then(loadGapiClient())
				.then(cb);
	});
};

const getDataFromServer = async (url) => {
		const response = await fetch(url);
		const jsonData = await response.json();
		return jsonData;
};

const sendDataToServer= async (data, url) => {
	let params = {
			method: 'POST',
			headers: {
  			'Content-Type': 'application/json; charset=utf-8'
			},
			body: JSON.stringify(data)
	};

	const response = await fetch(url, params);
	return response;
};

const createVideosArrayFromGapiResponse = (response) => {
	// create videos array from response object
	// each item in array will have an id, title and thumbnails

	const filteredResp = response.result.items.filter(item => item.id.videoId !== undefined);

	const videos = filteredResp.map(item => {
		return {
			id: item.id.videoId,
			title: item.snippet.title,
		};
	});
	
	return videos;
};

const getVideosFromGapi = async (searchQuery) => {
	const response = await gapi.client.youtube.search.list({
		'part': [ 'snippet' ],
		'maxResults': 10,
		'q': searchQuery
	});

	const videos = createVideosArrayFromGapiResponse(response);

	return videos;
};

const decodeHTMLEntities = (str) => {

	const element = document.createElement('div');

	if(str && typeof str === 'string') 
	{
	  // strip script/html tags
	  str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
	  str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
	  element.innerHTML = str;
	  str = element.textContent;
	}

	element.remove();

	return str;
};

const getValueFromElement = (element) => {
		return element.value;
};

const removeFirstChildFromParent = (htmlParentNode) => {
	if (htmlParentNode.childElementCount > 0)
	{
		htmlParentNode.removeChild(htmlParentNode.firstElementChild);
	}
	return htmlParentNode;
};

const removeChildrenFromParent = (htmlParentNode) => {
	while (htmlParentNode.childElementCount > 0)
	{
		htmlParentNode = removeFirstChildFromParent(htmlParentNode);
	}
};

const displayVideosForGuests = (videos) => {

	const wrapper = document.getElementById('videos');

	for (let video of videos)
	{
		const div = document.createElement('div');
		div.setAttribute('class', 'video');

		const img = document.createElement('img');
		img.setAttribute('src', `https://i.ytimg.com/vi/${video['id']}/mqdefault.jpg`);
		img.style.opacity = video['uploaded_by'] === null ? 0.5 : 1;

		const p = document.createElement('p');
		const title = decodeHTMLEntities(video['title']);
		p.appendChild(document.createTextNode(title));

		div.appendChild(img);
		div.appendChild(p);

		if (video['uploaded_by'] === null)
		{
			const unavailable = document.createElement('div');
			unavailable.setAttribute('class', 'unavailable');

			const span = document.createElement('span');
			span.appendChild(document.createTextNode('Members Only'))

			unavailable.appendChild(span);
			div.appendChild(unavailable);
		}

		div.addEventListener('click', () => {

			if (video['uploaded_by'] === null)
			{
				alert('Sorry, you need to sign in to watch this video');
			}
			else
			{
				window.location.href = BASE_URL + `watch.php?v=${video['id']}`;
			}
		});

		wrapper.appendChild(div);
	}
};

const displayNVideosForGuests = (n, exclude=' ') => {
	getDataFromServer(`php/get_videos.php?count=${n}&exclude=${exclude}`)
		.then(
			response => displayVideosForGuests(response), 
			error => console.log('error', error)
	);
};


export {
	BASE_URL,
	loadGapi,
	getDataFromServer,
	sendDataToServer,
	createVideosArrayFromGapiResponse,
	getVideosFromGapi,
	decodeHTMLEntities,
	getValueFromElement,
	removeFirstChildFromParent,
	removeChildrenFromParent,
	initGapiClient,
	loadGapiClient,
	displayVideosForGuests,
	displayNVideosForGuests,
};