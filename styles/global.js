const togglePassword = () => {
    const passwordInput = document.getElementById('password');
    const toggleButton = document.getElementById('toggle-password');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleButton.innerHTML = "toggle";
    } else {
        passwordInput.type = 'password';
        toggleButton.innerHTML = "toggle";
    }
}

document.addEventListener('DOMContentLoaded', () => {
        console.log('test')
    const myImage = document.querySelector('#my-image');
    const myMenu = document.getElementById('menu');
        rotation=0;
    myImage.addEventListener('click', () => {
        rotation += 90;
        myImage.style.transform = `rotate(${rotation}deg)`;

        if (myMenu.style.width === '20%') {
            myMenu.style.width = '0%';
            myImage.style.zIndex = '1';
        } else {
            myMenu.style.width = '20%';
            myImage.style.zIndex = '2';
        }
    });
})

// Text to be typed out
const text = "Hello, world! This is a typing animation.";

// Delay between each letter (in milliseconds)
const delay = 100;

// Get the text container element
const textContainer = document.getElementById('text-container');

// Function to simulate typing animation
function typeText() {
    let index = 0;
    const timer = setInterval(() => {
        textContainer.textContent += text[index];
        index++;
        if (index >= text.length) {
            clearInterval(timer);
        }
    }, delay);
}





