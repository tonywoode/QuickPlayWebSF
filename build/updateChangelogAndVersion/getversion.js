var fs			= require('fs');

module.exports = function() {
	var filename  = '../../../Release/Version.txt';
	var pattern = new RegExp(/^refs\/tags\/v(.*)/);
	var text = fs.readFileSync(filename, 'ascii');
	var match = text.match(pattern);
	var version = (match[1]);
	return version;

};



