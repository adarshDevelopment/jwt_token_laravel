@include('header')

<h1>Log In </h1>

<style>
    span {
        color: red;
    }
</style>

<form id="login_form">

    <input type="email" name="email" placeholder="Enter Email">
    <br>
    <span class="error email_err"></span>
    <br>

    <input type="password" name="password" placeholder="Enter Password">
    <br>
    <span class="error password_err"></span>

    <br>
    <button>Log in</button>
</form>
<br>
<p class="result">

</p>

<script>
    $().ready(function() {
        $('#login_form').submit(e => {
            e.preventDefault();
            console.log($(this));
            // let formData = $(this).serialize(); // form data
            var formData = new FormData($('#login_form')[0])
            // console.log('hello world');
            // console.log(formData.name);

            // for (const pair of formData.entries()) {
            //     console.log(pair[0], pair[1]);
            // }

            // console.log('outside ajax');

            $.ajax({
                url: "http://127.0.0.1:8000/api/login",
                type: "POST",
                contentType: false,
                processData: false,
                data: formData,
                success: function(data) {
                    if (data.success == false) {
                        $('.result').text(data.msg);

                    } else if (data.success == true) {
                        // setting token on loccal storage
                        localStorage.setItem("user_token", data.token_type + " " + data.access_token);
                        $('.result').text(data.msg);
                        window.open('/profile', '_self');


                    }
                    printErrorMsg(data);


                }
            });
        })

        function printErrorMsg(msg) {
            $('.error').text('');
            $.each(msg, (k, v) => {
                $("." + k + "_err").text(v);
            });
        }

    });
</script>