#!/bin/bash

sudo find * -type f -exec chmod 664 {} \;
sudo find * -type d -exec chmod 755 {} \;

chmod -R ug+rwx bootstrap/cache/ storage/

chown diogogl:www-data * -R
chown root:root *.sh

chmod u+x *.sh
chmod a+w public/uploads
