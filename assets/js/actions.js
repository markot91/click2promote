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


/**
 * Solution borrowed from :
 * 
 * http://stackoverflow.com/a/11381730
 */
function is_mobile() {
    var check = false;
    (function(a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4)))
            check = true
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
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
    $("a#get_stats_one_site").unbind('click').on("click", function(e) {
        e.preventDefault();
        console.log("clicked");
        var link = $(this).prev().children("[name=link]").val();
        var index = $(this).prev().children("[name=id]").val();
        var session = $("#session-id").html();
        var user = $(this).prev().children("[name=user_id]").val();
        var admin_id = $("#user-id").html();
        var getStatsSingle = $("#get_stats_single").html();
        $.post(
                getStatsSingle,
                {
                    "link": link,
                    "index": index,
                    "session": session,
                    "user_id": user,
                    "admin_id": admin_id
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

