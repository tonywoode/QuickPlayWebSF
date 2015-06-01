/**
 * Reads the local copy of the qp database and updates QPVer
 */

var mysql     = require('mysql');
var config		= require('../../../secrets/config');

var version_id = 19,
    version_name = '4.1.1',
    downloadURL = 'some made up damn thing',
    filesize = 'probably quite big';


var connection = mysql.createConnection({
    host        :   config.localdb.host,
    user        :   config.localdb.user,
    password    :   config.localdb.password,
    port        :   config.localdb.port,
    database    :   config.localdb.database
});

connection.connect(function(err) {
    if (err) {
        console.error('error connecting: ' + err.stack);
        return;
    }

    console.log('connected as id ' + connection.threadId);
});

console.log('EXISTING VERSION TABLE FOLLOWS:')

function showTable() {
    connection.query('select * from version', function (error, results, fields) {
        // error will be an Error if one occurred during the query
        if (error) {
            console.log('ERRORS=', error);
        }
        // results will contain the results of the query
        if (results) {
            console.log('RESULTS=', results);
        }
        // fields will contain information about the returned results fields (if any)
        if (fields) {
            console.log('FIELDS=', fields);
        }
    });
}

showTable();


connection.query('INSERT INTO version values ("'+version_id+'","'+version_name+'","'+downloadURL+'", "'+filesize+'")',
    function (error, results, fields) {
    // error will be an Error if one occurred during the query
    if (error) { console.log('ERRORS=', error); }
    // results will contain the results of the query
    if (results) { console.log('RESULTS=', results); }
    // fields will contain information about the returned results fields (if any)
    if (fields) { console.log('FIELDS=', fields); }
});


connection.end();
