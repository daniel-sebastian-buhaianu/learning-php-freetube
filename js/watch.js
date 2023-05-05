import {
	loadGapi, 
	displayNVideosForGuests,

} from './helper_functions.js';

import { Logo } from './logo.component.js';
import { SearchBar } from './searchBar.component.js';
import { SignIn } from './signIn.component.js';

const main = () => {

	const video = document.getElementById('video');
	const videoId = video.dataset.videoId;
	displayNVideosForGuests(10, videoId);

	SearchBar();

	Logo();

	SignIn();
};

loadGapi(main);