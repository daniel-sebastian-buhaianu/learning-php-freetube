import { Logo } from './logo.component.js';
import { Videos } from './videos.component.js';

const main = () => {

	const isMember = 1;

	Videos({ id: 'playlist', playlistName: 'My Playlist'});

	Logo();
};

main();