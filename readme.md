QuickplayWeb
============

## What's this?
* Build and release tools for [QuickPlay Frontend](https://github.com/tonywoode/QuickPlay) at [sourceforge](https://sourceforge.net/projects/quickplay/)
* A website management tool (using MAMP) for [The Quickplay Hosted Website](http://quickplay.sourceforge.net/)
* The code for the above website
* MySQL backup and management for the above website

## Why?
This allows for agile release of Quickplay and easy update of the sites. Links exist between the two e.g.: current version tracking, that's why these functions go together

## features
* Git tag-based automatic release versioning
* Git tag also used to interactively makes project changelogs, and html-ifies them (using pandoc) for the site
* diff checks before we overwrite the remote www with local changes
* Fires up local or remote command-line, ssh, sql sessions (with hints!)
* We use the sourceforge API key functionality to create release folder structure and naming at sourceforge
* interactive ssh sessions after automated work (using expect)
* regex-replaced secrets for each use (local, remote, github) get checked
* www code wasnt safe as evidenced by spam in the DB - made mysqli prepared statement alternative (since SF's site doesn't support MySQLi::GetResult) (use pdo in future!)

## to run the build/release tool
* See the readme and quickplay instructions in the build folder
