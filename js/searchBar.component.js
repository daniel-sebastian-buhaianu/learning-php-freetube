import {
	getVideosFromGapi,
	getValueFromElement,
	sendDataToServer,
	removeChildrenFromParent,
	displayVideos,
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


const createVideosSection = (sectionId, sectionHeadline) => {
	const section = document.createElement('section');
	section.setAttribute('id', sectionId);

	const headline = document.createElement('h3');
	headline.appendChild(document.createTextNode(sectionHeadline));

	const whereToDisplayVideos = document.createElement('div');
	whereToDisplayVideos.setAttribute('class', 'videos');

	section.appendChild(headline);
	section.appendChild(whereToDisplayVideos);

	return section;
}

const handleDisplayVideos = (videos, isMember, whereToDisplayDownloaded, whereToDisplayNotDownloaded, watchPage) => {

	if (watchPage)
	{
		document.getElementById('alsoLike').remove();
		document.getElementById('videos').remove();

		const videosDownloadedSection = createVideosSection('videosDownloaded', 'Videos You Can Watch Now');
		whereToDisplayDownloaded = videosDownloadedSection.lastChild;

		const videosNotDownloadedSection = createVideosSection('videosNotDownloaded', 'Videos You Can Download');
		whereToDisplayNotDownloaded = videosNotDownloadedSection.lastChild;

		const mainElem = document.querySelector('main');
		mainElem.appendChild(videosDownloadedSection);
		mainElem.appendChild(videosNotDownloadedSection);
	}

	removeChildrenFromParent(whereToDisplayDownloaded);
	removeChildrenFromParent(whereToDisplayNotDownloaded);

	const downloadedVideos = videos.filter(video => video['uploaded_by'] !== null);
	const notDownloadedVideos = videos.filter(video => video['uploaded_by'] == null);

	if (downloadedVideos.length > 0)
	{
		displayVideos({videos: downloadedVideos, wrapper: whereToDisplayDownloaded, isMember: isMember});
		whereToDisplayDownloaded.parentNode.style.display = 'block';
	}
	else
	{
		whereToDisplayDownloaded.parentNode.style.display = 'none';
	}

	if (notDownloadedVideos.length > 0)
	{
		displayVideos({videos: notDownloadedVideos, wrapper: whereToDisplayNotDownloaded, isMember: isMember});
		whereToDisplayNotDownloaded.parentNode.style.display = 'block';
	}
	else
	{
		whereToDisplayNotDownloaded.parentNode.style.display = 'none';
	}
}

const handleSearch = (searchFunc, isMember, whereToDisplayDownloaded, whereToDisplayNotDownloaded, watchPage) => {

	const searchQuery = getValueFromElement(document.getElementById('searchBar'));
	searchFunc(searchQuery)
		.then(
			response => {
				if (response['source'] === 'gapi')
				{
					sendDataToServer(response['videos'], `php/addYoutubeVideos.php`)
						.then(response => response.json(), error => console.log('sendDataToServer err', error))
							.then (videos => {

								window.localStorage.setItem(`freetube_searchQuery_${searchQuery}`, JSON.stringify(videos));

								handleDisplayVideos(
									videos, 
									isMember, 
									whereToDisplayDownloaded, 
									whereToDisplayNotDownloaded, 
									watchPage
								);

							}, error => console.log('response.json() err', error));

				}
				else if (response['source'] === 'cache')
				{
					const videos = response['videos'];

					handleDisplayVideos(
									videos, 
									isMember, 
									whereToDisplayDownloaded, 
									whereToDisplayNotDownloaded, 
									watchPage
					);

				}
			}, 
			error => console.log('searchFunc err', error));
};

const SearchBar = (isMember, whereToDisplayDownloaded, whereToDisplayNotDownloaded, watchPage=false) => {

	const searchFunc = memoizeSearchVideos();

	document.getElementById('searchBtn')
		.addEventListener('click', () => handleSearch(
											searchFunc,
											isMember, 
											whereToDisplayDownloaded, 
											whereToDisplayNotDownloaded,
											watchPage,
		));

	document.getElementById('searchBar').addEventListener('keydown', (event) => {
		if (event.keyCode === 13)
		{
			return handleSearch(searchFunc, isMember, whereToDisplayDownloaded, whereToDisplayNotDownloaded, watchPage);
		}
	});

};

export { SearchBar }; 