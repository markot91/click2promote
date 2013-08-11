$(document).ready(function(){
    window.fbAsyncInit = function() {
        FB.init({appId: '272254766164453', status: true, cookie: true, xfbml: true});
        FB.Event.subscribe('auth.login', function(response) {});
        FB.Event.subscribe('auth.logout', function(response) {});
    };

    (function() {
        var e = document.createElement('script');
        e.type = 'text/javascript';
        e.src = document.location.protocol +
            '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());

    function loginFb(){
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                $('#facebook').val(response.authResponse.userID);
            }else if (response.status === 'not_authorized') {
                login();
            }
            else{
                login();
            }
        });
    }

    function login(){
        FB.login(function(response) {
            if (response.status === 'connected') {
                $('#facebook').val(response.authResponse.userID);
            } else {
                alert('User cancelled login or did not fully authorize.');
            }
        });
    }

        $('#facebook').click(function(){
            loginFb();
        });
    });