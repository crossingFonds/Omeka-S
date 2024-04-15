// function hoverDescription() {
// document.addEventListener("DOMContentLoaded", function() {
//   const dtElements = document.querySelectorAll("dt.property");
//   let hoveredContent = "";

//   dtElements.forEach(function(dt) {
//     dt.addEventListener("mouseover", function() {
//       hoveredContent = this.textContent.trim();
//       console.log("Hovered content:", hoveredContent);
//     });
//   });
//  }
// }

document.addEventListener("DOMContentLoaded", function() {
  const dtElement = document.getElementById("hoverElement");

  dtElement.addEventListener("mouseover", function() {
    console.log("hi");
  });
});
