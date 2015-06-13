/**
We use the changelog and version info produced via git of the lastest quickplay changes,
 we produce an html update of those changes for the sourceforge website
*/
var fs 			= require('fs'),
	execFile 	= require('child_process').execFile,
	optipng 	= require('pandoc-bin').path,	
	getVersion = require( '' + __dirname + '/getVersion'),
	version    = getVersion(),
	tony		= 5, //my id in the qp database
	date 		= new Date().toISOString().slice(0, 10).replace('T', ' '),
	//interestingly, though require is rooted in this file's dir, fs appears rooted in the callers dir one level up
	changeText = fs.readFileSync('updateChangelogAndVersion/changelogHTML', 'ascii'),
	//so this is rooted in the js scripts folder:
  	prompt  	= require('prompt'),
   	//whilst this is rooted in the build folder (parent):
	changelogLF	= '../../../Release/changelogLF',
	argsToPandoc = ['-f', 'markdown', '-t', 'html', changelogLF]; //,'-o', 'changelogHTML']
	connection  = require('./dbConnect');

printWhatWeStartWith(function(callback){ 
       yesorno(function(answer){
            pandocIt(answer, function() {
            	insertChangelog(date, getVersion(), changeText, tony);
            });
        });
       
});

function printWhatWeStartWith (callback) {	
	console.log('Here\'s the text pulled earlier:');
	var changelog = fs.readFileSync(changelogLF);
	console.log('' + changelog);
	callback();

}

function yesorno (next) { //next holds the address of the fucntion i declared on line 33
	// dbc - assert everything is okay before the real work starts
	if (typeof next !== 'function' && next.length !== 1)
		throw new Error('next must be a function that takes 1 argument');

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
	  next(result.yesno);
	});

}

function pandocIt (doItOrNot, next) {	
	if ( doItOrNot==='y' ) {
		execFile(optipng, argsToPandoc, function (err, stdout, stderr) {
		    console.log(stdout);
		    if ( err ) { console.log(err); } //else prints null
		    console.log(stderr);
		    if ( !err ) { next(); } //heres the callback....
		});
	
	}

}

//insert values for the next tuple - primary key id in the table auto-increments
function insertChangelog(date_posted, version, changelog, author_id) {
	connection.query('INSERT INTO changes (date_posted, title, changes, author_id) values ("'+date_posted+'", "'+version+'", "'+changelog+'", "'+author_id+'")',
		function (error, results, fields) {
        if (error) { console.log('ERRORS=', error); }
        if (results) { console.log('RESULTS=', results); }
        if (fields) { console.log('FIELDS=', fields); }
        connection.end(); //todo: move
    });

}


