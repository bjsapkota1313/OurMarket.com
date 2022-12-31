
function showLoginFailed(){
    const currentDiv=document.getElementById("rememberMe");
    var newDiv=document.createElement("div");
    newDiv.className="alert-danger";
    newDiv.style.color="red";
    newDiv.innerHTML="Incorrect Details";
    currentDiv.appendChild(newDiv);
}
function handleLoginForm() {
    console.log("Ït working");
    // Get the form data
    const email = document.getElementById("floatingInput").value;
    const password = document.getElementById("floatingPassword").value;

    // Send an HTTP request to the server
    const data={email:email,password:password};
    fetch( "http://localhost/home/login",{
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)

    }).then(result=> {
    console.log(result);
        })
}
