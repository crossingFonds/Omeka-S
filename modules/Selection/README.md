Selection (module for Omeka S)
==============================

> __New versions of this module and support for Omeka S version 3.0 and above
> are available on [GitLab], which seems to respect users and privacy better
> than the previous repository.__

[Selection] is a module for [Omeka S] that allows any visitor to store selected
resources through sessions. The selected resources can be saved in multiple
selections with a label to simplify management. The selection can be dynamic too
when a search query is used. The selection can be organized in a structured way.

Furthermore, when the module [Bulk Export] is installed, it is possible to
export them instantly to common formats, included common spreadsheet formats.

The selection is saved in a cookie for anonymous visitor, so anybody can create
a selection. When the user is authenticated, in particular as a [Guest], the
selections is saved in the database and available through sessions.


Installation
------------

Install the optional modules [Generic], [Guest], and [Bulk Export], if wanted.

Uncompress files in the module directory and rename module folder `Selection`.
Then install it like any other Omeka module and follow the config instructions.

See general end user documentation for [Installing a module].


Usage
-----

The user can see a selection in the item page. On a click, the item is added to
the selection, or removed. The full list of resources in the selection is
available at "/s/my-site/guest/selection". This page is available for any
registered users and possibly for visitors.

A resource can be selected multiple times, but only once by selection.


Integration in a theme
----------------------

It is recommended to edit the theme directly to include the selection besides
the item and the media, in particular in the item/show and the item/browse views.


Integration via api (js)
------------------------

The api is the standard one and is available internally and via the endpoint:

1. List selected resources of an owner

  The available keys are : `owner_id`, `resource_id`, `selection_id`, `selection_label`.
  To get the selected resources that are not stored in a specific selection, use
  `selection_id=0`. Via endpoint, selected resources are not visible, so the
  credentials are required.

```sh
curl -X GET -H 'Accept: application/json' -i 'https://example.org/api/selection_resources?key_identity=xxx&key_credential=yyy&&pretty_print=1'
```

```php
$selectedResources = $this->api()->search('selection_resources', ['owner_id' => 1])->getContent();
```

2. Create a selection with a resource

  The example below creates a selection for resource #2 and saves it in the
  selection list with the label test. If the selection does not exist, it is
  automatically created. If the selection is not defined, the selected resource
  is saved but not attached to a specific selection. Via endpoint, the user is
  set via the credential.

  Warning: it is not possible currently to add a resource that is already
  selected  via the key `selection_resources`, so check the list of existing
  selected resources before doing the request.

```sh
curl -X POST -H 'Content-Type: application/json' -H 'Accept: application/json' -i 'https://example.org/api/selection_resources?key_identity=xxx&key_credential=yyy&pretty_print=1' --data '{"o:resource":{"o:id":2},"o:selection":{"o:label":"test"}}'
```

```php
$selectedResource = $this->api()->create('selection_resources', [
    'o:owner' => ['o:id' => 1],
    'o:selection' => ['o:label' => 'test'],
)->getContent();
```

3. Create a dynamic selection

  The example below uses the query "resource_class_id=1" to create a dynamic
  selection:

```php
$selectedResource = $this->api()->create('selections', [
    'o:owner' => ['o:id' => 1],
    'o:label' => 'my query',
    'o:comment' => 'a comment',
    'o:search_query' => 'resource_class_id=1'
)->getContent();
```

  Important: when a selection is converted into a search query, all selection
  resources are removed. The type change of a selection may be forbidden in a
  future version.

4. Add a selection of resources in bulk in a specific selection.

  Here, the api key is `selections`, so it avoids to use the key `selection_resources`
  multiple times, in particular via endpoint. A check is done on the list of
  resources, so a resource can be saved only if it is visible by the user and
  there won't be error if the resource is already listed in the specified
  selection. Nevertheless, the full list should be used, because the existing
  other selected resources will be removed.

```sh
curl -X PATCH -H 'Content-Type: application/json' -H 'Accept: application/json' -i 'https://example.org/api/selections/1?key_identity=xxx&key_credential=yyy&pretty_print=1' --data '{"resources":[3,4,5]}'
```

```php
$selection = $this->api()->update('selections', 1, [
    'o:comment' => 'the updated list of resources',
    'o:resources' => [['o:id' => 3], ['o:id' => 4], ['o:id' => 5]],
], [], ['isPartial' => true])->getContent();
```

5. Simplified management

  To simplify management of selection of resources in bulk without check, the
  shortcut key `resources` is available in the json payload or in the internal
  api. It allows to specify what to do for each resource: add, delete, or toggle.

```php
    // Replace the existing selected resources by this new list:
    'resources' => [3, 4, 5],

    // Fine tune the update of the resources:
    'resources' => [
        // Replace all the selected resources (default behavior).
        'replace' => [3, 4, 5],
        // Add this selection of resources to the selection.
        'append' => [6, 7, 8],
        // Remove these resources from the selection.
        'remove' => [9, 10]
        // Toggle the resources: if a resource is in a selection, it is removed,
        // else it is added.
        'toggle' => [11, 12]
    ],
```

  Important: `'resources' => []` or `'resources' => ['remove' => []]` means to
  remove all selected resources of the selection. Set it to `null` if you really
  need the key.


TODO
----

- [ ] Multiple selection of resources at once when a selection is not specified. Use a default selection in all cases?
- [x] Multiple selections with a title for each.
- [ ] Multiple selections (view pages).
- [ ] Integrate visibility in order to share selections.
- [ ] Allow to query multiple ids (owner id, resource id, selection id) in the api.
- [x] Add a modified date of a selection (from the selection itself, not only from the list of selected resources).


Warning
-------

Use it at your own risk.

It’s always recommended to backup your files and your databases and to check
your archives regularly so you can roll back if needed.


Troubleshooting
---------------

See online issues on the [module issues] page on GitLab.


License
-------

This module is published under the [CeCILL v2.1] license, compatible with
[GNU/GPL] and approved by [FSF] and [OSI].

This software is governed by the CeCILL license under French law and abiding by
the rules of distribution of free software. You can use, modify and/ or
redistribute the software under the terms of the CeCILL license as circulated by
CEA, CNRS and INRIA at the following URL "http://www.cecill.info".

As a counterpart to the access to the source code and rights to copy, modify and
redistribute granted by the license, users are provided only with a limited
warranty and the software’s author, the holder of the economic rights, and the
successive licensors have only limited liability.

In this respect, the user’s attention is drawn to the risks associated with
loading, using, modifying and/or developing or reproducing the software by the
user in light of its specific status of free software, that may mean that it is
complicated to manipulate, and that also therefore means that it is reserved for
developers and experienced professionals having in-depth computer knowledge.
Users are therefore encouraged to load and test the software’s suitability as
regards their requirements in conditions enabling the security of their systems
and/or data to be ensured and, more generally, to use and operate it in the same
conditions as regards security.

The fact that you are presently reading this means that you have had knowledge
of the CeCILL license and that you accept its terms.


Copyright
---------

* Copyright Biblibre, 2016-2017 (see [Biblibre])
* Copyright Daniel Berthereau, 2017-2023 (see [Daniel-KM] on GitLab)

This module was initially based on the fork of the module [Basket] from BibLibre.


[Selection]: https://gitlab.com/Daniel-KM/Omeka-S-module-Selection
[Omeka S]: https://omeka.org/s
[Generic]: https://gitlab.com/Daniel-KM/Omeka-S-module-Generic
[Guest]: https://gitlab.com/Daniel-KM/Omeka-S-module-Guest
[Bulk Export]: https://gitlab.com/Daniel-KM/Omeka-S-module-BulkExport
[Installing a module]: https://omeka.org/s/docs/user-manual/modules/#installing-modules
[module issues]: https://gitlab.com/Daniel-KM/Omeka-S-module-Selection/-/issues
[CeCILL v2.1]: https://www.cecill.info/licences/Licence_CeCILL_V2.1-en.html
[GNU/GPL]: https://www.gnu.org/licenses/gpl-3.0.html
[FSF]: https://www.fsf.org
[OSI]: http://opensource.org
[Basket]: https://github.com/BibLibre/Omeka-S-module-Basket
[Biblibre]: https://github.com/biblibre
[GitLab]: https://gitlab.com/Daniel-KM
[Daniel-KM]: https://gitlab.com/Daniel-KM "Daniel Berthereau"
