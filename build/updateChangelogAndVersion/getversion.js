var fs			= require('fs');

module.exports = function() {
	var filename  = '../../../QuickPlayFrontend/Version.txt';
	var pattern = new RegExp(/^THISVERSION=v(.*)/);
	var text = fs.readFileSync(filename, 'ascii');
	var match = text.match(pattern);
	var version = (match[1]);
	return version;

}


