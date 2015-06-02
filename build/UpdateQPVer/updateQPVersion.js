/**
 * Reads the local copy of the qp database and updates QPVer
 */

var mysql     = require('mysql');
var config	  = require('../../../secrets/config');
var prompt    = require('./userInput');

var connection = mysql.createConnection({
    host        :   config.localdb.host,
    user        :   config.localdb.user,
    password    :   config.localdb.password,
    port        :   config.localdb.port,
    database    :   config.localdb.database
});

//the callback we pass to connect runs after we connect, or fail to
connection.connect(function(err) {
    if (err) {
        console.error('error connecting: ' + err.stack);
        return;
    }

    console.log('connected as id ' + connection.threadId);
    console.log('EXISTING VERSION TABLE FOLLOWS:');

/*
the anonymous function we just defined has the same signature as showTable,
 so we can just pass the reference to show table rather than defining n anonymous function
 you could just go prompt(showTable); you only need anonymous function if you're going to change 
 the signature or if there is no named function to invoke
 */
    prompt(function(result){ 
        //async-101: we can't call insertRow serially after show table, or it'll run both at the same time
        showTable(result, function(){
            insertRow(version_name, downloadURL, filesize, result)
        }); //here's why we use promises, this could become the callback pyramid of doom
    });
});



function showTable(result, next) {
    connection.query('select * from version', function (error, results, fields) {
        // error will be an Error if one occurred during the query
        if (error) { console.log('ERRORS=', error); }
        // results will contain the results of the query
        if (results) { console.log('RESULTS=', results); }
        // fields will contain information about the returned results fields (if any)
        if (fields) { console.log('FIELDS=', fields); }
        next(result);
    });
}

//insert values for the next tuple - primary key version_id in the table auto-increments
function insertRow(version_name, downloadURL, filesize, next) {
    connection.query('INSERT INTO version (version_name, download, filesize) values ("'+version_name+'","'+downloadURL+'", "'+filesize+'")',
        function (error, results, fields) {
        if (error) { console.log('ERRORS=', error); }
        if (results) { console.log('RESULTS=', results); }
        if (fields) { console.log('FIELDS=', fields); }
        connection.end(); //todo: move
    });

}


