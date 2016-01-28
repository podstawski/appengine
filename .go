if [ ! "$1" ]
then
	echo "$0 dev|gold"
	exit
fi


cp $1.yaml app.yaml
cp $1.php local.php
/opt/google/appengine/appcfg.py -e piotr@webkameleon.com update .

cp dev.php local.php
