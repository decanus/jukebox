%define _wwwDir /var/www/jukebox/

Summary: jukebox
Name: jukebox
Release: jukebox.1
Group: System Environment/Libraries
License: jukebox.ninja
Vendor: jukebox.ninja
Version: 0.0.2
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

install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Frontend
install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Frontend/{html,src,config,data}
install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/{css,images,js,html}/

install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Framework
install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Framework/{lib,src}

install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}API
install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}API/{config,src}

install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Backend
install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Backend/{config,src,data}

cp -R %{_sourcedir}Frontend/html/images/* $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/images/
cp -R %{_sourcedir}Frontend/html/html/* $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/html/
cp -R %{_sourcedir}Frontend/html/favicon.ico $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/favicon.ico
cp -R %{_sourcedir}Frontend/html/robots.txt $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/robots.txt
cp -R %{_sourcedir}Styles/css/* $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/css/
cp -R %{_sourcedir}Application/build/js/* $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/js/
cp -R %{_sourcedir}Frontend/bootstrap.php $RPM_BUILD_ROOT%{_wwwDir}Frontend/bootstrap.php
cp -R %{_sourcedir}Frontend/src/* $RPM_BUILD_ROOT%{_wwwDir}Frontend/src/
cp -R %{_sourcedir}Frontend/data/* $RPM_BUILD_ROOT%{_wwwDir}Frontend/data/
cp -R %{_sourcedir}Frontend/config/system.live.ini $RPM_BUILD_ROOT%{_wwwDir}Frontend/config/system.ini

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

%dir %{_wwwDir}Frontend

%{_wwwDir}Frontend/*