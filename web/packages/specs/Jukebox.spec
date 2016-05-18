%define _wwwDir /var/www/jukebox/

Summary: jukebox
Name: jukebox
Release: jukebox.1
Group: System Environment/Libraries
License: jukebox.ninja
Vendor: jukebox.ninja
Version: 0.0.1
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
install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Frontend/html
install -m 755 -d $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/css/

cp -R %{_sourcedir}Frontend/bootstrap.php $RPM_BUILD_ROOT%{_wwwDir}Frontend/bootstrap.php

cp -R %{_sourcedir}Frontend/html/index.html $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/index.html
cp -R %{_sourcedir}Frontend/html/robots.txt $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/robots.txt
cp -R %{_sourcedir}Styles/css/* $RPM_BUILD_ROOT%{_wwwDir}Frontend/html/css/

%clean
rm -rf $RPM_BUILD_ROOT

%files
%defattr(-,root,root)

%dir %{_wwwDir}Frontend

%{_wwwDir}Frontend/*