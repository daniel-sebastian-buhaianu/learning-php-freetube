import { displayNVideos } from './helper_functions.js';

const Videos = (props) => {

	const { id, count, isMember, isUploaded } = props;

	const parent = document.getElementById(id);
	const child = document.createElement('div');
	child.setAttribute('class', 'videos');
	parent.appendChild(child);
	displayNVideos(count, child, isMember, isUploaded);

	return child;
};

export { Videos };