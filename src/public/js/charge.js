document.addEventListener("DOMContentLoaded", function () {
    let successMessage = document.querySelector('.success__message');

    if (successMessage) {
        let stripeButton = document.querySelector('.stripe-button-el');
        if (stripeButton) {
            stripeButton.disabled = true;
            stripeButton.style.opacity = '0.5';
            stripeButton.style.pointerEvents = 'none';
        }
    }
});