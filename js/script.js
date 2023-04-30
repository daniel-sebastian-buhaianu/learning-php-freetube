import { googleApiKey } from './config.js';

// Global variables
const youtubeApiUrl = 'https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest';


// provides error feedback
const displayError = (error) => {
	alert('Error!');
	console.log(error);
};

// main function
const startApp = () => {

	const getDataFromServer = async (url) => {
		const response = await fetch(url);
		console.log('getDataFromServer response', response);
		const jsonData = await response.json();
		console.log('getDataFromServer response.json()', jsonData);
	};

	const sendDataToServer= async (data, url) => {
		let params = {
   			method: "POST",
   			headers: {
      			"Content-Type": "application/json; charset=utf-8"
   			},
   			body: JSON.stringify(data)
		};

		const response = await fetch(url, params);
		console.log('sendDataToServer response', response);
	};

	const createVideosArray = (response) => {
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

	const getSearchResult = async (searchQuery) => {
		// search youtube videos and display 6 results 
		const response = await gapi.client.youtube.search.list({
			'part': [ 'snippet' ],
			'maxResults': 6,
			'q': searchQuery
		});
		console.log('getSearchResult response', response);
	};

	const getSearchQueryValue = () => {
		return document.getElementById('search_query').value;
	}

	const handleSearchBtnClick = () => {
		const searchQuery = getSearchQueryValue();
		
		getDataFromServer(`php/get_videos.php?search_query=${searchQuery}`);
	};

	document.getElementById('search_btn')
		.addEventListener('click', handleSearchBtnClick);
};


// load google's youtube api
// if succesful -> start app, otherwise -> stop app
gapi.load('client', () => {
	gapi.client.init({ 'apiKey': googleApiKey })
		.then(
			response => gapi.client.load(youtubeApiUrl).then(startApp, displayError),
			error => displayError(error));
});