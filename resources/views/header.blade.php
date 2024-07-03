<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example API</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</head>
<style>
    .hidden {
        display: none;
    }
</style>
<form action="" id="logout_form">
    <button class="" id="logout_button">Logout</button>
</form>


<script>
    // logout user
    $(document).ready(function() {
        $('#logout_form').click((e) => {
            e.preventDefault();
            $.ajax({
                url: "http://127.0.0.1:8000/api/logout",
                type: "POST",
                headers: {
                    'Authorization': localStorage.getItem('user_token')
                },
                success: function(data) {
                    if (data.success == true) {
                        localStorage.removeItem('user_token');
                        window.open('/login', '_self');
                    } else {
                        alert(data.msg)
                    }
                    console.log(data);
                }

            });
        });
    });


    var token = localStorage.getItem('user_token');

    // if there is token, let the user be on profile page, else redirect user to login
    let path = window.location.pathname;
    if (path == '/login' || path == '/register') {

        if (token != null) {
            window.open('/profile', '_self');
        }
        $('#logout_button').hide();

    } else {
        if (token == null) {
            window.open('/login', '_self');
        }
    }
    // console.log(path);
    if (path == '/login' || path == 'register') {
        console.log('hide button');
        // $('#logout_button').toggleClass('hidden');
    }
</script>