function disableLoginButton() {
    const loginLink = document.getElementById("loginLink");
    const p = document.createElement("p");
    p.className = "dropdown-item";
    p.innerHTML = "Logged";
    const loginLinkId = loginLink.getAttribute("id");

// Set the id of the p element to be the same as the loginLink element
    p.setAttribute("id", loginLinkId);
    loginLink.parentNode.replaceChild(p, loginLink);
    document.getElementById("signOut").disabled = false;
}

function enableLogin() {
    document.getElementById("signOut").disabled = true;
    const p = document.getElementById("loginLink");
    const a = document.createElement("a");
    a.className = "dropdown-item";
    a.innerHTML = "Log In";
    a.href = "/home/login";
    const loginLinkId = p.getAttribute("id");
    a.setAttribute("id", loginLinkId);
    p.parentNode.replaceChild(a, p);

}

function resetPostNewAddForm() {
    // Reset form elements
    document.querySelector('#postNewAddForm').reset();
}

function hidePostNewAd() {
    document.getElementById("buttonPostNewAd").hidden = true;
    const divCol = document.getElementById("buttonHolder");
    const a = document.createElement("a");
    a.href = "login";
    a.className = "btn btn-success btn-lg px-4 gap-3";
    a.innerHTML = "Log In";
    divCol.appendChild(a);

}

function showPostNewAd() {
    document.getElementById("buttonPostNewAd").hidden = false;
}

function postNewAdd() {
    // Prevent the default form submission behavior
    event.preventDefault();
    var inputLoggedUserId = document.getElementById("hiddenLoggedUserId").textContent;
    var inputLoggedUserName = document.getElementById("loggedUserName").textContent;
    const inputProductName = escapeHtml(document.getElementById("productName").value);
    const inputPrice = escapeHtml(document.getElementById("price").value);
    const inputProductDescription = escapeHtml(document.getElementById("productDescription").value);
    const imageInput = document.getElementById("image").files[0];
    const data = {
        productName: inputProductName,
        price: inputPrice,
        productDescription: inputProductDescription,
        loggedUserId: inputLoggedUserId,
        loggedUserName: inputLoggedUserName
    };
    var formData = new FormData();
    formData.append("image", imageInput);
    formData.append("adDetails", JSON.stringify(data));


    // Send a POST request to the server with the form data
    fetch('http://localhost/api/adsapi', {
        method: 'POST',
        body: formData,
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (responseData) {
            if (responseData.success) {
                document.getElementById("close").click();
                alert(responseData.message);
            } else {
                console.error(responseData.message);
                alert(responseData.message);
            }
        });
}

function loadAdsOfLoggedUser() {
    event.preventDefault();
    const inputLoggedUserId = document.getElementById("hiddenLoggedUserId").textContent;
    let data = {loggedUserId: inputLoggedUserId}
    // Send a POST request to the server with logged user and promising the ads as response of logged user
    fetch('http://localhost/api/adsbyloggeduser', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(response =>response.json())
        .then(ads => {
            document.getElementById("myAdsContainer").innerHTML=""; // clearing screen
            // Handling the ads data here
            ads.forEach(function (ad) {
                console.log(ad);
                if(ad.status="Available"){
                    displayAvailableAds(ad);
                }
                else{
                    displayOtherStatusAds(ad);
                }

            })
        })

}

function escapeHtml(str) {
    var map =
        {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
    return str.replace(/[&<>"']/g, function (m) {
        return map[m];
    });
}

function allowDrop(event) {
    // Prevent default behavior of the event (prevent the file from being opened)
    event.preventDefault();
}

function dropFile(event) {
    // Get the file object that was dropped
    const file = event.dataTransfer.files[0];
    // Set the file object as the value of the file input element
    document.getElementById("image").files[0] = file;
}

function displayOtherStatusAds(ad) {
    const myAdsContainer = document.getElementById("myAdsContainer");
    let requireElements = createHorizontalAdCard(ad);
    let card=requireElements[0];
    let buttonContainer=requireElements[1];

// Create the "Mark As Sold" button element
    var markAsSoldButton = document.createElement("button");
    markAsSoldButton.classList.add("btn", "btn-primary", "mx-2");
    markAsSoldButton.disabled = true;
    markAsSoldButton.textContent = "Mark As Sold";
    buttonContainer.appendChild(markAsSoldButton);

// Create the "Edit" button element
    var editButton = document.createElement("button");
    editButton.classList.add("btn", "btn-secondary", "mx-2");
    editButton.disabled = true;
    editButton.innerHTML = '<i class="fa-solid fa-file-pen"></i> Edit';
    buttonContainer.appendChild(editButton);

// Create the "Delete" button element
    var deleteButton = document.createElement("button");
    deleteButton.classList.add("btn", "btn-danger", "mx-2");
    deleteButton.disabled = true;
    deleteButton.innerHTML = '<i class="fa-solid fa-trash"></i> Delete';
    buttonContainer.appendChild(deleteButton);

// Create the overlay element
    var overlay = document.createElement("div");
    overlay.classList.add("overlay");
    overlay.style.position = "absolute";
    overlay.style.top = 0;
    overlay.style.left = 0;
    overlay.style.right = 0;
    overlay.style.bottom = 0;
    overlay.style.backgroundColor = "rgba(0,0,0,0.5)";
    overlay.style.display = "flex";
    overlay.style.alignItems = "center";
    overlay.style.justifyContent = "center";
    card.appendChild(overlay);


// Create the status element
    var status = document.createElement("h2");
    status.style.color = "white";
    status.textContent = ad.status;
    overlay.appendChild(status);
    myAdsContainer.appendChild(card);
}
function displayAvailableAds(ad){
    const myAdsContainer = document.getElementById("myAdsContainer");
    let requireElements = createHorizontalAdCard(ad);
    let card=requireElements[0];
    let buttonContainer=requireElements[1];

    // button Mark as Sold
    var btnMarkAsSold = document.createElement("button");
    btnMarkAsSold.type = "submit";
    btnMarkAsSold.classList.add("btn", "btn-primary", "mx-2");
    btnMarkAsSold.id = "btnMarkAsSold";
    btnMarkAsSold.name = "btnMarkAsSold";
    btnMarkAsSold.textContent = "Mark As Sold";
    buttonContainer.appendChild(btnMarkAsSold);
    // button Edit
    var btnEdit = document.createElement("button");
    btnEdit.classList.add("btn", "btn-secondary", "mx-2");
    var iconEdit = document.createElement("i");
    iconEdit.classList.add("fa-solid", "fa-file-pen");
    btnEdit.appendChild(iconEdit);
    btnEdit.innerHTML += " Edit";
    buttonContainer.appendChild(btnEdit);
    //button dDelete
    var btnDelete = document.createElement("button");
    btnDelete.classList.add("btn", "btn-danger", "mx-2");
    btnDelete.id = "btnDeleteAd";
    var iconDelete = document.createElement("i");
    iconDelete.classList.add("fa-solid", "fa-trash");
    iconDelete.name = "btnDeleteAd";
    btnDelete.appendChild(iconDelete);
    btnDelete.innerHTML += " Delete";
    buttonContainer.appendChild(btnDelete);
    myAdsContainer.appendChild(card);

}
function createHorizontalAdCard(ad){
    // Create the main card element
    var card = document.createElement("div");
    card.classList.add("card", "mb-3");
    card.style.maxWidth = "900px";
    card.style.position = "relative";

    // Create the inner row element
    var row = document.createElement("div");
    row.classList.add("row", "g-0");
    card.appendChild(row);

    // Create the image column element
    var imageCol = document.createElement("div");
    imageCol.classList.add("col-md-4", "col-xl-4");
    row.appendChild(imageCol);

    // Create the image element
    var image = document.createElement("img");
    image.src = ad.imageUri;
    image.classList.add("img-fluid", "rounded-start");
    imageCol.appendChild(image);

    // Create the details column element
    var detailsCol = document.createElement("div");
    detailsCol.classList.add("col-md-8", "col-xl-8", "d-flex", "flex-column", "justify-content-around");
    row.appendChild(detailsCol);

    // Create the details body element
    var detailsBody = document.createElement("div");
    detailsBody.classList.add("card-body");
    detailsCol.appendChild(detailsBody);

    // Create the product name element
    var productName = document.createElement("h5");
    productName.classList.add("card-title");
    productName.textContent = ad.productName;
    detailsBody.appendChild(productName);

    // Create the product description element
    var productDescription = document.createElement("p");
    productDescription.classList.add("card-text");
    productDescription.textContent = ad.description;
    detailsBody.appendChild(productDescription);

    // Create the list group element
    var listGroup = document.createElement("ul");
    listGroup.classList.add("list-group", "list-group-flush");
    detailsBody.appendChild(listGroup);

    // Create the price list item element
    var priceListItem = document.createElement("li");
    priceListItem.classList.add("list-group-item");
    priceListItem.innerHTML = '<strong>Price:</strong> €' + ad.price.toFixed(2);
    listGroup.appendChild(priceListItem);

    // Create the status list item element
    var statusListItem = document.createElement("li");
    statusListItem.classList.add("list-group-item");
    statusListItem.innerHTML = '<strong>Status:</strong> ' + ad.status;
    listGroup.appendChild(statusListItem);

    // Create the posted date list item element
    var postedDateListItem = document.createElement("li");
    postedDateListItem.classList.add("list-group-item");
    postedDateListItem.innerHTML = '<strong>Posted at: </strong>' + ad.postedDate;
    listGroup.appendChild(postedDateListItem);

    // Create the button container element
    var buttonContainer = document.createElement("div");
    buttonContainer.classList.add("d-flex", "justify-content-end", "mb-2");
    detailsCol.appendChild(buttonContainer);

    return [card,buttonContainer];
}