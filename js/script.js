import { googleApiKey } from './config.js';

// Global variables
const youtubeApiUrl = 'https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest';


// Main
const app = () => {

	const getDataFromServer = async (url) => {
		const response = await fetch(url);
		const jsonData = await response.json();
		return jsonData;
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
		return response;
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

	const getVideos = async (searchQuery) => {
		// search youtube videos and display 6 results 
		const response = await gapi.client.youtube.search.list({
			'part': [ 'snippet' ],
			'maxResults': 6,
			'q': searchQuery
		});
		return response;
	};

	const getSearchQueryValue = () => {
		return document.getElementById('search_query').value;
	}

	const displayVideos = (videos, htmlParentNode) => {

		if (videos.length === 0)
		{
			const p = document.createElement('p');
			const textNode = document.createTextNode('No results.');

			p.appendChild(textNode);
			htmlParentNode.appendChild(p);
		}
		else
		{
			const ol = document.createElement('ol');

			for (let video of videos)
			{
				const { id, title } = video;
				const li = document.createElement('li');
				const a = document.createElement('a');
				const textNode = document.createTextNode(title);

				a.setAttribute('href', `https://www.youtube.com/watch?v=${id}`);
				a.setAttribute('target', '_youtube');

				a.appendChild(textNode);
				li.appendChild(a);
				ol.appendChild(li);
			}

			htmlParentNode.appendChild(ol);
		}
	}

	const removeVideos = (htmlParentNode) => {
		if (htmlParentNode.childElementCount > 0)
		{
			htmlParentNode.removeChild(htmlParentNode.firstElementChild);
		}
	} 

	const memoizeSearch = () => {
			let cache = {};
			let previousQuery = null;

			return async (searchQuery) => {

				if (previousQuery !== searchQuery)
				{

					if (searchQuery in cache)
					{
						previousQuery = searchQuery;
						return cache[searchQuery];						
					}
					else
					{
						return getDataFromServer(`php/get_videos.php?search_query=${searchQuery}`)
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

	const handleSearch = (searchFunc) => {
		const searchQuery = getSearchQueryValue();
		
		searchFunc(searchQuery).then(videos => {
			const divWrapper = document.getElementById('search_results');
			removeVideos(divWrapper);
			displayVideos(videos, divWrapper);
		})
	};

	const searchFunc = memoizeSearch();

	document.getElementById('search_btn').addEventListener('click', () => handleSearch(searchFunc));

	document.getElementById('search_query').addEventListener('keydown', (event) => {
		if (event.keyCode === 13)
		{
			return handleSearch(searchFunc);
		}
	});
};

// Load YouTube API
gapi.load('client', () => {
	gapi.client.init({ 'apiKey': googleApiKey })
		.then(gapi.client.load(youtubeApiUrl))
			.then(app)
});