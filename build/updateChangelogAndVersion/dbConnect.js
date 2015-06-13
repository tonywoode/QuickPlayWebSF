/**
Database connection file for JS DB Module
 allows use of env variables instead of hardcoded
 http://stackoverflow.com/questions/5869216/how-to-store-node-js-deployment-settings-configuration-files
*/
var    config	    = require('../../../secrets/config'),
		mysql       = require('mysql');

var connection = mysql.createConnection({
	    host        :   config.localdb.host,
	    user        :   config.localdb.user,
	    password    :   config.localdb.password,
	    port        :   config.localdb.port,
	    database    :   config.localdb.database
	});


module.exports = connection;
