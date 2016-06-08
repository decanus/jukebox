Summary: JukeboxServer
Name: jukebox-server
Version: 0.0.2
Release: jukebox.1
Group: System Environment/Libraries
License: Jukebox
Vendor: Jukebox
Url: https://www.jukebox.ninja/

Provides: jukebox-server-%{version}-%{release}
Requires: nginx php-fpm redis python-setuptools mongodb-org postgresql-server postgresql-contrib

%description
System Configuration for Servers

%pre
getent group php >/dev/null || groupadd -r php
getent passwd php >/dev/null || useradd -r -s /sbin/nologin -d /var/www -c"php-fpm user" -g php php

%prep
%setup -q -T -c

%build

%install
rm -rf $RPM_BUILD_ROOT


mkdir -p $RPM_BUILD_ROOT/etc/nginx/conf.d/
mkdir -p $RPM_BUILD_ROOT/etc/supervisord.d/
mkdir -p $RPM_BUILD_ROOT/etc/rc.d/init.d/

install -m 644 %{_sourcedir}/nginx/* $RPM_BUILD_ROOT/etc/nginx/conf.d/

install -m 644 %{_sourcedir}/supervisor/php_worker.conf $RPM_BUILD_ROOT/etc/supervisord.d/
install -m 644 %{_sourcedir}/supervisor/supervisord.conf $RPM_BUILD_ROOT/etc/supervisord.conf.jukebox
install -m 644 %{_sourcedir}/supervisor/supervisord $RPM_BUILD_ROOT/etc/rc.d/init.d/supervisord.jukebox
install -m 644 %{_sourcedir}/php.ini $RPM_BUILD_ROOT/etc/php.ini.server

%clean
rm -rf $RPM_BUILD_ROOT

%files
%defattr(-,root,root)
%attr(-,root,root)

/etc/supervisord.conf.jukebox
/etc/supervisord.d/php_worker.conf
/etc/rc.d/init.d/supervisord.jukebox

/etc/nginx/conf.d/api.jukebox.ninja.conf
/etc/nginx/conf.d/jukebox.ninja.conf
/etc/nginx/conf.d/nginx-base.conf
/etc/php.ini.server

%post
service nginx restart
service php-fpm restart

# supervisor installieren
easy_install pip
pip install supervisor
chmod +x /etc/rc.d/init.d/supervisord
chkconfig --add supervisord
chkconfig --level 345 supervisord on

if [ ! -h /etc/php.ini -o ! "`readlink /etc/php.ini`" = "/etc/php.ini.server" ] ; then
    if [ -e /etc/php.ini ] ; then
        mv -f /etc/php.ini /etc/php.ini.orig
    fi
    ln -s /etc/php.ini.server /etc/php.ini
fi

%triggerin -- supervisord
if [ ! -h /etc/supervisord.conf -o ! "`readlink /etc/supervisord.conf`" = "/etc/supervisord.conf.jukebox" ] ; then
    if [ -e /etc/supervisord.conf ] ; then
        mv -f /etc/supervisord.conf /etc/supervisord.conf.orig
    fi
    ln -s /etc/supervisord.conf.jukebox /etc/supervisord.conf
fi

%triggerin -- supervisordinit
if [ ! -h /etc/rc.d/init.d/supervisord -o ! "`readlink /etc/rc.d/init.d/supervisord`" = "/etc/rc.d/init.d/supervisord.jukebox" ] ; then
    if [ -e /etc/rc.d/init.d/supervisord ] ; then
        mv -f /etc/rc.d/init.d/supervisord /etc/rc.d/init.d/supervisord.orig
    fi
    ln -s /etc/rc.d/init.d/supervisord.jukebox /etc/rc.d/init.d/supervisord
fi
