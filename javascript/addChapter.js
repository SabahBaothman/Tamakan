

document.getElementById('main-lessons').addEventListener('input', function() {
    const numLessons = parseInt(this.value);

    const addLlos = document.getElementById('add-llos');

    // Calculate the current number of lesson blocks dynamically added.
    // Since the initial set is not included in dynamic additions, subtract 1 from current count
    const currentLessonCount = Math.floor((addLlos.children.length / 3) - 1);

    if (!isNaN(numLessons)) {
        // If the number of lessons is increased, add new blocks
        if (numLessons > currentLessonCount + 1) {
            for (let i = currentLessonCount + 2; i <= numLessons; i++) {
                addLessonBlock(i, addLlos);
            }
        }
        // If the number of lessons is decreased or zero, adjust blocks appropriately
        else if (numLessons < currentLessonCount + 1) {
            if (numLessons == 0) {
                // If zero, remove all dynamically added blocks
                while (addLlos.children.length > 3) {
                    removeLessonBlock(addLlos);
                }
            } else {
                // Remove excess blocks above the entered number
                for (let i = currentLessonCount + 1; i > numLessons; i--) {
                    removeLessonBlock(addLlos);
                }
            }
        }
    }
});

function addLessonBlock(lessonNumber, container) {
    // Create lesson title block
    const lessonTitleDiv = createInputBlock('lesson-title-' + lessonNumber, 'Lesson ' + lessonNumber + ':', 'text', 'Enter Lesson ' + lessonNumber + ' Title');
    container.appendChild(lessonTitleDiv);

    // Create slides number block
    const slidesDiv = createSlidesBlock(lessonNumber);
    container.appendChild(slidesDiv);

    // Create LLOs block
    const lloDiv = createInputBlock('llo-' + lessonNumber, 'Lesson Learning Outcomes (LLOs) ' + lessonNumber + ':', 'text', 'Add LLOs for Lesson ' + lessonNumber);
    container.appendChild(lloDiv);
}

function removeLessonBlock(container) {
    // Remove the last 3 divs (a complete lesson block)
    for (let i = 0; i < 3; i++) {
        container.removeChild(container.lastElementChild);
    }
}

function createInputBlock(id, labelText, type, placeholder) {
    const div = document.createElement('div');
    div.classList.add('input-block');
    const label = document.createElement('label');
    label.setAttribute('for', id);
    label.textContent = labelText;
    const input = createInput(id, type, placeholder);
    div.appendChild(label);
    div.appendChild(input);
    return div;
}

function createSlidesBlock(lessonNumber) {
    const slidesDiv = document.createElement('div');
    slidesDiv.classList.add('input-block');
    const slidesLabel = document.createElement('label');
    slidesLabel.textContent = 'Slides Number:';
    const slidesBlockDiv = document.createElement('div');
    slidesBlockDiv.classList.add('slides-block');
    const slidesFromInput = createInput('slides-from-' + lessonNumber, 'number', 'From', 'slides-input');
    const slidesToInput = createInput('slides-to-' + lessonNumber, 'number', 'To', 'slides-input');
    slidesBlockDiv.appendChild(slidesFromInput);
    slidesBlockDiv.appendChild(slidesToInput);
    slidesDiv.appendChild(slidesLabel);
    slidesDiv.appendChild(slidesBlockDiv);
    return slidesDiv;
}

function createInput(id, type, placeholder, className = '') {
    const input = document.createElement('input');
    input.setAttribute('type', type);
    input.setAttribute('id', id);
    input.setAttribute('name', id);
    input.setAttribute('placeholder', placeholder);
    if (className) input.classList.add(className);
    return input;
}
