import {
	loadGapi,
	displayNVideos,
	calcVideosToDisplay

} from './helper_functions.js';

import { Videos } from './videos.component.js';
import { Logo } from './logo.component.js';
import { SearchBar } from './searchBar.component.js';
import { SignIn } from './signIn.component.js';

const main = () => {

	const isMember = 1;
	const nVideos = calcVideosToDisplay();

	const downloaded = Videos({ id: 'videosDownloaded', count: nVideos, isMember: isMember, isUploaded: 1});
	const notDownloaded = Videos({ id: 'videosNotDownloaded', count: nVideos, isMember: isMember, isUploaded: 0});

	SearchBar(isMember, downloaded, notDownloaded);

	Logo();
};

loadGapi(main);