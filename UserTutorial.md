# User Tutorial #

MantisREST lets you interface with the [Mantis Bug Tracker](http://mantisbt.org) through simple HTTP requests.  Common items in Mantis, such as bugs, bugnotes, and users, have a URL by which you can access them through the API.  For example, if you've set up your installation such that `http://mantisrest.example.com/` is the root, then the URL for [bug 57](https://code.google.com/p/mantis-rest/issues/detail?id=7) would be `http://mantisrest.example.com/bugs/57`, and the URL for your user account might be `http://mantisrest.example.com/users/7`.

By using HTTP requests of the `GET`, `PUT`, and `POST` varieties on these URLs, you can write a '''client''' that automates different tasks in Mantis.

[[PageOutline](PageOutline.md)]

## Resources And Representations ##

The principles on which our API is based are called REST, which stands for "REpresentational State Transfer".  [Wikipedia](http://en.wikipedia.org/wiki/Representational_State_Transfer) can explain these principles much more clearly than I, so I'll just say this: every "thing" from Mantis, like a bug or a project, corresponds to a '''resource''' in the API, and each resource can generate '''representations''' of itself.

So consider note 197 from your Mantis instance.  The corresponding resource in MantisREST is found at the URL (Universal ''Resource'' Locator; get it?) `http://mantis.example.com/notes/197`.  When you make a GET request for this resource, the server will return a representation of it -- a string that encodes the data in the resource.  If you've requested a JSON representation, the response might be something like this:

```
{
    "reporter": "http:\/\/mantisrest.example.com\/users\/4",
    "text": "Note note note!  I am a note!",
    "private": false,
    "date_submitted": "2008-11-24T22:15:26-05:00",
    "last_modified": "2008-11-24T22:15:26-05:00"
}
```

As you can see, the representation contains all the attributes you associate with a Mantis note.  You can parse it with your language's JSON library, and you've got an associative array with all the data you requested.

Another thing to notice is that the value of "reporter", which is the user who wrote the note, is a URL.  This is common practice: if something exists as a resource in our API, then we give the client its URL instead of some other signifier like a username.

## HTTP Methods And Headers ##

An HTTP transaction is pretty simple: you (the client) send a '''request''' to the server (MantisREST), and the server sends back a '''response'''.  Your request includes the URL of the resource you want to act on, a '''method''', which tells the server what you want to ''do'' with the resource, and a set of '''headers''', which help specify ''how'' to carry out your action.  Additionally, your request may have a '''body''', which is some text -- for our purposes, it will always be a representation of a resource.

An HTTP response has headers and a body too, but it also has a '''status code'''.  This is a 3-digit number whose definition can be found [here](http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html), in the HTTP standard.  You can tell what kind of status code you've gotten by checking the first digit: "2" means success, "4" means client error, and "5" means server error.

### Methods ###

The three HTTP methods supported by MantisREST are `GET`, `POST`, and `PUT`.  When you `GET` a resource, the response body will contain a representation of that resource.  A `PUT` request replaces the specified resource with whatever data you included in your request body.  And finally, `POST` will create a new resource.

Maybe this table will clear it up a bit:

| |GET|PUT|POST|
|:|:--|:--|:---|
|`/bugs`|Get a list of all bugs|(no action)|Create a new bug|
|`/bugs/97`|Get a representation of [bug 97](https://code.google.com/p/mantis-rest/issues/detail?id=7)|Replace [bug 97](https://code.google.com/p/mantis-rest/issues/detail?id=7)|(no action)|
|`/users`|Get a list of all users|(no action)|Create a new user|
|`/bugs/141/notes`|Get a list of all notes on [bug 141](https://code.google.com/p/mantis-rest/issues/detail?id=41)|(no action)|Add a note to [bug 141](https://code.google.com/p/mantis-rest/issues/detail?id=41)|

### Headers ###

HTTP requests and responses may contain headers, which are just strings of the from "Key: Value".  Request headers help the server interpret the request and choose an appropriate response, and response headers give the client information about the response.  Header keys are case insensitive.

The HTTP definition lays out some standard headers, a few of which you should be familiar with for MantisREST:
> `Accept`
> > A request header telling the server what format you'd like your response in.  For example, if you'd like an XML representation, you'd send a request with the header "`Accept: text/xml`".

> `Content-type`
> > A response header that tells the client what format the response body is in, such as "`content-type: text/x-json`".

> `Authorization`
> > A request header that authenticates you to the server with a username/password combination.  More on that in the next section.

## Authentication And Authorization ##

MantisREST requires you to have the username and password of a Mantis user, and it tries to follow Mantis's authorization rules as closely as possible.  If there's something you're not allowed to do in Mantis, you shouldn't be allowed to do it in MantisREST either.

We use HTTP's authentication scheme to authenticate users.  This basically sends your password in plaintext over the network, so if you're using MantisREST over the Internets, you should ''always'' encrypt your traffic (using HTTPS, for instance).

HTTP authentication is easy to use.  All you have to do is include an "Authorization" header with your request.  Here's how you construct the value of that header:
  1. Put your username, then a colon, then your password into a string.
  1. Base-64 encode that string.
  1. Set the value of the header to the word "Basic", followed by a space, followed by that base-64 string.
  1. Create a header with the key "Authorization", and set its value to the string you came up with in step 3.
Your header will end up something like this:

```
Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ=
```

Set that header, and MantisREST should give you whatever access your account has in Mantis.  If the server doesn't like your authentication information, you'll get a 401 error; make sure that you're encoding the auth string correctly.

## Getting Data From Mantis ##

When all you need from Mantis is a field from one resource, it's trivially simple to get it.  Just send a GET request for the URL of the resource, with a header of "Accept: text/x-json", and you'll get back a JSON-encoded associative array with all the relevant data.  For example, if you wanted to know the priority of [bug 17824](https://code.google.com/p/mantis-rest/issues/detail?id=7824), you'd do the following (in Python):

```
import httplib
import simplejson

conn = httplib.HTTPConnection('mantisrest.example.com')
headers = {'Authorization': 'Basic dXNlcm5hbWU6cGFzc3dvcmQ=', 'Accept': 'text/x-json'}
conn.request('GET', 'http://mantisrest.example.com/bugs/17824')
resp = conn.getresponse()

if not str(resp.status).startswith('2'):
    raise Exception('Non-success code %d returned from server' % resp.status)
representation = resp.read()
bug_data = simplejson.loads(representation)
print bug_data['priority']
```

The server sent you a representation of [bug 17824](https://code.google.com/p/mantis-rest/issues/detail?id=7824), and you decoded it to get an associative array, stored in `bug_data`.  If the bug has an "urgent" priority in Mantis, then this code will just print "urgent" on success. ''(note: for a full list of the keys you'll find in this array, see BugResource)''

As you can see, getting data about resources (bugs, bugnotes, users, etc.) is as easy as can be.  But what if you want to change a resource?  Well, it's really not much harder.

## Changing Data In Mantis ##

To change the contents of a resource, you just replace it with another using a PUT request.  Usually, what you do is just GET the resource, decode it, fiddle with the data, encode it back, and PUT it.

Some of the keys you include in the representation you PUT will be ignored.  For example, a bugnote resource has `date_submitted` and `last_modified` keys; `date_submitted` never changes, and `last_modified` will be updated to the current time no matter what you specify.

## Creating Resources ##

Suppose you want to create a new bugnote.  The method you need is POST: it creates a new resource subordinate to the one identified by the URL in your request.  But what should your note be subordinate ''to''?

In MantisREST, we have a special type of resource called a '''resource list'''.  It's a collection of similar resources: `/bugs`, `/users`, and `/bugs/14/notes` are all paths to resource lists.  It should come as no surprise, then, that in order to create a new resource, you POST to the resource list that contains it.  So you'd add a note to [bug 2408](https://code.google.com/p/mantis-rest/issues/detail?id=408) by creating a JSON representation of a bugnote (with all the keys specified in BugnoteResource) and putting it in the body of a POST request for `http://mantisrest.example.com/bugs/2408/notes`.

If you get a response with a success code after POSTing a new resource, it will have a "Location" header: this specifies the URL of your newly created resource.

## Getting Lists Of Resources ##

In the last section, we introduced the concept of resource lists; you can POST to them to create new resources.  But you can also GET a resource list, which will provide you with a list of the URLs of the resources in that list.  More concretely, if you submitted a GET request for `http://mantisrest.example.com/bugs`, your response would include an entity like this:

```
{"results": ["http:\/\/mantisrest.example.com\/bugs\/1", "http:\/\mantisrest.example.com\/bugs\/2", "http:\/\/mantisrest.example.com\/bugs\/5"]}
```

It's an associative array with a single key: "results".  The value there is a list of URLs: they're the URLs of all the bugs in the system, or at least all the one's you're allowed to see.

This URL list is _sorted_ by default; keep that in mind.

## Filtering And Sorting Resources ##

But most Mantis instances have a lot more than 3 bugs.  What if you just want the bugs with a priority of "urgent"?  It's certainly not reasonable to go through 20,000 bugs one by one -- GETting them, decoding them, and checking their priority value.

Well, MantisREST lets you specify a query string with the URL of a resource list.  You can use this query string to filter buglists.  For example, if you were to GET `http://mantisrest.example.com/bugs?priority=urgent`, you'd receive an associative array just like the one in the last section, but the results would only include urgent bugs.

In a similar way, you can sort resource lists; as the key part of the key-value pair you use "sort-" followed by a resource key (such as a bug's `last_modified` key).  A GET request for `http://mantisrest.example.com/users?sort-access_level` would give you all the user URLs in the system, sorted by the users' access levels.  If you specify a value for a sort parameter, and it's -1, then the results will be sorted descending instead of ascending.

Here are some examples of ways you might sort and filter resource lists:

> `/bugs?priority=normal&reporter=http:%2F%2Fmantisrest.example.com%2Fusers%2F71`
> > All bugs with normal priority, reported by the user whose URL is `http://mantisrest.example.com/users/71`

> `/users?sort-access_level&sort-email=-1`
> > All users in the system, sorted by access level and then by email address descending

> `/bugs/9897/notes?limit=5`
> > The first 5 notes attached to [bug 9897](https://code.google.com/p/mantis-rest/issues/detail?id=897)

Some keys are filterable, some are sortable, some are both, and some are neither.  Check the wiki page for the resource you're messing with to find out which are which.