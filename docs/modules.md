## Adjustments for Modules (and configuration)

Required modules added:

* IIIF Server
* Image Server [require vips for better tiling]
* Common Module
* Blocks Disposition
* Universal Viewer

Modules removed:

* IIIF Presentation (conflicts with/duplicates IIIF Server)


TODO when deployed:

* Make sure all of these are enabled
* Crossing Fonds theme (which is just a copy of the Foundation theme) 

## Blocks disposition

<table>
  <tbody>
    <tr>
      <td>For item set show</td>
      <td>
`MetadataBrowse` `Comment` `Selection`
     </td>
    </tr>
    <tr>
      <td>For item show</td>
      <td>`UniversalViewer` `Collection` `Comment` `Contribute` `MetadataBrowse` `Selection` `Annotate`</td>
    </tr>
    <tr>
      <td>For media show</td>
      <td>[null]</td>
    </tr>
    <tr>
      <td>For item set browse</td>
      <td> `MetadataBrowse` </td>
    </tr>
    <tr>
      <td>For item browse</td>
      <td> `Contribute` </td>
    </tr>
  </tbody>
</table>

## Players

<table>
  <tbody>
    <tr>
      <td>Version of Universal Viewer</td>
      <td>Version 4</td>
    </tr>
    <tr>
      <td>Universal viewer config as json for v4</td>
      <td>

```json
{
  "options": {
    "dropEnabled": true,
    "footerPanelEnabled": false,
    "headerPanelEnabled": false,
    "leftPanelEnabled": true,
    "limitLocales": false,
    "overrideFullScreen": false,
    "pagingEnabled": true,
    "rightPanelEnabled": false,
    "attributionEnabled": false
    },
  "modules": {
    "headerPanel": {
      "options": {
        "localeToggleEnabled": false
      }
    },
    "seadragonCenterPanel": {
      "options": {
        "autoHideControls": true,
        "attributionEnabled": false
      }
    }
  }
}
```
  </td>
    </tr>
    <tr>
      <td>Use Universal Viewer config from the theme for v4 (deprecated)</td>
      <td>[unchecked]</td>
    </tr>
  </tbody>
</table>


<details>

<summary>Notes / Old Configurations</summary>

## Mirador 

```json
{
    "window": {
        "allowClose": false,
        "allowFullscreen": true,
        "allowMaximize": false,
        "allowTopMenuButton": true,
        "allowWindowSideBar": false,
        "sideBarPanel": "info",
        "defaultSideBarPanel": "attribution",
        "sideBarOpenByDefault": false,
        "defaultView": "single",
        "forceDrawAnnotations": false,
        "highlightAllAnnotations": false,
        "showLocalePicker": true,
        "sideBarOpen": false,
        "switchCanvasOnSearch": true,
        "imageToolsEnabled": true,
        "panels": {
            "info": true,
            "attribution": true,
            "canvas": true,
            "annotations": true,
            "search": true,
            "layers": true
        }
    },
    "thumbnailNavigation": {
        "defaultPosition": "off",
        "displaySettings": true
    },
    "workspace": {
        "showZoomControls": true,
        "allowNewWindows": false,
        "isWorkspaceAddVisible": false
    },
    "workspaceControlPanel": {
        "enabled": false
    }
}
```

Interacting with the iiifServer to get public URL:

```
$iiifUrl = $plugins->get('iiifUrl');
$iiifUrl($resource, '', $VERSION) 
```
</details>