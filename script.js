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


	const displaySearchResult = (result) => {

		// store result in an array
		// each item in array will have an id, title and thumbnails
		const searchResult = result.items.map(item => {
			return {
				id: item.id.videoId,
				title: item.snippet.title,
				thumbnails: item.snippet.thumbnails
			};
		});

		console.log(searchResult);
	};

	const getSearchResult = () => {

		const search_query = document.getElementById('search_query').value;

		// search youtube videos and display 6 results 
		gapi.client.youtube.search.list({
			'part': [ 'snippet' ],
			'maxResults': 6,
			'q': search_query
		}).then(response => displaySearchResult(response.result), error => displayError(error));
	};

	document.getElementById('search_btn').addEventListener('click', getSearchResult);
};


// load google's youtube api
// if succesful -> start app, otherwise -> stop app
gapi.load('client', () => {
	gapi.client.init({ 'apiKey': googleApiKey })
		.then(
			response => gapi.client.load(youtubeApiUrl).then(startApp, displayError),
			error => displayError(error));
});