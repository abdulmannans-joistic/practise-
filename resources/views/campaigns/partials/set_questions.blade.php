<div class="set-questions-section">
    <div class="container row" id="addQuestions">
        <div class="headingCampaign center">
            <h2>Set Questions</h2>
        </div>

        <div id="questionBoxes"></div>

        <div class="d-flex justify-content-between align-items-center col-12 mt-2">
            <ul>
                <li>4 Questions Mandatory</li>
                <li>Maximum 4 words with 30 characters</li>
                <li class="text-danger">Please select the right answer</li>
            </ul>
            <button class="btn btn-type-two" id="addQuestionBtn">Add Question</button>
        </div>

        <div class="center mt-4">
            <input type="hidden" name="campaign_id" id="campaign_id" value="" >
            <button class="btn btn-type-one" id="submitQuestionsBtn">Submit</button>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {

    let questionIndex = 0;

    function addQuestion() {
        $('.question-box.collapse.show').collapse('hide');

        questionIndex++;
        let questionHeader = $(`
            <div class="col-12 questionHeaderContainer" id="Question${questionIndex}Container">
                <div class="d-flex justify-content-between align-items-center question-toggle" style="border-top: 1px solid #06B516; border-bottom: 1px solid #06B516; padding: 20px;">
                    <h3 class="questionTitle"></h3>
                    <a class="primaryColor toggle-question" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseQuestion${questionIndex}">Question ${questionIndex}</a>
                </div>
            </div>
        `);

        let questionBox = $(`<div class="question-box collapse" id="collapseQuestion${questionIndex}"></div>`);
        questionBox.html(`
            <div class="p-3 pb-0 fs28 fw-700 orange">Question ${questionIndex}</div>
            <div class="question-content">
                <input type="text" name="questions[${questionIndex}][text]" placeholder="Enter your question here" class="form-control question-input" style="border-radius: 10px;"/>
                <div class="choices-container" id="choicesContainer${questionIndex}">
                    <!-- Choices will be added here -->
                </div>
            </div>
        `);

        $('#questionBoxes').append(questionHeader, questionBox);
        for (let i = 0; i < 3; i++) { // Adding 3 choices by default
            addChoice(questionIndex);
        }

        questionBox.collapse('show');
    }

    window.addChoice = function(questionId) {
    let choicesContainer = $(`#choicesContainer${questionId}`);
    let choiceIndex = choicesContainer.children('.row').length; // Ensure it selects only row elements
    let isRightAnswerLabelNeeded = choiceIndex === 0; // Add label only for the first choice item
    let rightAnswerLabel = isRightAnswerLabelNeeded ? '' : '';

    let choiceItem = $(`
        <div class="row align-items-center mb-2 choice-item">
            <div class="col-1 text-center">
                ${choiceIndex + 1}
            </div>
            <div class="col-9">
            <input type="text" name="questions[${questionId}][choices][${choiceIndex}][text]" class="form-control choice-input" style="border-radius: 10px;" placeholder="Type Your Options Here" />
            </div>
            <div class="col-2 text-center">
                <div class="form-check">
                    <input class="form-check-input choice-radio" type="radio" name="questions[${questionId}][correct_choice]" value="${choiceIndex}" id="choice${questionId}-${choiceIndex}">
                    ${rightAnswerLabel}
                </div>
            </div>
        </div>
    `);
    choicesContainer.append(choiceItem);
    
    // If it's the first choice item, append the "Select right answer" label above the choices
    if (isRightAnswerLabelNeeded) {
        let selectRightAnswerLabel = $(`
            <div class="row">
                <div class="col-12 text-right">
                    <label>Select right answer</label>
                </div>
            </div>
        `);
        choicesContainer.prepend(selectRightAnswerLabel);
    }
};


$(document).on('click', '.toggle-question', function() {
        let target = $(this).data('target');
        // Automatically close other collapses when one is opened
        $('.question-box.collapse').not(target).collapse('hide');
        $(target).collapse('toggle');
    });

$('#addQuestionBtn').on('click', addQuestion);



$('#submitQuestionsBtn').on('click', function() {
    let questions = [];
    $('.question-box').each(function(index) {
        let questionText = $(this).find('.question-input').val();
        let choices = [];
        let correctAnswer = $(this).find('.choice-radio:checked').val();

        $(this).find('.choice-item').each(function(choiceIndex) {
            let is_correct = (correctAnswer == choiceIndex);
            choices.push({
                text: $(this).find('.choice-input').val(),
                is_correct: is_correct
            });
        });

        if (questionText !== '') {
            questions.push({ text: questionText, choices: choices });
        }
    });

    console.log(JSON.stringify({ questions: questions })); // Debugging line to view the payload before sending

    if(questions.length > 0) {
        $.ajax({
            url: '/campaigns/' + $('#campaign_id').val() + '/questions',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ questions: questions }),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if(response.success) {
                    // $('#define-campaign-container').find('.form-content').hide();
                    // $('.set-questions-section').find('.form-content-ques').hide();
                    // $('#get-qr-code-container').html(response.qr_code_html).show();

                    $('#set-questions-container').hide();
                    $('#get-qr-code-container').html(response.qr_code_html).show();
        
                    // Update the stepper
                    $('.step-number').removeClass('stepActive');
                    $('#step3').addClass('stepActive'); // Activate Invite Candidates
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                console.error('Error saving questions:', xhr.responseText);
            }
        });
    } else {
        console.error('No questions to submit');
    }
});

    // Initialize the first question
    addQuestion();
});

    
    </script>