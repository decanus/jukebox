%define _wwwDir /var/www/

Summary: jukebox
Name: jukebox
Release: jukebox.1
Group: System Environment/Libraries
License: jukebox.ninja
Vendor: jukebox.ninja
Version: 0.2.3
Url: http://www.jukebox.ninja/

#Source:
Provides: jukebox-%{version}-%{release}

Requires: php-cli php-dom php-xsl php-mbstring php-gd php-redis

BuildArch: noarch

%description
Jukebox release

#%prep

#%setup

#%build

%install
[ "$RPM_BUILD_ROOT" != "/" ] && rm -rf $RPM_BUILD_ROOT

mkdir -p $RPM_BUILD_ROOT/etc/cron.d

install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Frontend
install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Frontend/{html,src,config,data}
install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/{css,images,js}/

install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Framework
install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Framework/{lib,src}

install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}API
install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}API/{config,src}

install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Backend
install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Backend/{config,src,data}

install -m 644 %{_sourcedir}Backend/config/backend.cron $RPM_BUILD_ROOT/etc/cron.d/backend.cron

cp -R %{_sourcedir}Frontend/html/images/* $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/images/
mv $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/images/icons.svg $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/images/icons-%{version}-%{release}.svg
cp -R %{_sourcedir}Frontend/html/favicon.ico $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/favicon.ico
cp -R %{_sourcedir}Frontend/html/robots.txt $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/robots.txt

cp -R %{_sourcedir}Styles/css/jukebox.css $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/css/jukebox-%{version}-%{release}.css
cp -R %{_sourcedir}Application/build/js/polyfills.js $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/js/polyfills-%{version}-%{release}.js
cp -R %{_sourcedir}Application/build/js/jukebox.js $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/js/jukebox-%{version}-%{release}.js
cp -R %{_sourcedir}Application/build/js/views.js $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/js/views-%{version}-%{release}.js

cp -R %{_sourcedir}Frontend/bootstrap.php $RPM_BUILD_ROOT%{_wwwDir}Frontend/bootstrap.php
cp -R %{_sourcedir}Frontend/src/* $RPM_BUILD_ROOT%{_wwwDir}Frontend/src/
cp -R %{_sourcedir}Frontend/data/* $RPM_BUILD_ROOT%{_wwwDir}Frontend/data/
cp -R %{_sourcedir}Frontend/config/system.live.ini $RPM_BUILD_ROOT%{_wwwDir}Frontend/config/system.ini

php %{_sourcedir}packages/scripts/appendCssAndJsVersion.php $RPM_BUILD_ROOT%{_wwwDir}Frontend/data/templates/template.xhtml %{version}-%{release}

cp -R %{_sourcedir}Framework/lib/* $RPM_BUILD_ROOT%{_wwwDir}Framework/lib/
cp -R %{_sourcedir}Framework/src/* $RPM_BUILD_ROOT%{_wwwDir}Framework/src/
cp -R %{_sourcedir}Framework/bootstrap.php $RPM_BUILD_ROOT%{_wwwDir}Framework/bootstrap.php

cp -R %{_sourcedir}API/config/system.live.ini $RPM_BUILD_ROOT%{_wwwDir}API/config/system.ini
cp -R %{_sourcedir}API/config/accessTokens.json $RPM_BUILD_ROOT%{_wwwDir}API/config/accessTokens.json
cp -R %{_sourcedir}API/src/* $RPM_BUILD_ROOT%{_wwwDir}API/src/
cp -R %{_sourcedir}API/bootstrap.php $RPM_BUILD_ROOT%{_wwwDir}API/bootstrap.php

cp -R %{_sourcedir}Backend/config/system.live.ini $RPM_BUILD_ROOT%{_wwwDir}Backend/config/system.ini
cp -R %{_sourcedir}Backend/src/* $RPM_BUILD_ROOT%{_wwwDir}Backend/src/
cp -R %{_sourcedir}Backend/data/* $RPM_BUILD_ROOT%{_wwwDir}Backend/data/
cp -R %{_sourcedir}Backend/bootstrap.php $RPM_BUILD_ROOT%{_wwwDir}Backend/bootstrap.php
cp -R %{_sourcedir}Backend/writer.php $RPM_BUILD_ROOT%{_wwwDir}Backend/writer.php
cp -R %{_sourcedir}Backend/worker.php $RPM_BUILD_ROOT%{_wwwDir}Backend/worker.php

%clean
rm -rf $RPM_BUILD_ROOT

%files
%defattr(-,root,root)
/etc/cron.d/backend.cron
%dir %{_wwwDir}Backend
%dir %{_wwwDir}API
%dir %{_wwwDir}Frontend
%dir %{_wwwDir}Framework

%{_wwwDir}Backend/*
%{_wwwDir}API/*
%{_wwwDir}Framework/*
%{_wwwDir}Frontend/*

%post

ln -s /var/www/CDN/artists /var/www/Frontend/html/images/artists

service crond restart
service supervisord restart
