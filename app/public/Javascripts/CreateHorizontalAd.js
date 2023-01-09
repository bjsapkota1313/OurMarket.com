 export function createHorizontalAdCard(ad) {
    // Create the main card element
    let card = document.createElement("div");
    card.classList.add("card", "mb-3");
    card.style.maxWidth = "900px";
    card.style.position = "relative";

    // Create the inner row element
    let row = document.createElement("div");
    row.classList.add("row", "g-0");
    card.appendChild(row);

    // Create the image column element
    let imageCol = document.createElement("div");
    imageCol.classList.add("col-md-4", "col-xl-4");
    row.appendChild(imageCol);

    // Create the image element
    let image = document.createElement("img");
    image.src = ad.imageUri;
    image.classList.add("img-fluid", "rounded-start");
    imageCol.appendChild(image);

    // Create the details column element
    let detailsCol = document.createElement("div");
    detailsCol.classList.add("col-md-8", "col-xl-8", "d-flex", "flex-column", "justify-content-around");
    row.appendChild(detailsCol);

    // Create the details body element
    let detailsBody = document.createElement("div");
    detailsBody.classList.add("card-body");
    detailsCol.appendChild(detailsBody);

    // Create the product name element
    let productName = document.createElement("h5");
    productName.classList.add("card-title");
    productName.textContent = ad.productName;
    detailsBody.appendChild(productName);

    // Create the product description element
    let productDescription = document.createElement("p");
    productDescription.classList.add("card-text");
    productDescription.textContent = ad.description;
    detailsBody.appendChild(productDescription);

    // Create the list group element
    let listGroup = document.createElement("ul");
    listGroup.classList.add("list-group", "list-group-flush");
    detailsBody.appendChild(listGroup);

    // Create the price list item element
    let priceListItem = document.createElement("li");
    priceListItem.classList.add("list-group-item");
    priceListItem.innerHTML = '<strong>Price:</strong> €' + ad.price.toFixed(2);
    listGroup.appendChild(priceListItem);

    // Create the status list item element
    let statusListItem = document.createElement("li");
    statusListItem.classList.add("list-group-item");
    statusListItem.innerHTML = '<strong>Status:</strong> ' + ad.status;
    listGroup.appendChild(statusListItem);

    // Create the posted date list item element
    let postedDateListItem = document.createElement("li");
    postedDateListItem.classList.add("list-group-item");
    postedDateListItem.innerHTML = '<strong>Posted at: </strong>' + ad.postedDate;
    listGroup.appendChild(postedDateListItem);

    // Create the button container element
    let buttonContainer = document.createElement("div");
    buttonContainer.classList.add("d-flex", "justify-content-end", "mb-2");
    detailsCol.appendChild(buttonContainer);

    return [card, buttonContainer];
}