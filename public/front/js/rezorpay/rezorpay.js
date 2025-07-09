$(document).ready(function () {
    // Get Razorpay Key
    const KEY_ID = $("[name='KEY_ID']").val();

    // Trigger Razorpay Payment
    $('.rezorpay-btn').click(function (e) {
        e.preventDefault();

        // Retrieve input values
        const name = $("[name='name']").val();
        const email = $("[name='email']").val();
        const contact = $("[name='contacts']").val();
        const amount = $("[name='amount']").val();
        const sitename = $("[name='sitename']").val();
        const sitelogo = $("[name='sitelogo']").val();

        if (!name || !email || !contact || !amount) {
            toastr.error("Please fill all required fields.");
            return;
        }

        // Razorpay options
        const options = {
            "key": KEY_ID, // Key ID from Razorpay Dashboard
            "amount": (amount * 100).toFixed(0), // Convert amount to paise (integer)
            "currency": "INR",
            "name": sitename,
            "description": "Thank You For ordering from us",
            "image": sitelogo, // Company logo
            "handler": function (pay_response) {
                console.log("Payment Response:", pay_response);
                $('#razorpay_payment_id').val(pay_response.razorpay_payment_id); // Assign payment ID
                $('#myf').submit(); // Submit the form
            },
            "prefill": {
                "name": name,
                "email": email,
                "contact": contact
            },
            "theme": {
                "color": "#3399cc" // Customize theme color
            }
        };

        // Open Razorpay modal
        const rzp1 = new Razorpay(options);
        rzp1.open();
    });

    // Handle Form Submission with AJAX
    $("#myf").on('submit', function (e) {
        e.preventDefault();

        const form = this;

        $.ajax({
            url: form.action,
            type: "POST",
            data: new FormData(form),
            dataType: "json",
            headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('.submit_button').hide();
                $('.loading').show();
            },
            success: function (result) {
                if (result.success) {
                    toastr.success(result.message);
                    window.location.replace(result.redirect);
                } else {
                    toastr.error(result.message);
                }
                $('.submit_button').show();
                $('.loading').hide();
            },
            error: function (e) {
                toastr.error('Something went wrong.');
                console.error("Error:", e);
                $('.submit_button').show();
                $('.loading').hide();
            }
        });
    });

    $('.rezorpay-btn').click();

});
