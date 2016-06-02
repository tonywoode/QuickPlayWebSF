/**
 * Reads the local copy of the qp database and updates QPVer
 */
var fs = require('fs'),
  connection = require('./dbConnect');

var versionName = process.env.version, //quickplay version number we're releasing
  qpZip = process.env.localZipFile,
  stats	= fs.statSync(qpZip),
  zipSizeInBytes = stats.size,
  filesize = Math.floor(zipSizeInBytes / 1000000) + 'MB',
  downloadURL = process.env.sfFileURL;

function updateQPVerManually() { 
  var prompt				= require('./userInput'),
    getVersion = require('./getVersion'),
    versionName = getVersion(), //to force return value not function itself
    downloadURl = result.downloadURL,
    filesize = result.filesize;
    console.log('Enter the details for Version ' + versionName); //force string return value not function code
}

//the callback we pass to connect runs after we connect, or fail to
connection.connect(function(err) {
  if (err) {
    console.error('error connecting: ' + err.stack);
   
    return;
  }
  console.log('connected as id ' + connection.threadId);
});

/*
 the anonymous function we just defined has the same signature as showTable,
 so we can just pass the reference to show table rather than defining an anonymous function
 you could just go prompt(showTable); you only need anonymous function if you're going to change 
 the signature or if there is no named function to invoke
 */

//prompt(function(result){ //if we make the manual update we'll need to add this to the flow
//async-101: we can't call insertRow serially after show table, or it'll run both at the same time
showTable(function() {
   insertRow(versionName, downloadURL, filesize);
}); //here's why we use promises, this could become the callback pyramid of doom

function showTable(next) {
  console.log('EXISTING VERSION TABLE FOLLOWS:');
  connection.query('select * from version', function (error, results, fields) {
    // error will be an Error if one occurred during the query
    if (error) { console.log('ERRORS=', error); }
    // results will contain the results of the query
    if (results) { console.log('RESULTS=', results); }
    // fields will contain information about the returned results fields (if any)
    if (fields) { console.log('FIELDS=', fields); }
    next(); //call next function async
  });
}

//insert values for the next tuple - primary key version_id in the table auto-increments
function insertRow(versionName, downloadURL, filesize) {
  connection.query('INSERT INTO version (versionName, download, filesize) values ("'+versionName+'","'+downloadURL+'", "'+filesize+'")',
  function (error, results, fields) {
    if (error) { console.log('ERRORS=', error); }
    if (results) { console.log('RESULTS=', results); }
    if (fields) { console.log('FIELDS=', fields); }
    connection.end(); //todo: move
  });
}

