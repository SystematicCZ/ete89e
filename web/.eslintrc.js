module.exports = {
  "parserOptions": {
    "ecmaVersion": 2018
  },
  "extends": [
    "airbnb-base",
    "plugin:vue/recommended"
  ],
  "rules": {
    "no-prototype-builtins": "off",
    "no-underscore-dangle": "off",
    "object-curly-newline": "off",
    "no-param-reassign": [2, {
      "props": false
    }]
  }
};
