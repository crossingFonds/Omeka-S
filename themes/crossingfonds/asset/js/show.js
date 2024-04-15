(function($) {
    $(document).ready(function() {        
        const lgContainer = document.getElementById('itemfiles');

        const inlineGallery = lightGallery(lgContainer, {
            selector: '.media.resource',
            plugins: [lgThumbnail, lgVideo, lgZoom],
            thumbnail: true,
            container: lgContainer,
            hash: false,
            closable: false,
            showMaximizeIcon: true,
            appendSubHtmlTo: '.lg-item',
            captions: true,
            slideDelay: 400,
            allowMediaOverlap: false
        });  

        inlineGallery.openGallery();
    });
  })(jQuery)

  document.addEventListener("DOMContentLoaded", function() {
      const dtElements = document.querySelectorAll("dt.property");
      let hoveredContent = "";

      dtElements.forEach(function(dt) {
        dt.addEventListener("mouseover", function() {
          hoveredContent = this.textContent.trim();
          console.log("Hovered content:", hoveredContent);


        });
      });
    });

// console.log("Hovered content:");
