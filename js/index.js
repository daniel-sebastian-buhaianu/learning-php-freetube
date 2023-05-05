import {
	loadGapi,
	displayNVideosForGuests,

} from './helper_functions.js';

import { Logo } from './logo.component.js';
import { SearchBar } from './searchBar.component.js';
import { SignIn } from './signIn.component.js';

const main = () => {

	displayNVideosForGuests(10);

	SearchBar();

	Logo();

	SignIn();
};

loadGapi(main);