document.addEventListener("DOMContentLoaded", function () {
    const registrationForm = document.getElementById("registration-form");
    const loginForm = document.getElementById("login-form");
  
    registrationForm.addEventListener("submit", function (e) {
      const password = registrationForm.querySelector("input[name='password']").value;
      const confirmPassword = registrationForm.querySelector("input[name='confirm_password']").value;
  
      if (password !== confirmPassword) {
        e.preventDefault();
        alert("Passwords do not match");
      }
    });
  });
  