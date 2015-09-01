var prompt     = require('prompt');

var downloadURL = '',
		filesize = '';

module.exports = function(callback) {
	prompt.start();
	prompt.message = 'Enter the new QuickPlay'.green;
	prompt.delimiter = ' '.green;
	prompt.colors = false;
	/*async-101: prompt is invoking the function just as we're doing on line 20, that's how it provides
	so it inverts the normal control flow. result isn't an input, but an OUTPUT from prompt.get
	*/
	prompt.get(schema, function (err, result) {
	    console.log('Command-line input received:');
		console.log('  downloadURL: ' 	+ result.downloadURL);
		downloadURL = result.downloadURL;
		console.log('  filesize: ' 		+ result.filesize);
		filesize = result.filesize;
		callback(result);
	  });

}

var schema = {
	properties: {
		downloadURL: {
       		type: 'string',
       		message: 'must be a string'
		},
		filesize: {
       		type: 'string',
       		message: 'must be a string'
		}
	}
};




