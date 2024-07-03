@include('header')

<h1>User Registration</h1>

<style>
    span {
        color: red;
    }
</style>

<form id="register_form">
    <input type="text" name="name" placeholder="Enter name">
    <br>
    <span class="error name_err"></span>
    <br>

    <input type="email" name="email" placeholder="Enter Email">
    <br>
    <span class="error email_err"></span>
    <br>

    <input type="password" name="password" placeholder="Enter Password">
    <br>
    <span class="error password_err"></span>

    <br>
    <input type="password" name="password_confirmation" placeholder="Confirm Password">
    <br>
    <span class="error password_confirmation_err"></span>

    <br>
    <button>Submit</button>
</form>
<br>
<p class="result">

</p>

<script>
    $().ready(function() {
        $('#register_form').submit(e => {
            e.preventDefault();
            console.log($(this));
            // let formData = $(this).serialize(); // form data
            var formData = new FormData($('#register_form')[0])
            // console.log('hello world');
            // console.log(formData.name);

            // for (const pair of formData.entries()) {
            //     console.log(pair[0], pair[1]);
            // }

            // console.log('outside ajax');

            $.ajax({
                url: "http://127.0.0.1:8000/api/register",
                type: "POST",
                contentType: false,
                processData: false,
                data: formData,
                success: function(data) {
                    if (data.msg) {
                        $('.error').text('');
                        $('.result').text(data.msg);
                        $('#register_form')[0].reset(); // reset not working


                    } else {
                        printErrorMsg(data);
                    }
                }
            });
        })

        function printErrorMsg(msg) {
            $('.error').text('');
            $.each(msg, (k, v) => {
                $("." + k + "_err").text(v);

                if (key == 'password') {
                    if (v.length > 1) {
                        $(".password_err").text(v[0]);
                        $(".password_confirmation_err").text(v[0]);

                    } else {

                    }
                }
            })
        }

    });
</script>