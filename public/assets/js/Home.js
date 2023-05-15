/**
 * Home.js
 * 
 * Handles JavaScript on the Home Page.
 */

import { SITE_URL } from './config.js';

import {
	loadGapi,
	calcVideoCountPerSection,
	getDataFromServer,
	sendDataToServer,
} from './helpers.js';

/**
 * The main function
 */
const Home = () => {

	const isUserSignedIn = getSignedInStatus();

	// const uploadedVideos = getUploadedVideos();

	// const notUploadedVideos = getNotUploadedVideos();

	// console.log( 'uploadedVideos', uploadedVideos );
	// console.log( 'notUploadedVideos', notUploadedVideos );

	getUploadedVideos();

};

/**
 * Gets user's signed in status.
 * 
 * @return boolean Returns true if user is signed in, or false otherwise.
 */
const getSignedInStatus = () => {

	const body = document.querySelector( 'body' );

	return body.dataset.isUserSignedIn === '1' ? true : false;
}

const getUploadedVideos = () => {

	const maxVideosToDisplay = calcVideoCountPerSection();

	const requestData = {
		'get_videos': {
			'max_results': maxVideosToDisplay,
			'uploaded': true,
		},
	};

	sendDataToServer( requestData, `${SITE_URL}` )
		.then(response => console.log(response), err => console.log(err));

}

loadGapi(Home);