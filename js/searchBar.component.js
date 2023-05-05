import {
	getVideosFromGapi,
	getValueFromElement,
	sendDataToServer,
	removeChildrenFromParent,
	displayVideosForGuests,
} from './helper_functions.js';

const memoizeSearchVideos = () => {

	return async (searchQuery) => {

		if (window.localStorage.getItem(`freetube_searchQuery_${searchQuery}`) !== null)
		{
			return {
				'videos': JSON.parse(window.localStorage.getItem(`freetube_searchQuery_${searchQuery}`)),
				'source': 'cache'
			}
		}
		else
		{
			return getVideosFromGapi(searchQuery)
				.then(videos => {
					return {
						'videos': videos,
						'source': 'gapi'
					};
				});
		}
	};
};

const handleSearch = (searchFunc) => {

	const searchQuery = getValueFromElement(document.getElementById('searchBar'));
	searchFunc(searchQuery)
		.then(
			response => {
				if (response['source'] === 'gapi')
				{
					sendDataToServer(response['videos'], `php/add_yt_videos.php`)
						.then(response => response.json(), error => console.log('sendDataToServer err', error))
							.then (videos => {
								window.localStorage.setItem(`freetube_searchQuery_${searchQuery}`, JSON.stringify(videos));
								removeChildrenFromParent(document.getElementById('videos'));
								displayVideosForGuests(videos);

							}, error => console.log('response.json() err', error));

				}
				else if (response['source'] === 'cache')
				{
					removeChildrenFromParent(document.getElementById('videos'));
					displayVideosForGuests(response['videos']);
				}
			}, 
			error => console.log('searchFunc err', error));
};

const SearchBar = () => {

	const searchFunc = memoizeSearchVideos();
	document.getElementById('searchBtn').addEventListener('click', () => handleSearch(searchFunc));
	document.getElementById('searchBar').addEventListener('keydown', (event) => {
		if (event.keyCode === 13)
		{
			return handleSearch(searchFunc);
		}
	});

};

export { SearchBar }; 