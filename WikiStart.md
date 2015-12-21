# Mantis REST #

A REST API to Mantis.  To get started using it, check out UserTutorial.

Here are some useful articles:
  * ResourceStructure

## Resources ##

We serve several different kinds of resource, each of which maps more or less directly onto an entity you'd recognize in Mantis.  Each resource is associated with a single URL, but can exist in multiple representations (actually, for now it's just JSON, but maybe some day...).

These are all the resources:

  * [Bug](BugResource.md)
  * [Bugnote](BugnoteResource.md)
  * [User](UserResource.md)

For each of these singular resources, there is a corresponding [ResourceList](ResourceList.md).

## Requests ##

An HTTP request for a resource can use any of the methods (HEAD, GET, POST, PUT, DELETE).  In general, a GET simply returns a representation of the resource, a POST creates a new resource in the given set, a PUT replaces a resource with one provided, and a DELETE deletes a resource.

To PUT a resource, you must supply a representation of the resource in your request body.  Your request must also have a "Content-type" header which specifies the MIME type of the representation in the body.  The response to a valid PUT request will almost always have code 204: No Content, so there'll be no body.


### Headers ###

If the request includes an 'Accept' header, its value is a MIME type in which any resource in the response will be represented.

Mantis REST uses Basic HTTP authentication.  The client provides a username and password, the API logs in as the specified user, and access is granted in roughly the same way as it is in Mantis itself.


## Responses ##

The body response may or may not contain a representation of a resource.  If it does, a 'Content-type' header will be present, indicating the MIME type of the representation.  If it doesn't, the HTTP status code of the response will be 204.

Here's a quick rundown of what the different response codes mean (to us):

|'''Code'''|'''RFC 2616 Reason Phrase'''|'''What it means coming from Mantis REST'''|
|:---------|:---------------------------|:------------------------------------------|
|200       |OK                          |Your request was processed, and content has been returned|
|201       |Created                     |Your request was processed, and resulted in the creation of a new resource|
|204       |No Content                  |Your request was processed, but the service hasn't included any content in the response body|
|401       |Unauthorized                |Either you didn't provide credentials or you didn't provide correct credentials|
|403       |Forbidden                   |Your credentials were correct, but they don't authorize you to make the request you made|
|404       |Not Found                   |The resource you specified doesn't exist   |
|406       |Not Acceptable              |The resource is not available in the content-type you specified in your 'Accept' header|
|415       |Unsupported Media Type      |An entity given in a PUT or POST request has an unrecognized attribute|