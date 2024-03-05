// Get the login form element by its id
var loginForm = document.getElementById("login-form");
// Get the sign up form element by its id
var signupForm = document.getElementById("signup-form");
// Get the show sign up link element by its id
var showSignup = document.getElementById("show-signup");
// Get the show login link element by its id
var showLogin = document.getElementById("show-login");

// Add a click event listener to the show sign up link
showSignup.addEventListener("click", function() {
    // Hide the login form
    loginForm.style.display = "none";
    // Show the sign up form
    signupForm.style.display = "block";
});

// Add a click event listener to the show login link
showLogin.addEventListener("click", function() {
    // Hide the sign up form
    signupForm.style.display = "none";
    // Show the login form
    loginForm.style.display = "block";
});
