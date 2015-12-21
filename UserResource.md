# User #

A Mantis user.  The path of a user will always be of the form `/users/(id)`, with `id` being an integer.

GET and PUT are supported.  To create a new user, you would POST to `users`, a [UserList](UserListResource.md).

[[PageOutline](PageOutline.md)]

## Attributes ##

This resource has the following attributes:

|attribute|filterable|sortable|description|
|:--------|:---------|:-------|:----------|
|username |Y         |Y       |The... username.|
|password |          |        |The user's password (see below)|
|realname |Y         |Y       |The user's real name|
|email    |Y         |Y       |The user's email address|
|date\_created|          |Y       |The date when the user was created|
|last\_visit|          |Y       |The date when the user last logged in|
|enabled  |Y         |        |Whether the user account is enabled|
|protected|Y         |        ||Whether the user account is protected ('''Q: What does this mean?''')|
|access\_level|Y         |Y       |The user's global access level|
|login\_count|          |Y       |The number of times the user has logged in ('''Q: But is it?  The user I'm logged in as has `login_count` = 0.''')|
|lost\_password\_request\_count|          |Y       |The number of times the user has requested a password reset|
|failed\_login\_count|          |Y       |The number of times the user has failed to log in|

## GET ##

Using GET on a resource of this type will return a representation of a Mantis user.  The `password` attribute won't actually be the user's password, it will be "".

## PUT ##

PUTting a User resource replaces the user's information with the data provided.  `date_created`, `last_visit`, `login_count`, `lost_password_request_count`, and `failed_login_count` will be ignored.