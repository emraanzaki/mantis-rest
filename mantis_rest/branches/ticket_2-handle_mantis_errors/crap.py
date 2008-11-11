#!/usr/bin/python

import sys
import httplib
import base64

import simplejson

uri = '/rest' + sys.argv[1]

user, password = 'dan', 'dan'
authdata = base64.encodestring('%s:%s' % (user, password)).rstrip()

c = httplib.HTTPConnection('mantis.localhost')
headers = dict(Authorization = 'Basic %s' % authdata,
               Accept = 'application/json')

body = '{"project_id":"1","reporter":"http://mantis.localhost/rest/users/2","handler":"http://mantis.localhost/rest/users/4","duplicate":"","priority":"30","severity":"50","reproducibility":"70","status":"10","resolution":"10","projection":"10","category":"","date_submitted":1222828053,"last_updated":1223520462,"eta":"10","os":"","os_build":"","platform":"","version":"","fixed_in_version":"","target_version":"","build":"","view_state":"10","summary":"Swizzle","sponsorship_total":"0","sticky":"0","profile_id":"0","description":"Bitch","steps_to_reproduce":"","additional_information":"","_stats":null}'
c.request('PUT', uri, body=body, headers=headers)
r = c.getresponse()
print "Status code: %d" % r.status

headers = r.getheaders()
output = r.read()
for h in headers: print h
print output.rstrip()

#resource = simplejson.loads(r.read())
