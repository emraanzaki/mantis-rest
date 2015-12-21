# Bug #

Represents a bug in Mantis.

The path of the resource corresponding to Mantis [bug 14](https://code.google.com/p/mantis-rest/issues/detail?id=4) is `/bugs/14`.  Only GET and PUT are supported.  To create a new bug, you'd POST to `/bugs`, a [BugList](BugListResource.md).

[[PageOutline](PageOutline.md)]


## Attributes ##

A '''Bug''' resource has the following attributes:

|attribute|filterable|description|
|:--------|:---------|:----------|
|project\_id|          |The ID of the project with which the bug is associated|
|reporter |Y         |The URL of the user who reported the bug|
|handler  |Y         |The URL of the user to whom the bug is assigned.  This can be empty, which means the bug is not assigned to anyone|
|duplicate|Y         |If this bug is a duplicate of another bug, the other bug's URL goes in this field|
|priority |Y         |The bug's priority, as the integer that Mantis understands|
|severity |Y         |The severity, as an integer|
|reproducibility|Y         |The reproducibility of the bug as an integer|
|status   |Y         |Bug status as an integer|
|resolution|Y         |Resolution as an integer|
|projection|Y         |How much work the task is expected to take|
|category |          |Bug category; this is a string.|
|date\_submitted|          |The local date when the bug was submitted, in ISO 8601 format|
|last\_updated|          |Local date of the last update to the bug|
|eta      |Y         |The ETA of a resolution|
|os       |          |The OS of the affected system.  '''Q: Are these databased or freeform?'''|
|os\_build|          |The build of the OS|
|platform |          |The platform field from Mantis|
|version  |          |The version in which the bug occurs|
|fixed\_in\_version|          |The version by which the bug is fixed|
|target\_version|          |The version by which the bug is expected to be fixed|
|build    |          |The product build in which the bug occurs|
|private  |          |Indicates whether a bug is public or private|
|summary  |          |The bug summary|
|sponsorship\_total|          |How much money is riding on this bug, I guess. Haven't really looked into sponsorships.|
|sticky   |          |You can make a bug sticky, so that it stays at the top of the list|
|profile\_id|          |The ID of the system profile describing the machine on which the bug occurs, I guess.  '''Q: Where's the row this identifies?  There's no mantis\_profile\_table.'''|
|description|          |The full description of the bug|
|steps\_to\_reproduce|          |The steps to reproduce the bug|
|additional\_information|          |Any additional information|


## GET ##

Performing a GET on a Bug resource will produce a representation of a Mantis bug.


## PUT ##

PUTting a Bug resource replaces the Mantis bug's data with the data provided.  `date_submitted` and `last_updated` are ignored.