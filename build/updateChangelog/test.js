var execFile = require('child_process').execFile;
var optipng = require('pandoc-bin').path;

execFile(optipng, ['-v'], function (err, stdout, stderr) {
    console.log('Pandoc version:', stdout.match(/\d+\.\d+\.\d+(\.\d+)?/)[0]);
});