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

	const getDataFromServer = (url, func) => {
		fetch(url).then(
			response => {
				if (func)
				{
					func(response);
				}
				else
				{
					console.log('getDataFromServer', response);
				}
			},		
			error => displayError(error));
	};

	const sendDataToServer= (data, url, func) => {
		let params = {
   			method: "POST",
   			headers: {
      			"Content-Type": "application/json; charset=utf-8"
   			},
   			body: JSON.stringify(data)
		};

		fetch(url, params)
			.then(
				response => {
					if (func)
					{
						func(response);
					}
					else
					{
						console.log('sendDataToServer', response); 

					}
				},

				error => displayError(error));
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

	const getSearchResult = (search_query, func) => {
		// search youtube videos and display 6 results 
		gapi.client.youtube.search.list({
			'part': [ 'snippet' ],
			'maxResults': 6,
			'q': search_query
		}).then(
			response => {
				if (func)
				{
					func(response);
				}
				else
				{
					console.log('getSearchResult', response);
				}
			},
			error => displayError(error));
	};

	const handleSearchBtnClick = () => {
		console.log('search btn was clicked');
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