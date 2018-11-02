// Ported from eslint-config-humanmade; can update to 0.6.0 once released
module.exports = {
	'root': true,
	'env': {
		'browser': true,
		'es6': true,
	},
	'extends': [
		'eslint:recommended',
		'react-app',
	],
	'parserOptions': {
		'ecmaVersion': 2018,
		'ecmaFeatures': {
			'jsx': true,
		},
		'sourceType': 'module',
	},
	'rules': {
		'array-bracket-spacing': [ 'error', 'always' ],
		'arrow-parens': [ 'error', 'as-needed' ],
		'arrow-spacing': [ 'error', {
			'before': true,
			'after': true,
		} ],
		'block-spacing': [ 'error' ],
		'brace-style': [ 'error', '1tbs' ],
		'comma-dangle': [ 'error', 'always-multiline' ],
		'comma-spacing': [ 'error', {
			'before': false,
			'after': true,
		} ],
		'eol-last': [ 'error', 'unix' ],
		'eqeqeq': [ 'error' ],
		'func-call-spacing': [ 'error' ],
		'indent': [ 'error', 'tab', {
			'SwitchCase': 1,
		} ],
		'key-spacing': [ 'error', {
			'beforeColon': false,
			'afterColon': true,
		} ],
		'keyword-spacing': [ 'error', {
			'after': true,
			'before': true,
		} ],
		'linebreak-style': [ 'error', 'unix' ],
		'no-console': [ 'warn' ],
		'no-mixed-spaces-and-tabs': [ 'error', 'smart-tabs' ],
		'no-multiple-empty-lines': [ 'warn', {
			'max': 1,
		} ],
		'no-trailing-spaces': [ 'error' ],
		'no-var': [ 'warn' ],
		'object-curly-newline': [ 'error', {
			'ObjectExpression': {
				'consistent': true,
				'minProperties': 2,
				'multiline': true,
			},
			'ObjectPattern': {
				'consistent': true,
				'multiline': true,
			},
			'ImportDeclaration': {
				'consistent': true,
				'multiline': true,
			},
			'ExportDeclaration': {
				'consistent': true,
				'minProperties': 2,
				'multiline': true,
			},
		} ],
		'object-curly-spacing': [ 'error', 'always' ],
		'object-property-newline': [ 'error' ],
		'quotes': [ 'error', 'single' ],
		'semi-spacing': [ 'error', {
			'before': false,
			'after': true,
		} ],
		'space-before-function-paren': [ 'error', {
			'anonymous': 'never',
			'asyncArrow': 'always',
			'named': 'never',
		} ],
		'space-in-parens': [ 'warn', 'always', {
			'exceptions': [ 'empty' ],
		} ],
		'space-unary-ops': [ 'error', {
			'words': true,
			'nonwords': false,
			'overrides': {
				'!': true,
			},
		} ],
		'yoda': [ 'error', 'never' ],
		'react/jsx-curly-spacing': [ 'error', 'always' ],
		'react/jsx-wrap-multilines': [ 'error' ],
		'jsx-a11y/anchor-is-valid': [ 'error' ],
		// href-no-hash has been removed from jsx-a11y: this line silences an error
		// caused by eslint-config-react-app still using the deprecated rule, and
		// can be removed once the react-app config is updated to a recent jsx-a11y.
		'jsx-a11y/href-no-hash': [ 'off' ],

		// Overrides and extensions of the HM config.
	  "no-debugger": "warn",
	  "react/react-in-jsx-scope": "off",
	},
};
