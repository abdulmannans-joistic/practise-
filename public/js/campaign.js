$(document).ready(function() {
    $('#campaign-form').submit(function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        const $errorMessagesDiv = $('#error-messages');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': formData.get('_token')
            },
            success: function(data) {
                if (data.success) {
                    // Hide define campaign and show set questions
                    $('#define-campaign-container').hide();
                    $('#set-questions-container').html(data.next_section_html).show();

                    $('.step-number').removeClass('stepActive');
                    $('#step2').addClass('stepActive'); // Set Questions becomes active
                    
                    $('#campaign_id').val(data.campaign_id);
                } else {
                    $errorMessagesDiv.html(data.message);
                }
            },
            error: function(xhr) {
                $errorMessagesDiv.html(xhr.responseText);
            }
        });
    });

    $('#define-campaign-heading').on('click', function() {
        $('#define-campaign-container').find('.form-content').toggle(); 
    });
    
});
