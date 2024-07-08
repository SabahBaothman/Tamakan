

document.getElementById('main-lessons').addEventListener('input', function() {
    const numLessons = parseInt(this.value);
    const addLlos = document.getElementById('add-llos');
    const currentLessonCount = addLlos.children.length / 3;

    if (!isNaN(numLessons) && numLessons > currentLessonCount) {
        for (let i = currentLessonCount + 1; i <= numLessons; i++) {
            const lessonTitleDiv = document.createElement('div');
            lessonTitleDiv.classList.add('input-block');

            const lessonTitleLabel = document.createElement('label');
            lessonTitleLabel.setAttribute('for', 'lesson-title-' + i);
            lessonTitleLabel.textContent = 'Lesson ' + i + ':';

            const lessonTitleInput = document.createElement('input');
            lessonTitleInput.setAttribute('type', 'text');
            lessonTitleInput.setAttribute('id', 'lesson-title-' + i);
            lessonTitleInput.setAttribute('name', 'lesson_title_' + i);
            lessonTitleInput.setAttribute('placeholder', 'Enter Lesson ' + i + ' Title');

            lessonTitleDiv.appendChild(lessonTitleLabel);
            lessonTitleDiv.appendChild(lessonTitleInput);

            addLlos.appendChild(lessonTitleDiv);

            const slidesDiv = document.createElement('div');
            slidesDiv.classList.add('input-block');

            const slidesLabel = document.createElement('label');
            slidesLabel.setAttribute('for', 'slides-number-' + i);
            slidesLabel.textContent = 'Slides Number:';

            const slidesBlockDiv = document.createElement('div');
            slidesBlockDiv.classList.add('slides-block');

            const slidesFromInput = document.createElement('input');
            slidesFromInput.setAttribute('type', 'number');
            slidesFromInput.setAttribute('id', 'slides-from-' + i);
            slidesFromInput.setAttribute('name', 'slides_from_' + i);
            slidesFromInput.setAttribute('placeholder', 'From');
            slidesFromInput.classList.add('slides-input');

            const slidesToInput = document.createElement('input');
            slidesToInput.setAttribute('type', 'number');
            slidesToInput.setAttribute('id', 'slides-to-' + i);
            slidesToInput.setAttribute('name', 'slides_to_' + i);
            slidesToInput.setAttribute('placeholder', 'To');
            slidesToInput.classList.add('slides-input');

            slidesBlockDiv.appendChild(slidesFromInput);
            slidesBlockDiv.appendChild(slidesToInput);

            slidesDiv.appendChild(slidesLabel);
            slidesDiv.appendChild(slidesBlockDiv);
            addLlos.appendChild(slidesDiv);

            const lloDiv = document.createElement('div');
            lloDiv.classList.add('input-block');

            const lloLabel = document.createElement('label');
            lloLabel.setAttribute('for', 'llo-' + i);
            lloLabel.textContent = 'Lesson Learning Outcomes (LLOs) ' + i + ':';

            const lloInput = document.createElement('input');
            lloInput.setAttribute('type', 'text');
            lloInput.setAttribute('id', 'llo-' + i);
            lloInput.setAttribute('name', 'llo_' + i);
            lloInput.setAttribute('placeholder', 'Add LLOs for Lesson ' + i);

            lloDiv.appendChild(lloLabel);
            lloDiv.appendChild(lloInput);

            addLlos.appendChild(lloDiv);
        }
    }
});

