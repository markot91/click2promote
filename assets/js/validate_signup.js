var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var can_signup = false;

function promocount() {
    $.ajax({
        url: "http://localhost/cp/index.php/users/promocount",
        type: "GET",
        dataType: "json"
    }).done(function(data) {
        if (data.count > 50) {
            can_signup = false;
            $.msgBox({
                title: "Promo period is over!",
                content: "Unfortunately we have more than enough users for now. Please be sure to check again soon.",
                type: "confirm",
                buttons: [{value: "OK"}, {value: "Cancel"}],
                success: function(result) {
                    if (result == "OK") {
                        window.location = "http://click2promote.me/";
                    }
                }
            });

        }
    });
}

function check_password_length(password) {
    if (password.length > 6) {
        $('#user_password_check').html('OK');
        can_signup = true;
    }
    else {
        $('#user_password_check').html('Your password is not secure enough!!!');
        can_signup = false;
    }
}

function check_password_match(password) {
    if ((password == $('#password').val())) {
        $('#user_password_check1').html('OK');
        can_signup = true;
    }
    else {
        $('#user_password_check1').html('Passwords don\'t match!!!');
        can_signup = false;
    }
}

function valid_email_address(email) {
    if (re.test(email)) {
        $.get($('#check_email').val() + '?email=' + email,
                function(json) {
                    if (json.response == "OK") {
                        $('#email_check').html('OK');
                        can_signup = true;
                    }
                    else {
                        $('#email_check').html('This email address is already used!');
                        can_signup = false;
                    }
                },
                "json"
                );
    }
    else {
        $('#email_check').html('This is not a valid e-mail address!');
        can_signup = false;
    }
}

function site_exist(url) {
    $.get($('#check_url').val() + '?url=' + url,
            function(json) {
                if (json.response == "OK") {
                    $('#site_check').html('OK');
                    can_signup = true;
                }
                else {
                    $('#site_check').html('This URL is already registered!');
                    can_signup = false;
                }
            },
            "json"
            );
}

$(document).ready(function() {
    $('#youremail').change(function() {
        valid_email_address($(this).val());
    });
    $('#youremail').keyup(function() {
        valid_email_address($(this).val());
    });

    $('#password').change(function() {
        check_password_length($(this).val());
    });
    $('#password').keyup(function() {
        check_password_length($(this).val());
    });

    $('#password-again').change(function() {
        check_password_match($(this).val());
    });
    $('#password-again').keyup(function() {
        check_password_match($(this).val());
    });

    $('#siteurl').change(function() {
        site_exist($(this).val());
    });
    $('#siteurl').keyup(function() {
        site_exist($(this).val());
    });

    $('#yourname').keyup(function() {
        if ($(this).val() != '' || $(this).val() != 'undefined') {
            can_signup = true;
        }
    });
    $("#complete_signup").click(function(){
        promocount();
    });

    $('#mijnformuliertje').submit(function(e) {
        if (can_signup == false) {
            e.preventDefault();
        }
    });
});