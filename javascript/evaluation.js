// Popup Window
document.addEventListener('DOMContentLoaded', function() {

    var explainBtns = document.querySelectorAll('.scoreExplain');

    explainBtns.forEach(button => {
        button.addEventListener('click', function() {
            var card = this.closest('.evalCard') // Get the closest parent evalCard
            var LLO = card.querySelector('h3').textContent;
            var percenatge = card.querySelector('.scorePer').getAttribute('per');

            // Update popup Content
            var popup = document.getElementById('popup');
            popup.querySelector('.popupContent h3 span').textContent = percenatge;
            popup.querySelector('.popupContent h3 span').nextElementSibling.textContent = LLO;

            popup.style.display = 'block'; // Show the popup


            var closeBtn = document.querySelector('.close'); 
            closeBtn.addEventListener('click', function() { // Close popup widnow upon clicking X
                popup.style.display = 'none';
            });

            window.addEventListener('click', function (event) { // Close popup widnow upon clicking anywhere in the screen 
                if(event.target == popup){
                    popup.style.display = 'none';
                }
            })
        });
    });

});