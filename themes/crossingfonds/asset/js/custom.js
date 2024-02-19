/** Sigh, using JQuery */

(function () {
  $(document).ready(function () {
    const mirador = document.querySelector(".mirador");
    const selectionBlock = document.querySelectorAll(".selection")[0];
    const updateButton = selectionBlock.querySelector(
      ".item.resource > button.selection-update"
    );
    if (!mirador || !selectionBlock) {
      return;
    }
    const wrapper = document.createElement("div");
    wrapper.setAttribute("id", "cf_widget");
    const buttonGrp = document.createElement("div");
    buttonGrp.classList.add("button-group", "cf-selection");
    const parent = mirador.parentNode;
    updateButton.classList.add("button", "primary");
    buttonGrp.appendChild(updateButton);
    parent.insertAdjacentElement("afterbegin", wrapper);
    wrapper.appendChild(mirador);
    wrapper.appendChild(buttonGrp);
    //* TODO: Add a view full selection button
    // (which would popup a modal, I think, that shows all of the items in a grid)
  });
})();
