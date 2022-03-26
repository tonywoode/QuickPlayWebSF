/**
  * We use the changelog and version info produced via git of the lastest quickplay changes,
  * we produce an html update of those changes for the sourceforge website
  */
var fs = require('fs'),
  execFile = require('child_process').execFile,
  optipng	= require('pandoc-bin').path,
  connection = require('./dbConnect'),
  /*
   * In Node, __dirname is always the dir in which the currently executing script resides. 
   * In other words, you typed __dirname into one of your script files and value would be 
   * that file's directory. By contrast, . gives you the directory from which you ran the 
   * node command in your terminal window (i.e. your working directory). 
   * The exception is when you use . with require(), in which case it acts like __dirname.
   * so whilst require is rooted in this file's dir, fs appears rooted in the callers dir one level up
   * so this is rooted in the js scripts folder:
  */
  prompt  	= require('prompt'),

  //whilst these are rooted in the build folder (parent):
  changelogLF	= '../../../Release/changelogLF',
  changelogHTML = '../../../Release/changelogHTML',

  //...we can do this to avoid this ambiguity, but its a little ugly
  getVersion = require( '' + __dirname + '/getVersion'),

  version    = getVersion(),
  argsToPandoc = ['-f', 'markdown', '-t', 'html', changelogLF,'-o', changelogHTML],

  date 		= new Date().toISOString().slice(0, 10).replace('T', ' '),

  //my id in the qp database
  tony		= 5; 

printWhatWeStartWith(function(callback){ 
  yesorno(function(answer){
    pandocIt(answer, function() {
      const changeText = fs.readFileSync(changelogHTML, 'ascii') //bugfix: we were reading this too early hence inserting previous change text 
      insertChangelog(date, getVersion(), changeText, tony);
    });
  });
});

function printWhatWeStartWith (callback) {	
  console.log('Updating changelog for ' + version + ': Here\'s the text pulled earlier:');
  var changelog = fs.readFileSync(changelogLF);
  console.log('' + changelog);
  callback();
}

function yesorno (next) { //next holds the address of the function i declared in yesorno's callsite currently on line 37
  // dbc - assert everything is okay before the real work starts
  if (typeof next !== 'function' && next.length !== 1) {
    throw new Error('next must be a function that takes 1 argument');
  }
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
  if ( doItOrNot==='y'||'yes' ) {
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
  //need to escape any potential doublequotes in the html - id/classnames
  const stringSafeChangelog = changelog.replace(/"/g,`\\"`)
  connection.query('INSERT INTO changes (date_posted, title, changes, author_id) values ("'+date_posted+'", "'+version+'", "'+stringSafeChangelog+'", "'+author_id+'")',
  function (error, results, fields) {
  if (error) { console.log('ERRORS=', error); }
  if (results) { console.log('RESULTS=', results); }
  if (fields) { console.log('FIELDS=', fields); }
  });

  connection.query('INSERT INTO news (date_posted, title, news, author_id) values ("'+date_posted+'", "QuickPlay '+version+' is released", "'+stringSafeChangelog+'", "'+author_id+'")',
  function (error, results, fields) {
    if (error) { console.log('ERRORS=', error); }
    if (results) { console.log('RESULTS=', results); }
    if (fields) { console.log('FIELDS=', fields); }

    connection.end(); //todo: move
  });
}

