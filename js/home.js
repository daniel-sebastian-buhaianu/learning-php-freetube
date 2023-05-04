import {
	getValueFromElement,
	memoizeSearchVideos,
	removeFirstChildFromParent,
	displayVideos,
	initGapiClient,
	loadGapiClient,

} from './helper_functions.js';


// Main
const applyJS = () => {

	const handleSearch = (searchFunc) => {
		const searchQuery = getValueFromElement(document.getElementById('search_query'));
		
		searchFunc(searchQuery, 'php/get_yt_videos.php').then(videos => {
			
			const divWrapper = document.getElementById('search_results');
			removeFirstChildFromParent(divWrapper);
			displayVideos(videos, divWrapper);

			const cardBtns = document.getElementsByClassName('card_btn');
			let i = 0;
			for (let btn of cardBtns)
			{
				const windowLocation = `upload.php?videoId=${videos[i]['yt_id']}`;
				btn.addEventListener('click', () => {
					window.location = windowLocation;
				});

				i++;
			}
		});


	};

	const addEventListeners = () => {

		const searchFunc = memoizeSearchVideos();
		document.getElementById('search_btn').addEventListener('click', () => handleSearch(searchFunc));
		
		document.getElementById('search_query').addEventListener('keydown', (event) => {
		if (event.keyCode === 13)
		{
			return handleSearch(searchFunc);
		}
	});

		

	}

	addEventListeners();	

};

gapi.load('client', () => {
	initGapiClient()
		.then(loadGapiClient())
			.then(applyJS);
})