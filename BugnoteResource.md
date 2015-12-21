# Bugnote #

A note on a Mantis bug.  Since a note is always subordinate to a bug, the path of a bugnote will always be of the form `/bugs/(bug id)/notes/(note id)`, where `bug id` and `note id` are both integers.

GET and PUT are supported.  To create a new bugnote attached to [bug 36](https://code.google.com/p/mantis-rest/issues/detail?id=6), you'd POST to `/bugs/36/notes`, a [BugnoteList](ResourceList.md).

[[PageOutline](PageOutline.md)]


## Attributes ##

This resource has the following attributes:

|attribute|filterable|sortable|description|
|:--------|:---------|:-------|:----------|
|bug      |          |        |The ID of the bug to which the note is attached ('''Should probably get rid of this, as it's redundant with data in the URL''')|
|reporter |Y         |Y       |The URL of the user that created the note|
|note     |          |        |The text of the note ('''Should change the name of this to 'text', as the whole thing is the note''')|
|private  |Y         |Y       |Whether the bugnote is private|
|date\_submitted|          |Y       |The date the note was created|
|last\_modified|          |Y       |The date the note was last changed|


## GET ##

GETting a Bugnote resource produces a representation of the note.


## PUT ##

When you PUT a Bugnote resource, you'll update the note.  However, the only attribute you can change is `note`; all other attributes in the data you send will be ignored.