function testFunction(request, manifest, ...args) {
  if (!/\/set\//gi.test(request)) {
    return;
  }
  console.log(args);
  console.log(request);
  console.log(manifest);
  const { manifestJson } = manifest;
  console.log(manifestJson.__collection);
  //manifestJson.type = "Manifest";
  //manifest.type = "Manifest";
}

document.addEventListener("DOMContentLoaded", () => {
  if (!document.body.classList.contains("item")) {
    return false;
  }
  /* Don't use item sets either */
  if (document.body.classList.contains("item-set")) {
    return false;
  }
  updateHierarchy();
  updateSelectionBlock();
});

function updateHierarchy() {
  const sidebar = document.querySelector(".main-with-sidebar");
  const wrapper = document.createElement("div");
  const children = sidebar.children;
  wrapper.setAttribute("id", "cf_widget");
  [...children].forEach((child) => {
    wrapper.appendChild(child);
  });
  sidebar.appendChild(wrapper);
}

function updateSelectionBlock() {
  const selectionBlock = document.querySelectorAll(".selection")[0];
  if (!selectionBlock) {
    return;
  }
  const updateButton = selectionBlock.querySelector(
    ".item.resource > button.selection-update"
  );

  const buttonGrp = document.createElement("div");
  buttonGrp.classList.add("button-group", "cf-selection");
  updateButton.classList.add("button", "primary");
  buttonGrp.appendChild(updateButton);
  selectionBlock.insertAdjacentElement("beforebegin", buttonGrp);
  //parent.insertAdjacentElement("afterbegin", wrapper);
}
