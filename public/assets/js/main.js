// Add any dynamic javascript features here

document.addEventListener('DOMContentLoaded', () => {
    // Smooth transition initialization
    console.log("Bisha Restaurant Loaded Successfully.");

    // Flash message timeout (if we had any)
    const flashMessages = document.querySelectorAll('.alert');
    if (flashMessages.length > 0) {
        setTimeout(() => {
            flashMessages.forEach(msg => {
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 300);
            });
        }, 3000);
    }
});
