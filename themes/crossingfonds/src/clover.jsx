import React, { useLayoutEffect, useRef, useEffect } from "react";
import Viewer from "@samvera/clover-iiif/viewer";
import register from "preact-custom-element"

/** Override the AudioPlayer, since the wavform doesn't work */
const AudioPlayer = {
  display: {
    component: ({id, annotationBody, ...rest}) => {
      return (
        <audio src={annotationBody.id} controls/>
      );
    }
  },
  target: {
    paintingFormat: ["audio/mpeg", "audio/mp3"]
  }
}

/** No built-in handling for PDFs, so we just use an iframe */
const PDFViewer = {
    display: {
      component: ({id, annotationBody, ...rest}) => {
        return (
          <div style="height: 100%">
            <iframe src={annotationBody.id} type="application/pdf" data={annotationBody.id} width="100%" height="100%"/>
          </div>
      );
      }
    },
    target: {
      paintingFormat: ["application/pdf"],
    }
  };


const customDisplays = [ PDFViewer, AudioPlayer];


function CloverViewerWebComponent(props) {
  const webComponent = useRef();
  const { id } = props;
  const options = {
    showTitle: false,
    canvasHeight: '100%',
    showIIIFBadge: false,
    informationPanel: {
      open: false,
      renderToggle: false
    }
  }
  const canvasIdCallback = (id) => {
    /** Crude callback to know we've loaded everything */
    if (id){
      document.body.classList.add('clover-loaded');
    }
  }


  useLayoutEffect(() => {
    if (props.__registerPublicApi) {
      props.__registerPublicApi((component) => {
        webComponent.current = component;
      });
    }
  }, []);

  // @ts-ignore
  return <Viewer id={id} 
  canvasIdCallback={canvasIdCallback}
  options={options} customDisplays={customDisplays} />;
}

const cloverViewerWCProps = ["id"];

if (typeof window !== "undefined") {
  register(CloverViewerWebComponent, "clover-viewer", cloverViewerWCProps, {
    shadow: false,
    onConstruct(instance) {
      instance._props = {
        __registerPublicApi: (api) => {
          Object.assign(instance, api(instance));
        },
      };
    },
  });
}