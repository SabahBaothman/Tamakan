// Popup Window
document.addEventListener('DOMContentLoaded', function () {

    var explainBtns = document.querySelectorAll('.scoreExplain');

    explainBtns.forEach(button => {
        button.addEventListener('click', function () {
            var card = this.closest('.evalCard') // Get the closest parent evalCard
            var LLO = card.querySelector('h3').textContent;
            var percenatge = card.querySelector('.scorePer').getAttribute('per');
            var comm = card.getAttribute('comment');
            var exp = card.getAttribute('data-explain');

            // Update popup Content
            var popup = document.getElementById('popup');
            popup.querySelector('.popupContent h3 span').textContent = percenatge;
            popup.querySelector('.popupContent h3 span').nextElementSibling.textContent = LLO;

            // Update the comments in the first paragraph
            var commentsParagraph = popup.querySelector('.popupContent p');
            commentsParagraph.innerHTML = "<strong>Comments:</strong><br><br>" + comm.replace(/\n/g, "<br>");

            // Update the explanation in the next paragraph
            var explanationParagraph = commentsParagraph.nextElementSibling;
            explanationParagraph.innerHTML = "<strong>Improvements:</strong><br><br>" + exp.replace(/\n/g, "<br>");

            // Show the popup
            popup.style.display = 'block'; // Show the popup


            var closeBtn = document.querySelector('.close');
            closeBtn.addEventListener('click', function () { // Close popup widnow upon clicking X
                popup.style.display = 'none';
            });

            window.addEventListener('click', function (event) { // Close popup widnow upon clicking anywhere in the screen 
                if (event.target == popup) {
                    popup.style.display = 'none';
                }
            })
        });
    });

});