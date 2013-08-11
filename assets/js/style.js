function hideAll(data) {
    $('input[type=text]').each(function() {
        var field_val = $(this).val();
        if ((field_val == '') || (field_val == 'undefined')) {
            field_val = 'Empty - Click to change';
        }
        if ($(this).is(':visible')) {
            if (data == 1) {
                $(this).next().show();
                $(this).next().html(field_val);
            }
            else {
                $(this).after('<span class="text_rep1" style="z-index:10">' + field_val + '</span>');
            }
        }
        $(this).hide();
    });
}

$(document).ready(function() {
    var icon_menu = '';

    $(".row").hover(function() {
        $(this).css('background-color', 'lightgray');
    });

    $(".row").mouseleave(function() {
        $(this).css('background-color', 'transparent');
    });



    if ($('#page-account').val() == 1) {
        hideAll(0);
        $('form').tooltip();
    }

    $('.text_rep1').click(function() {
        $(this).prev().show();
        $(this).prev().focus();
        $(this).hide();
    });

    $('input[type=submit]').click(function() {
        if ($('#page-account').val() == 1) {
            hideAll(1);
        }
    });

    $('p#service').tooltip();
    $('[id^=chart]').tooltip();
    $('tr').tooltip();
    $('.one_site_list').tooltip();
    $('.icon').tooltip();
    $('span#result_row').tooltip();

    if ($('#username')) {
        $('#username').focus();
    }

    if ($('#choose_interval')) {
        $('#choose_interval').hide();
    }

    if ($('[name=search_qry]')) {
        $('[name=search_qry]').focus();
    }

    if ($('#user-home').val() == 2) {
        $('#main_menu_bar').hide();
    }
    $('[id^=twitter-widget-0]').show(function() {
        $(this).css("width", "400px");
    });

});