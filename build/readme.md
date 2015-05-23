# Sourceforge build system by tonywoode 2015

## Double click runner - pay attention to prompts

### Folders
We use two external folders
1) sqlFolder 	- in root find the latest .sql taken of the LOCAL db - so we can push it
				- in archive find the backup we take of the REMOTE db - named by date
2) secrets	- there are 3 brands of each file:
				*_blank - the ones its safe to push to git
				*_local - the ones with the mamp creadentials
				* - the ones that are only for live 

### Considerations
	* Note we must calls MAMP's version of mysql/mysqldump etc
	* Note exp is so-called because its expect not bash, tcl syntax
		- there's doubtless a way to stop it echoing back, but hey its informative