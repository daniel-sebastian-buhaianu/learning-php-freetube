import { googleApiKey } from './config.js';


// Global variables
const youtubeApiUrl = 'https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest';



const initGapiClient = async () => {
	const response = await gapi.client.init({ 'apiKey': googleApiKey });
	return response;
}

const loadGapiClient = async () => {
	const response = await gapi.client.load(youtubeApiUrl);
	return response;
}

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
	const videos = response.result.items.map(item => {
		return {
			id: item.id.videoId,
			title: item.snippet.title,
			thumbnails: item.snippet.thumbnails
		};
	});
	
	return videos;
};

const getVideosFromGapi = async (searchQuery) => {
	// search youtube videos and display 6 results 
	const response = await gapi.client.youtube.search.list({
		'part': [ 'snippet' ],
		'maxResults': 6,
		'q': searchQuery
	});
	return response;
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

const createVideoCard = (videoData, videoLink = 'https://www.ssyoutube.com/watch?v=') => {
	const { yt_id, thumbnails } = videoData;
	const title = decodeHTMLEntities(videoData['title']);
	const downloadVideoLink = videoLink + yt_id;

	const videoCard = createDivWithClass('video_card');

	const cardImg = createImgWithClass('card_image', thumbnails['medium']);

	const cardTitle = createParagraphWithText(title);
	cardTitle.setAttribute('class', 'card_title');

	const cardBtn = createATagWithClass('card_btn', downloadVideoLink, 'Download');
	cardBtn.setAttribute('target', '_sfn');

	videoCard.appendChild(cardImg);
	videoCard.appendChild(cardTitle);
	videoCard.appendChild(cardBtn);
	
	return videoCard;
};

const getValueFromElement = (element) => {
		return element.value;
};

const createParagraphWithText = (text) => {
	const p = document.createElement('p');
	const textNode = document.createTextNode(text);
	p.appendChild(textNode);

	return p;
};

const createDivWithClass = (className) => {
	const div = document.createElement('div');
	div.setAttribute('class', className);
	return div;
};

const createImgWithClass = (className, src) => {
	const img = document.createElement('img');
	img.setAttribute('class', className);
	img.setAttribute('src', src);
	return img;
};

const createButtonWithClass = (className, text) => {
	const btn = document.createElement('button');
	btn.setAttribute('class', className);
	btn.appendChild(document.createTextNode(text));
	return btn;
};

const createATagWithClass = (className, link, text) => {
	const aTag = document.createElement('a');
	aTag.setAttribute('class', className);
	aTag.setAttribute('href', link);
	aTag.appendChild(document.createTextNode(text));
	return aTag;
};


const displayVideos = (videos, htmlParentNode, clickable = true) => {

	if (videos.length === 0)
	{
		const p = createParagraphWithText('No results');
		htmlParentNode.appendChild(p);
	}
	else
	{
		const videoCards = createDivWithClass('video_cards');

		for (let video of videos)
		{
			const videoCard = clickable ? createVideoCard(video) : createVideoCard(video, '#');
			videoCards.appendChild(videoCard);
		}

		htmlParentNode.appendChild(videoCards);
	}
};

const removeFirstChildFromParent = (htmlParentNode) => {
	if (htmlParentNode.childElementCount > 0)
	{
		htmlParentNode.removeChild(htmlParentNode.firstElementChild);
	}
};

const memoizeSearchVideos = () => {
	let cache = {};
	let previousQuery = null;

	return async (searchQuery, pathToGetVideosHandler) => {

		if (previousQuery !== searchQuery)
		{

			if (searchQuery in cache)
			{
				previousQuery = searchQuery;
				return cache[searchQuery];						
			}
			else
			{
				return getDataFromServer(`${pathToGetVideosHandler}?search_query=${searchQuery}`)
					.then(videos => {
						cache[searchQuery] = videos;
						previousQuery = searchQuery;
						return videos;
					});
			}
		}
		else
		{
			return cache[previousQuery];
		}

		
	};
};

export {
	getDataFromServer,
	sendDataToServer,
	createVideosArrayFromGapiResponse,
	getVideosFromGapi,
	decodeHTMLEntities,
	createVideoCard,
	getValueFromElement,
	createParagraphWithText,
	createDivWithClass,
	displayVideos,
	removeFirstChildFromParent,
	memoizeSearchVideos,
	initGapiClient,
	loadGapiClient,
};