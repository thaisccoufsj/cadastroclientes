$(document).ready(function() {
    $(document).on('click', "[data-clear-form-button]", function (e) {
        $(this).parent().find(':input, :radio').each(function(index, element) {
            if ($(element).is(':checked') && $(element).is(':checked')) {
                $(element).prop('checked', false);
            } else if (!$(element).is(':radio')) {
                $(element).val('');
            }
        });
    });
});