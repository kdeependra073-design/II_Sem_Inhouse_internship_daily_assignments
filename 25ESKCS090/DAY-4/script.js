// DOM Elements Selection
const themeToggleBtn = document.getElementById('theme-toggle');
const joinForm = document.getElementById('joinForm');

// 1. DARK MODE LOGIC
// Check local storage for existing preference
const currentTheme = localStorage.getItem('theme');
if (currentTheme === 'dark') {
    document.body.classList.add('dark-theme');
    themeToggleBtn.textContent = '☀️ Light Mode';
}

// Toggle Theme on Button Click
themeToggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme');
    
    let theme = 'light';
    if (document.body.classList.contains('dark-theme')) {
        theme = 'dark';
        themeToggleBtn.textContent = '☀️ Light Mode';
    } else {
        themeToggleBtn.textContent = '🌙 Dark Mode';
    }
    
    // Save selection in browser localStorage
    localStorage.setItem('theme', theme);
});


// 2. FORM VALIDATION LOGIC
joinForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Stop form from auto-reloading page

    const nameInput = document.getElementById('username');
    const emailInput = document.getElementById('useremail');
    
    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    
    let isValid = true;

    // Validate Name (Should not be empty)
    if (nameInput.value.trim() === "") {
        nameError.textContent = "Name cannot be empty.";
        nameError.style.display = "block";
        isValid = false;
    } else {
        nameError.style.display = "none";
    }

    // Validate Email (Should include @)
    if (!emailInput.value.includes('@') || emailInput.value.trim() === "") {
        emailError.textContent = "Please enter a valid email address containing '@'.";
        emailError.style.display = "block";
        isValid = false;
    } else {
        emailError.style.display = "none";
    }

    // Success Action
    if (isValid) {
        alert(`Thank you, ${nameInput.value}! Your registration request has been received.`);
        joinForm.reset();
    }
});