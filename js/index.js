import {
	loadGapi,
	displayNVideos,

} from './helper_functions.js';

import { Logo } from './logo.component.js';
import { SearchBar } from './searchBar.component.js';
import { SignIn } from './signIn.component.js';

const main = () => {

	const isMember = 0;
	const nVideos = calcVideosToDisplay();

	const videosDownloaded = document.getElementById('videosDownloaded');
	const downloadedVideos = document.createElement('div');
	downloadedVideos.setAttribute('class', 'videos');
	videosDownloaded.appendChild(downloadedVideos);
	displayNVideos(nVideos, downloadedVideos, isMember, 1);

	const videosNotDownloaded = document.getElementById('videosNotDownloaded');
	const notDownloadedVideos = document.createElement('div');
	notDownloadedVideos.setAttribute('class', 'videos');
	videosNotDownloaded.appendChild(notDownloadedVideos);
	displayNVideos(nVideos, notDownloadedVideos, isMember, 0);

	SearchBar(isMember, downloadedVideos, notDownloadedVideos);

	Logo();

	SignIn();
};

loadGapi(main);

const calcVideosToDisplay = () => {

	const width = window.screen.width;

	if (width >= 1500) { return 12; }

	if (width >= 768) { return 6; }

	return 3;
}