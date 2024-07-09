document.getElementById('main-lessons').addEventListener('input', function() {
    const numLessons = parseInt(this.value);
    const addLlos = document.getElementById('add-llos');

    // Clear existing dynamically added lesson blocks
    while (addLlos.children.length > 0) {
        addLlos.removeChild(addLlos.lastChild);
    }

    // Add new lesson blocks
    if (!isNaN(numLessons)) {
        for (let i = 1; i <= numLessons; i++) {
            addLessonBlock(i, addLlos);
        }
    }
});

function addLessonBlock(lessonNumber, container) {
    // Create lesson title block
    const lessonTitleDiv = createInputBlock('lesson_title_' + lessonNumber, 'Lesson ' + lessonNumber + ':', 'text', 'Enter Lesson ' + lessonNumber + ' Title');
    container.appendChild(lessonTitleDiv);

    // Create slides number block
    const slidesDiv = createSlidesBlock(lessonNumber);
    container.appendChild(slidesDiv);

    // Create LLOs block
    const lloDiv = createInputBlock('llo_' + lessonNumber, 'Lesson Learning Outcomes (LLOs) ' + lessonNumber + ':', 'text', 'Add LLOs for Lesson ' + lessonNumber);
    container.appendChild(lloDiv);
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
    const slidesFromInput = createInput('slides_from_' + lessonNumber, 'number', 'From', 'slides-input');
    const slidesToInput = createInput('slides_to_' + lessonNumber, 'number', 'To', 'slides-input');
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
