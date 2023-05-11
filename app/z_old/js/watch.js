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

	displayNVideos({n: 10, wrapper: videosSection, isMember: isMember, uploaded: isMember, exclude: videoId});

	SearchBar(isMember, null, null, true);

	Logo();

	SignIn();
};

loadGapi(main);