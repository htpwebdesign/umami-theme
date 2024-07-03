document.addEventListener('DOMContentLoaded', (event) => {
    setTimeout(() => {
        var elements = document.querySelectorAll('body *');
        elements.forEach((element) => {
            if (element.children.length === 0 && element.textContent.includes('Shipping')) {
                element.textContent = element.textContent.replace(/Shipping/g, 'Delivery');
            }
        });
    }, 500);
});