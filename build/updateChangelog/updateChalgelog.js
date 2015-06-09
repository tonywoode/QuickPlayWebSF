/**
We use the changelog and version info produced via git of the lastest quickplay changes,
 we produce an html update of those changes for the sourceforge website
*/
var file 		= require('fs')
var mysql     	= require('mysql');
var execFile 	= require('child_process').execFile;
var optipng 	= require('pandoc-bin').path;
var prompt  	= require('prompt');

var config	  	= require('../../../secrets/config');
var changelogLF	='../../../../Release/changelogLF';
var argsToPandoc = ['-f', 'markdown', '-t', 'html', changelogLF]; //,'-o', 'changelogHTML']
var decision;

var connection = mysql.createConnection({
    host        :   config.localdb.host,
    user        :   config.localdb.user,
    password    :   config.localdb.password,
    port        :   config.localdb.port,
    database    :   config.localdb.database
});

function printWhatWeStartWith (callback) {	
	console.log('existing text:');
	var changelog = file.readFileSync(changelogLF);
	console.log('' + changelog);
	callback();

}

printWhatWeStartWith(function(callback){ 
       var answer = yesorno(function(){
            pandocIt(answer);
        });
       
});

function yesorno (next) {
	prompt.start();
	prompt.colors = false;
	var property = {
	  name: 'yesno',
	  message: 'are you sure?',
	  validator: /y[es]*|n[o]?/,
	  warning: 'Must respond yes or no',
	  default: 'no'
	};

	// Get the yes or no property
	prompt.get(property, function (err, result) {
	  // Log the results.
	  console.log('  result: ' + result.yesno);
	  decision = result.yesno;
	  next(result);
	});

}

function pandocIt (answer) {	
	if ( decision==='y' ) {
		execFile(optipng, argsToPandoc, function (err, stdout, stderr) {
		    console.log(stdout);
		    if ( err ) { console.log(err); } //else prints null
		    console.log(stderr);
		});
	
	}

}


