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

bug_body = """{"project_id":"1",
"reporter":"http:\/\/mantis.localhost\/rest\/users\/2",
"handler":"http:\/\/mantis.localhost\/rest\/users\/4",
"duplicate":"",
"priority":"urgent",
"severity":"feature",
"reproducibility":"always",
"status":"assigned",
"resolution":"open",
"projection":"tweak",
"category":"",
"date_submitted":1222828053,
"last_updated":1223520462,
"eta":"< 1 week",
"os":"",
"os_build":"",
"platform":"",
"version":"",
"fixed_in_version":"",
"target_version":"",
"build":"",
"private":false,
"summary":"Swizzle",
"sponsorship_total":"0",
"sticky":"0",
"profile_id":"0",
"description":"Bitches hey",
"steps_to_reproduce":"",
"additional_information":"Oh noes!  A bug!"}"""
note_body = """{"bug":"http:\/\/mantis.localhost\/rest\/bugs\/1",
"reporter":"http:\/\/mantis.localhost\/rest\/2",
"note":"Whoa, note.",
"private":false,
"date_submitted":"2008-10-08 22:47:42",
"last_modified":"2008-10-08 22:47:42"}"""
c.request('PUT', uri, body=note_body, headers=headers)
#c.request('GET', uri, headers=headers)
r = c.getresponse()
print "Status code: %d" % r.status

headers = r.getheaders()
output = r.read()
for h in headers: print "%s: %s" % h
print
print output.rstrip()

#resource = simplejson.loads(r.read())
