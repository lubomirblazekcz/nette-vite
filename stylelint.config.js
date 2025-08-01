/** @type {import('stylelint').Config} */
export default {
  extends: [
    '@stylistic/stylelint-config',
    'stylelint-config-standard',
  ],
  rules: {
    'at-rule-no-unknown': [true, { ignoreAtRules: ['layer', 'tailwind', 'theme', 'utility', 'variant', 'custom-variant', 'source'] }],
    'alpha-value-notation': ['percentage'],
    'import-notation': 'string',
  },
  ignoreFiles: ['www/assets/**', 'vendor/**'],
}
