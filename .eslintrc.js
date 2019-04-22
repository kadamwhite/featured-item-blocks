module.exports = {
	'extends': [
		'humanmade',
	],
	'settings': {
		// Tell eslint-plugin-react which version of React is in use. Current as of WordPress 5.1.
		'react': {
			'version': '16.6.3',
		},
	},
	'rules': {
		'react/react-in-jsx-scope': [ 'off' ],
		'space-before-function-paren': [ 'error', {
			'anonymous': 'never',
			'named': 'never',
			'asyncArrow': 'always',
		} ],
	},
	'globals': {
		'wp': true,
	},
};
