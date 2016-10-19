#!/bin/bash

# Ubuntu 14.04 Trusty Tahr install php7 with Microsoft ODBC Driver 13

cd $( dirname "${BASH_SOURCE[0]}" )

# get php7
add-apt-repository ppa:ondrej/php -y
add-apt-repository ppa:ubuntu-toolchain-r/test -y
apt-get update
apt-get -o Dpkg::Options::="--force-confnew" dist-upgrade -y
apt-get install python-software-properties software-properties-common \
	php php7.0-zip php7.0-mbstring php-xml php-curl php-xdebug \
	make unixodbc php-odbc libc6 libkrb5-3 libgss3 e2fsprogs openssl libstdc++6 -y

# enable odbc
phpenmod odbc

# original download driver link page https://www.microsoft.com/en-us/download/details.aspx?id=50419
wget https://github.com/scratchers/travis-ms-odbc/raw/fc543a4e441a4b8ae9c78933d0edbfb95074eb57/msodbcsql-13.0.0.0.tar.gz
tar xvzf msodbcsql-13.0.0.0.tar.gz
cd msodbcsql-13.0.0.0
./build_dm.sh --accept-warning

# driver manager will have custom directory
cd /tmp/unixODBC.*/unixODBC-*; make install

# return to download dir
cd -

# actually install driver
./install.sh verify
./install.sh install --accept-license

# problem with missing new library, link to old seems to work
cd /usr/lib/x86_64-linux-gnu
ln -s libodbcinst.so.1 libodbcinst.so.2
