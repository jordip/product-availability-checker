#!/bin/bash
if [ $# -eq 0 ]
  then
    echo "No arguments supplied"
else
	if [ -z "$1" ]
	  then
	    echo "No version supplied"
	else
		VERSION=$1
		echo "= Releasing version ${VERSION} ="
		echo "Copying files to tags/${VERSION}"
		rsync -av --exclude=".*" ../_pac-plugin-git/ tags/$VERSION
		echo "Copying files to trunk folder"
		rsync -av --exclude=".*" ../_pac-plugin-git/ trunk
		echo "Copying png assets"
		rsync -av --exclude=".*" ../_pac-plugin-git/assets/*.png assets
		echo "Adding changes to svn"
		svn add --force * --auto-props --parents --depth infinity -q
		echo "Commit changes"
		svn commit -m "Release ${VERSION}"
		echo "Completed"
	fi
fi