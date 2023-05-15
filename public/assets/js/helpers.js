/**
 * helpers.js
 * 
 * Contains helper functions which can be used in other js files.
 */

import {
    GOOGLE_API_KEY,
    YOUTUBE_API_URL,
    SITE_URL,
    MAX_VIDEOS_PER_ROW,
    MAX_ROWS_PER_VIDEO_SECTION,
} from './config.js';


/**
 * Loads Google API, then runs a callback function.
 *
 * @return void
 */
const loadGapi = ( callbackFunc ) => {

    /**
     * Initializes google api client.
     * 
     * @return Promise Returns a Promise with a response/error.
     */
    const initGapiClient = async () => {

        return await gapi.client.init( { 'apiKey': GOOGLE_API_KEY } );
    };

    /**
     * Loads google api client.
     * 
     * @return Promise Returns a Promise with a response/error.
     */
    const loadGapiClient = async () => {

        return await gapi.client.load( YOUTUBE_API_URL );
    };

    gapi.load( 'client', () => {
        initGapiClient()
            .then( loadGapiClient() )
                .then( callbackFunc );
    });
};

/**
 * Calculates how many videos to display per video section.
 * 
 * @return int Number of videos to display.
 */
const calcVideoCountPerSection = () => {

    const width = window.screen.width;

    if ( width >= 1400 ) {

        return MAX_VIDEOS_PER_ROW['w_1400px'] * MAX_ROWS_PER_VIDEO_SECTION;
    }

    if ( width >= 1200 ) { 

        return MAX_VIDEOS_PER_ROW['w_1200px'] * MAX_ROWS_PER_VIDEO_SECTION; 
    }

    return MAX_VIDEOS_PER_ROW['w_992px'] * MAX_ROWS_PER_VIDEO_SECTION; 
};

/**
 * Makes a GET request to the server.
 * 
 * @param string url Server URL.
 * 
 * @return Promise Returns a Promise with a response/error.
 */
const getDataFromServer = async ( url ) => {
        
    const response = await fetch( url );
       
    return await response.json();        
};

/**
 * Makes a POST request with data to the server.
 * 
 * @param mixed data Data to be sent to the server.
 * 
 * @param string url Server URL.
 * 
 * @return Promise Returns a Promise with a response/error.
 */
const sendDataToServer= async ( data, url ) => {
    
    let params = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=utf-8'
            },
            body: JSON.stringify( data )
    };

    return await fetch( url, params );
};


export {
    loadGapi,
    calcVideoCountPerSection,
    getDataFromServer,
    sendDataToServer,
};