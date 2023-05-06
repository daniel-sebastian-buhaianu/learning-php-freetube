import {
	loadGapi,
	displayNVideos,

} from './helper_functions.js';

import { Logo } from './logo.component.js';
import { SearchBar } from './searchBar.component.js';
import { SignIn } from './signIn.component.js';

const main = () => {

	const isMember = 1;

	const videosDownloaded = document.getElementById('videosDownloaded');
	const downloadedVideos = document.createElement('div');
	downloadedVideos.setAttribute('class', 'videos');
	videosDownloaded.appendChild(downloadedVideos);
	displayNVideos(5, downloadedVideos, isMember, 1);

	const videosNotDownloaded = document.getElementById('videosNotDownloaded');
	const notDownloadedVideos = document.createElement('div');
	notDownloadedVideos.setAttribute('class', 'videos');
	videosNotDownloaded.appendChild(notDownloadedVideos);
	displayNVideos(5, notDownloadedVideos, isMember, 0);

	SearchBar(isMember, downloadedVideos, notDownloadedVideos);

	Logo();
};

loadGapi(main);