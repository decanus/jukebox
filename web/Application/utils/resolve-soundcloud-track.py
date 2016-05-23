#!/usr/bin/env python
# -*- coding: utf-8 -*-

import urllib2
import urllib
import sys
import json
from os.path import dirname, join

quote = urllib.quote

with open(join(dirname(__file__), '../data/tokens.json')) as f:
    client_id = json.loads(f.read())['soundCloudClientId']

if len(sys.argv) > 1:
    resolve_url = sys.argv[1]
else:
    resolve_url = raw_input('enter a soundcloud url: ')

api_url = 'https://api.soundcloud.com/resolve?url=' + quote(resolve_url) + '&client_id=' + quote(client_id)

try:
    result = urllib2.urlopen(api_url)

except urllib2.HTTPError:
    print "could not resolve url"
    sys.exit()

data = json.loads(result.read())

print json.dumps({ 'id': data['id'], 'title': data['title'] }, indent=2)