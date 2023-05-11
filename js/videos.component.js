import { displayNVideos } from './helper_functions.js';

const Videos = (props) => {

	const { id, count, isMember, isUploaded, playlistName } = props;

	const parent = document.getElementById(id);
	const child = document.createElement('div');
	child.setAttribute('class', 'videos');
	parent.appendChild(child);
	displayNVideos({n: count, wrapper: child, isMember: isMember, uploaded: isUploaded, playlistName: playlistName});

	return child;
};

export { Videos };