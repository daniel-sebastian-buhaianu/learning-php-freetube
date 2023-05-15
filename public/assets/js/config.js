import { googleApiKey } from './confidential.js';

/**
 * Constants
 */
const GOOGLE_API_KEY  = googleApiKey;

const YOUTUBE_API_URL = 'https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest';

const SITE_URL        = 'http://localhost/ftube/public';

/**
 * Maximum number of videos per row in a video section by screen width.
 */
const MAX_VIDEOS_PER_ROW = {
    'w_992px':  2,
    'w_1200px': 3,
    'w_1400px': 4,
};

/**
 * Maximum number of rows in a video section.
 */
const MAX_ROWS_PER_VIDEO_SECTION = 3;

export {
	GOOGLE_API_KEY,
	YOUTUBE_API_URL,
	SITE_URL,
    MAX_VIDEOS_PER_ROW,
    MAX_ROWS_PER_VIDEO_SECTION,
};