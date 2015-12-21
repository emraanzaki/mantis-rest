# Resource Structure #

A class representing a type of resource, such as '''Bug''', '''User''', or '''Bugnote''', should follow some conventions:

## Static Methods ##

> `get_mantis_id_from_url($url)`::
> > Given the URL specified in a request, returns the Mantis database ID of the corresponding thing.

> `get_url_from_mantis_id($id)`::
> > Given the ID of a Mantis database row, returns a URL identifying the corresponding resource.

## Static Variables ##


> `$mantis_attrs`::
> > A list of the "attributes" of the item in Mantis.  This is not very well defined, but usually they will be database columns.

> `$rsrc_attrs`::
> > A list of the attributes of the resource.

## Object Methods ##


> `_get_mantis_attr($attr_name)`::
> > Returns the Mantis attribute with the given name.  Usually requires the presence of some corresponding resource data in `$this->resource_data`.

> `_get_rsrc_attr($attr_name)`::
> > Returns the resource attribute with the given name.  Generally requires the presence of some corresponding Mantis data in `$this->mantis_data`.

> `get()`::
> > Returns the contents of the HTTP response we should return to a GET request for this resource type.

> `put()`::
> > Implements the PUT method, returning response data or nothing.

> `post()`::
> > Implements the POST method, returning repsonse data or nothing.  Usually response data giving the URL of the newly posted resource.

## Object Variables ##


> `$mantis_data`::
> > An associative array containing the Mantis data, keyed by attribute name.

> `$rsrc_data`::
> > An associative array containing the resource data, keyed by attribute name.