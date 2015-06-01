var prompt     = require('prompt');

var schema = {
	properties: {
		version_id: {
			type: 'number',
			message: 'must be a number'
		},
		version_name: {
			type: 'string',
			message: 'must be a string'
		},
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

prompt.start();
prompt.message = 'Enter the new QuickPlay'.green;
prompt.delimiter = ' '.green;
prompt.colors = false;
prompt.get(schema, function (err, result) {
    //
    // Log the results.
    //
    console.log('Command-line input received:');
	console.log('type of version_id is' + typeof result.version_id);
    console.log('  version_id: ' + result.version_id);
    console.log('  version_name: ' + result.version_name);
		console.log('  downloadURL: ' + result.downloadURL);
		console.log('  filesize: ' + result.filesize);
  });


