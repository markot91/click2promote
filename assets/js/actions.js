/**
 *  user defined actions, mostly ajax
 */
function charts(reseta) {
    var stats = new Array;
    $.post($('#chart-url').val(), {
        'site_id': $('#site-id').val(),
        'session_id': $('#session-id').val()
    },
    function(data) {
        chart = data;
        stats = data;
        //  if logged in from another place
        if (data.site_details_changed == "validation_error") {
            window.location = 'http://click2promote.me/index.php/login/logout#c2p-about';
        }
        var fb = new Array();
        var tw = new Array();
        var bn = new Array();
        var gog = new Array();
        var youtube = new Array();
        var date = new Array();
        var x_axis = new Array();

        var count = 1;
        if (chart) {
            $.each(chart, function(key, value) {
                x_axis.push(count);
                fb.push([value.date.substr(0, 10), (value.fb / 10000000)]);
                tw.push([value.date.substr(0, 10), (value.tw / 10000000)]);
                gog.push([value.date.substr(0, 10), (value.gog / 10000000)]);
                bn.push([value.date.substr(0, 10), (value.bn / 10000000)]);
                youtube.push([value.date.substr(0, 10), (value.youtube)]);
                date.push(value.date.substr(0, 10));
                count++;
            });
        }

        if (fb[0]) {
            var chartfb = $.jqplot('chartfb', [fb], {
                title: 'Facebook (x 10,000,000)',
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer
                    }
                }
            });
        }
        else {
            $('#chartfb').html('<div>No Facebook data</div>');
        }
        if (tw[0]) {
            var charttw = $.jqplot('charttw', [tw], {
                title: 'Twitter (x 10,000,000)',
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer
                    }
                }
            });
        }
        else {
            $('#charttw').html('<div>No Twitter data</div>');
        }
        if (bn[0]) {
            var chartbing = $.jqplot('chartbing', [bn], {
                title: 'Bing (x 10,000,000)',
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer
                    }
                }
            });
        }
        else {
            $('#chartbing').html('<div>No Bing data</div>');
        }
        if (gog[0]) {
            var chartgoggle = $.jqplot('chartgoogle', [gog], {
                title: 'Google (x 10,000,000)',
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer
                    }
                }
            });
        }
        else {
            $('#chartgoogle').html('<div>No Google data</div>');
        }
        if (youtube[0]) {
            var chartyoutube = $.jqplot('chartyoutube', [youtube], {
                title: 'Youtube (x 10,000,000)',
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer
                    }
                }
            });
        }
        else {
            $('#chartyoutube').html('<div>No Youtube data </div>');
        }
        $('.load').hide();
        $('#chart_holder').css('padding-bottom', '160px');
    }, 'json'
            );
}
function tables() {
    $.post($('#chart-url').val(), {
        'site_id': $('#site-id').val(),
        'session_id': $('#session-id').val()
    },
    function(data) {
        chart = data;
        var x_axis = new Array();
        var count = 1;
        if (chart) {
            $.each(chart, function(key, value) {
                x_axis.push(count);
                $('#chartfb_table').html($('#chartfb_table').html() + '<tr><td>' + value.date + '</td><td class="result">' + value.fb + '</td></tr>');
                $('#chartfb_table').css('margin-top', '30px');
                $('#charttw_table').html($('#charttw_table').html() + '<tr><td>' + value.date + '</td><td class="result">' + value.tw + '</td></tr>');
                $('#charttw_table').css('margin-top', '30px');
                $('#chartgoogle_table').html($('#chartgoogle_table').html() + '<tr><td>' + value.date + '</td><td class="result">' + value.gog + '</td></tr>');
                $('#chartgoogle_table').css('margin-top', '30px');
                $('#chartbing_table').html($('#chartbing_table').html() + '<tr><td>' + value.date + '</td><td class="result">' + value.bn + '</td></tr>');
                $('#chartbing_table').css('margin-top', '30px');
                $('#chartyoutube_table').html($('#chartyoutube_table').html() + '<tr><td>' + value.date + '</td><td class="result">' + value.youtube + '</td></tr>');
                $('#chartyoutube_table').css('margin-top', '30px');
                $('tr').css('border-bottom', '2px solid #000');
                count++;
            });

        }
        else {
            $('[id^=chart]').html('There is no data for the given period!');
        }
        $('.load').hide();
        $('#chart_holder').css('padding-bottom', '160px');
    }, 'json'
            );
}

function getURLParameter(name) {
    return decodeURI(
            (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search) || [, null])[1]
            );
}
function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
$(document).ready(function() {
    var chart = null;
    var sess_id = 0;
    $('form').submit(function(e) {
        if (($(this).attr('id') != 'report_interval') && ($(this).attr('id') != 'back_form')
                && ($(this).attr('id') != 'search_form') && ($(this).attr('id') != 'clear_form')
                && ($(this).attr('id') != 'paypal') && ($(this).attr('id') != 'payza')
                && ($(this).attr('id') != 'mijnformuliertje')
                && ($(this).attr('id') != 'reset_password')
                && ($(this).attr('id') != 'email_form')
                && ($(this).attr('id') != 'login')) {
            e.preventDefault();
        }
    });

    $('#history_title').css('margin', '55px');
    if (($('#session-id').val() != 'undefined') && ($('#session-id').val() != '')) {
        sess_id = $('#session-id').val();
    }

    if (($('#user-home').val() != 'undefined') && ($('#user-home').val() != '') && ($('#user-home').val() == '1')) {
        $('#date_from').datepicker();
        $('#date_to').datepicker();
        charts(false);
    }
    if (($('#user-home').val() != 'undefined') && ($('#user-home').val() != '') && ($('#user-home').val() == '2')) {
        $('[class^=chart]').hide();
        $('#nav').hide();
        tables();
        var table = getURLParameter('chart');
        $('.' + table + '_table').show();
    }
    //  update site details
    $('#form_update_site').bind('click', function() {
        var url = $('#site_details').attr('action');
        var form_data = $('#site_details').serialize() + '&session_id=' + sess_id;
        $.post(url, form_data, function(data) {
            if (data.site_details_changed == 'OK') {
                $.msgBox({
                    title: "Data Saved",
                    content: "Site details saved!",
                    autoClose: true
                });
            }
            else {
                $.msgBox({
                    title: "Whooooopsy!",
                    content: "There was an error while trying to save site details.Please try again soon!",
                    type: "error",
                    showButtons: false,
                    opacity: 0.9,
                    autoClose: true
                });
            }
        }, 'json');
    });

    //  update user details / user
    $('#form_update_user').bind('click', function() {
        var url = $('#account_details').attr('action');
        var form_data = $('#account_details').serialize() + '&session_id=' + sess_id;
        $.post(url, form_data, function(data) {
            if (data.details_update == 'OK') {
                $.msgBox({
                    title: "Data Saved",
                    content: "Personal details saved!",
                    autoClose: true
                });
            }
            else {
                $.msgBox({
                    title: "Whooooopsy!",
                    content: "There was an error while trying to save personal details.Please try again soon!",
                    type: "error",
                    showButtons: false,
                    opacity: 0.9,
                    autoClose: true
                });
            }
        }, 'json');
    });

    //  update password
    $('#form_update_password').bind('click', function() {
        var url = $('#change_pass_form').attr('action');
        var form_data = $('#change_pass_form').serialize() + '&session_id=' + sess_id;
        $.post(url, form_data, function(data) {
            if (data.password_change == 'OK') {
                $.msgBox({
                    title: "Data Saved",
                    content: "Password updated!",
                    autoClose: true
                });
            }
            else {
                $.msgBox({
                    title: "Whooooopsy!",
                    content: "There was an error while trying to update your password.Please try again soon!",
                    type: "error",
                    showButtons: false,
                    opacity: 0.9,
                    autoClose: true
                });
            }
        }, 'json');
    });

    //  TODO: votes
    $('.one_site_list').click(function() {
        $(this).attr('id', 'try_to_vote');
        var sid = $(this).attr('sid');
        var owner_id = $('#site-id').val();
        var vote_url = $('#vote-url').val();
        var session_id = $('#session-id').val();
        var form_data = 'site_voted=' + sid + '&site_voter=' + owner_id + '&user_act=vote&session_id=' + session_id;
        $.post(vote_url,
                form_data,
                function(data) {
                    if (data.vote_success == 'OK') {
                        $('#try_to_vote').remove();
                    }
                    else {
                        $.msgBox({
                            title: "Whooooopsy!",
                            content: "There was an error while trying to vote. Please try again soon!",
                            type: "error",
                            showButtons: false,
                            opacity: 0.9,
                            autoClose: true
                        });
                    }
                },
                'json');
    });

    //  admin: activate/deactivate user
    $('a#actve_deactive').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('url');
        $.get(url, function() {
            window.location.reload();
        });
    });
    //  admin: reset user's password
    $('a#reset_pass').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('url');
        $.get(url, function(data) {
            if (data.reset_password == 'OK') {
                window.location.reload()
            }
            else {
                $.msgBox({
                    title: "Whooooopsy!",
                    content: "There was an error while trying to update your password.Please try again soon!",
                    type: "error",
                    showButtons: false,
                    opacity: 0.9,
                    autoClose: true
                });
            }
        },
                "json");
    });

    // send contact email
    $('#c2p-send.submit-button').click(function() {
        var mail = $('#c2p-myemail').val();
        var message = $('#c2p-mymessage').val();
        if (mail != '' && message != '' && IsEmail(mail)) {
            $.post("http://click2promote.me/index.php/home/contact",
                    {
                        email: mail, 
                        poraka: message
                    },
            function() {
                $('#c2p-myemail').val('');
                $('#c2p-mymessage').val('');
                $.msgBox({
                    title: "We will get back to you ASAP!",
                    content: "Your message was sent!",
                    showButtons: false,
                    autoClose: true
                });
            });
        }
        else {
            if ($('#c2p-myemail').val() == '') {
                $.msgBox({
                    title: "Whooooopsy!",
                    content: "Please enter Your e-mail address!",
                    type: "error",
                    showButtons: false,
                    opacity: 0.9,
                    autoClose: true
                });
            }
            else {
                if (!IsEmail($('#c2p-myemail').val())) {
                    $.msgBox({
                        title: "Whooooopsy!",
                        content: "Please enter valid e-mail address!",
                        type: "error",
                        showButtons: false,
                        opacity: 0.9,
                        autoClose: true
                    });
                }
                else
                if ($('#c2p-mymessage').val() == '') {
                    $.msgBox({
                        title: "Whooooopsy!",
                        content: "Please enter Your message!",
                        type: "error",
                        showButtons: false,
                        opacity: 0.9,
                        autoClose: true
                    });
                }
            }
        }
    });
    //  allow the user to see details
    $('#chart_holder').unbind('click');
    $('[id^=chart]').click(function() {
        if ($(this).attr('id') == 'chart_holder') {
            return false;
        }
        window.open(document.URL + '/reports?chart=' + $(this).attr('id'), 'name', 'height=600,width=800');
    });

    //  TODO: search
    //  search now works
    //  only in admin section
    $('#advanced_search_show').click(function(e) {
        e.preventDefault();
        if ($('#advanced_search').is(':visible')) {
            $('#advanced_search').hide();
        }
        else {
            $('#advanced_search').show();
        }
    });

    //  TODO: admin page, update site stats
    $("a#get_stats_one_site").unbind('click').on("click",function(e) {
        e.preventDefault();
        console.log("clicked");
        var link = $(this).prev().children("[name=link]").val();
        var index = $(this).prev().children("[name=id]").val();
        var session = $("#session-id").html();
        var user =  $(this).prev().children("[name=user_id]").val();
        var admin_id = $("#user-id").html();
        var getStatsSingle = $("#get_stats_single").html();
        $.post(
                getStatsSingle,
                {
                    "link": link, 
                    "index": index, 
                    "session": session, 
                    "user_id": user,
                    "admin_id":admin_id
                },
        function(data) {
            if (data.status == "OK") {
                $.msgBox({
                    title: "Success!",
                    content: "Stats updated!",
                    autoClose: true
                });
            }
            else {
                $.msgBox({
                    title: "Whooooopsy!",
                    content: "Something went wrong, " + data.reason,
                    type: "error",
                    showButtons: false,
                    opacity: 0.9,
                    autoClose: true
                });

            }
        },
                "json");
    });

    //  on window resize,
    //  resize charts
    $(window).resize(function() {
        $("li div[id^=chart]").html('');
        charts(true);
    });
});

