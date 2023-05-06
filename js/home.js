import {
	loadGapi,
	displayNVideos,

} from './helper_functions.js';

import { Logo } from './logo.component.js';
import { SearchBar } from './searchBar.component.js';
import { SignIn } from './signIn.component.js';

const main = () => {

	const videosDownloaded = document.getElementById('videosDownloaded');
	const downloadedVideos = document.createElement('div');
	downloadedVideos.setAttribute('class', 'videos');
	videosDownloaded.appendChild(downloadedVideos);
	displayNVideos(5, downloadedVideos, 1, 1);

	const videosNotDownloaded = document.getElementById('videosNotDownloaded');
	const notDownloadedVideos = document.createElement('div');
	notDownloadedVideos.setAttribute('class', 'videos');
	videosNotDownloaded.appendChild(notDownloadedVideos);
	displayNVideos(5, notDownloadedVideos, 1, 0);

	SearchBar(1, downloadedVideos, notDownloadedVideos);

	Logo();
};

loadGapi(main);