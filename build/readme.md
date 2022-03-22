# Sourceforge build system by tonywoode 2015

## Double click runner - pay attention to prompts

### Folders
We use three external folders
1) sqlFolder 	- in root find the latest .sql taken of the LOCAL db - so we can push it
				- in archive find the backup we take of the REMOTE db - named by date
2) secrets	- there are 3 brands of each file:
				*_blank - the ones its safe to push to git
				*_local - the ones with the mamp credentials
				* - the ones that are only for live 
3) Release - my build script builds in here and also pulls git tag and commit messages

### Considerations
	* MediaWiki Image Uploads require ImageMajick to be Installed (needs folder /usr/local/bin/convert - use your favourite package manager to do so)
	* Note we must calls MAMP's version of mysql/mysqldump etc
	* Note exp is so-called because its expect not bash, tcl syntax
		- there's doubtless a way to stop it echoing back, but hey its informative

### Structure
The main scripts in this folder are bash, and I used node for the databasey-interaction in the subfolder herein
