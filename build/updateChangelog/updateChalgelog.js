var execFile = require('child_process').execFile;
var optipng = require('pandoc-bin').path;

execFile(optipng, ['-f', 'markdown', '-t', 'html','changelogLF','-o', 'changelogHTML'], function (err, stdout, stderr) {
    console.log(stdout);
    console.log(err);
    console.log(stderr);
});