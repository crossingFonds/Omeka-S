## Adjustments for Modules (and configuration)

Required modules added:

* IIIF Server
* Image Server [require vips for better tiling]
* Common Module
* Blocks Disposition
* Mirador

Modules removed:

* IIIF Presentation (conflicts with/duplicates IIIF Server)


TODO when deployed:

* Make sure all of these are enabled

* Crossing Fonds theme (which is just a copy of the Foundation theme) 


Mirador 

```json
{
    "requests": {
        "postprocessors": [testFunction]
    },
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
// $VERSION = "2" | "3" 
```

Two options: 

1. Just get the public URLs and then collect them into a Collection (simplest);
2. Potentially better would be to have all of these as a single Manifest, in which one could see all images (and set the viewer to have a full gallery view versus a single page)


Universal Viewer config:

```json
{
  "options": {
    "dropEnabled": true,
    "footerPanelEnabled": true,
    "headerPanelEnabled": true,
    "leftPanelEnabled": true,
    "limitLocales": false,
    "overrideFullScreen": false,
    "pagingEnabled": true,
    "rightPanelEnabled": true, // May want false?
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
        "autoHideControls": false,
        "attributionEnabled": false
      }
    }
  }
}
```
