import {
	loadGapi, 
	displayNVideos,

} from './helper_functions.js';

import { Logo } from './logo.component.js';
import { SearchBar } from './searchBar.component.js';
import { SignIn } from './signIn.component.js';

const main = () => {

	const videoSection= document.getElementById('video');
	const videoId = videoSection.dataset.videoId;

	const videosSection = document.getElementById('videos');
	const isMember = videosSection.dataset.isMember;

	displayNVideos(10, videosSection, isMember, isMember, videoId);

	SearchBar(isMember, null, null, true);

	Logo();

	SignIn();
};

loadGapi(main);