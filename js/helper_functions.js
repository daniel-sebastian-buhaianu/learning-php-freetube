import { googleApiKey } from './config.js';


// Global variables
const youtubeApiUrl = 'https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest';
const BASE_URL = 'http://localhost/freetube-web/';


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

const specialStrlen = (str) => {
	let strlen = 0;
	for (let i = 0; i < str.length; i++)
	{
		if (str[i] >= 'A' && str[i] <= 'Z' || "()_/\\%@$&[]".includes(str[i]))
		{
			strlen += 1.2;
		}
		else
		{
			strlen += 1;
		}
	}
	return Math.round(strlen);
}

const shortenVideoTitle = (title) => {
	const maxCharsPerLine = 30;
	const smallToBigRatio = 1.2;
	const words = title.split(' ');

	let firstLine = '';
	let secondLine = '';
	let charsPerLine = 0;
	let index = 0;
	while (charsPerLine < maxCharsPerLine && index < words.length)
	{
		const word = words[index];
		const wordLen = specialStrlen(word);

		if (charsPerLine + wordLen <= maxCharsPerLine)
		{
			firstLine += word + " ";
			charsPerLine += wordLen + 1;
			index++;
		}
		else
		{
			charsPerLine = maxCharsPerLine;
		}
	}
	
	charsPerLine = 0;
	while (charsPerLine < maxCharsPerLine && index < words.length)
	{
		const word = words[index];
		const wordLen = specialStrlen(word);

		if (charsPerLine + wordLen <= maxCharsPerLine)
		{
			secondLine += word + " ";
			charsPerLine += wordLen + 1;
			index++;
		}
		else
		{
			const maxCharsLeft = maxCharsPerLine - charsPerLine;
			switch (maxCharsLeft)
			{
				case 2:
				{
					let tmp = secondLine.slice(0, secondLine.length - 1);
					tmp += '...';
					secondLine = tmp;
					break;
				}

				case 1:
				{	
					let tmp = secondLine.slice(0, secondLine.length - 2);
					tmp += '...';
					secondLine = tmp;
					break;
				}

				case 0:
				{
					let tmp = secondLine.slice(0, secondLine.length - 3);
					tmp += '...';
					secondLine = tmp;
					break;
				}
				
				default:
					secondLine += '...';
					break;
			}

			charsPerLine = maxCharsPerLine;
		}
	}

	title = firstLine + secondLine;
	return title;
} 

const isUserDeviceMobile = () => {

	console.log('useragent', navigator.userAgent);
	
	if (navigator.userAgent.match(/Android/i)
	     || navigator.userAgent.match(/webOS/i)
	     || navigator.userAgent.match(/iPhone/i)
	     || navigator.userAgent.match(/iPad/i)
	     || navigator.userAgent.match(/iPod/i)
	     || navigator.userAgent.match(/BlackBerry/i)
	     || navigator.userAgent.match(/Windows Phone/i)) 
	{
		return true;
	}

	return false;
}

const displayVideos = (props) => {

	if (props.videos === undefined)
	{
		throw new Error('props.videos undefined in displayVideos');
		return;
	}

	if (props.wrapper === undefined)
	{
		throw new Error('props.wrapper undefined in displayVideos');
		return;
	}

	if (props.isMember === undefined)
	{
		props.isMember = 0;
	}

	if (props.addToPlaylistBtn === undefined)
	{
		props.addToPlaylistBtn = true;
	}

	const { videos, wrapper, isMember } = props;

	const createAddToPlaylistBtn = (video) => {

		if (video === undefined)
		{
			throw new Error('video is undefined in createAddToPlaylistBtn');
			return;
		}

		btn = document.createElement('button');
		btn.setAttribute('class', 'addToPlaylistBtn');
		btn.appendChild(document.createTextNode('+'));

		btn.addEventListener('click', (event) => {
			sendDataToServer(video['id'], `${BASE_URL}php/addVideoToPlaylist.php`)
				.then(response => response.json())
					.then(response => console.log('sendDataToServer response.json():', response));
		});	

		return btn;
	};

	const defaultVideoCardClickHandler = (event) => {

		if (!event.target.classList.contains('addToPlaylistBtn'))
			{
				if (video['uploaded_by'] === null)
				{
					if (!isMember)
					{
						alert('Sorry, you need to sign in to watch this video');
					}
					else if (isUserDeviceMobile())
					{
						alert('Sorry, you need a PC to download this video');
					}
					else
					{
						window.open(`https://www.ssyoutube.com/watch?v=${video['id']}`, '_saveFromNet').focus();
						window.location.href = BASE_URL + `upload.php?v=${video['id']}`;
					}
				}
				else
				{
					window.location.href = BASE_URL + `watch.php?v=${video['id']}`;
				}
			}
	};

	const createVideoCard = (video) => {

		const div = document.createElement('div');
		div.setAttribute('class', 'video');

		const img = document.createElement('img');
		img.style.opacity = video['uploaded_by'] === null ? 0.5 : 1;
		img.setAttribute('src', `https://i.ytimg.com/vi/${video['id']}/mqdefault.jpg`);

		const p = document.createElement('p');
		const title = decodeHTMLEntities(video['title']);
		p.appendChild(document.createTextNode(shortenVideoTitle(title)));

		div.appendChild(img);
		div.appendChild(p);

		if (video['uploaded_by'] === null)
		{
			const unavailable = document.createElement('div');
			unavailable.setAttribute('class', 'unavailable');

			const span = document.createElement('span');
			const spanText = isMember === 0 ? 'Members Only' : 'PC Download';
			span.appendChild(document.createTextNode(spanText))

			unavailable.appendChild(span);
			div.appendChild(unavailable);
		}

		div.addEventListener('click', (event) => 

		if (btn !== undefined)
		{
			

			
		}

		return div;
	};

	for (let video of videos)
	{
		wrapper.appendChild(createVideoCard(video));
	}
};

const displayNVideos = (props) => {

	if (props.isMember === undefined)
	{
		props.isMember = 0;
	}

	if (props.uploaded === undefined)
	{
		props.uploaded = null;
	}

	if (props.exclude === undefined)
	{
		props.exclude = '';
	}

	if (props.playlistName === undefined)
	{
		props.playlistName = null;
	}

	if (props.n === undefined)
	{
		props.n = 6;
	}

	if (props.wrapper === undefined)
	{
		throw new Error('displayNVideos wrapper property is missing');
		return;
	}

	const { n, wrapper, isMember, uploaded, exclude, playlistName } = props;

	getDataFromServer(`php/getVideos.php?count=${n}&exclude=${exclude}&uploaded=${uploaded}&playlistName=${playlistName}`)
		.then(
			response => displayVideos({ videos: response, wrapper: wrapper, isMember: isMember }), 
			error => console.log('getDataFromServer error', error)
	);
};

const calcVideosToDisplay = () => {

	const width = window.screen.width;

	if (width >= 1500) { return 12; }

	if (width >= 768) { return 6; }

	return 3;
}

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
	displayVideos,
	displayNVideos,
	calcVideosToDisplay,
};