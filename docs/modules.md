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
      <th>For item set show</th>
      <td>`MetadataBrowse` `Comment` `Selection`</td>
    </tr>
    <tr>
      <th>For item show</th>
      <td>`UniversalViewer` `Collection` `Comment` `Contribute` `MetadataBrowse` `Selection` `Annotate`</td>
    </tr>
    <tr>
      <th>For media show</th>
      <td>[null]</td>
    </tr>
    <tr>
      <th>For item set browse</th>
      <td> `MetadataBrowse` </td>
    </tr>
    <tr>
      <th>For item browse</th>
      <td> `Contribute` </td>
    </tr>
  </tbody>
</table>

## Players

<table>
  <tbody>
    <tr>
      <th>Version of Universal Viewer</th>
      <td>Version 4</td>
    </tr>
    <tr>
      <th>Universal viewer config as json for v4</th>
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
      <th>Use Universal Viewer config from the theme for v4 (deprecated)</th>
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