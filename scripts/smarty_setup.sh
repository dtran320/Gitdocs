#to be run from the webroot directory
#!/bin/sh

echo "--Make sure you are running this from your Gitdocs root directory and you have root privileges."

echo "--i.e. sudo scripts/smarty_setup.sh"

mkdir smarty/templates_c
echo "----Created smarty/templates_c"

mkdir smarty/cache
echo "----Created smarty/cache"

mkdir smarty/configs
echo "----Created smarty/configs"

chown nobody smarty/templates_c
echo "----chown nobody smarty/templates_c"

chown nobody smarty/cache
echo "----chown nobody smarty/cache"

chmod 777 smarty/templates_c
echo "----chmod 777 smarty/templates_c"
chmod 777 smarty/cache
echo "----chmod 777 smarty/cache"

echo "...DONE! Please visit index.php and make sure everything works!"

