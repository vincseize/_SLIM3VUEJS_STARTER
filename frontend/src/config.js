// Local config
// TODO: extract this in the project root's config file (but how?)

const projectRootPath = '_SLIM3VUEJS_STARTER';

export default {
    appVersion: `0.1.0`,
    baseUrl: process.env.NODE_ENV === 'production' ? `/${projectRootPath}/frontend` : '/',
    apiUrl: `http://localhost/${projectRootPath}/frontend/api`
};
