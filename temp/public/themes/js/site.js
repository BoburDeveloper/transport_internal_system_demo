function numbers_type() {
    // float
    $('.float, .currency-inputmask').on('input', function() {
        this.value = this.value.replace(/[^0-9.-]/g, '').replace(/(\..*?)\..*/g, '$1');
    });

// float positive
    $('.float-positive, .currency-inputmask').on('input', function() {
        this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    });

// integer
    $('.integer').on('input', function() {
        this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1');
    });


// integer positive
    $('.integer-positive').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
    });
}

numbers_type();


function refreshCaptcha(){
    $.ajax({
        url: lang_url+"/ajax/refreshcaptcha",
        type: 'get',
        dataType: 'html',
        data: {'_token': csrf_token},
        success: function(data) {
            $('#captcha-img img').attr('src', data);
        },
        error: function(data) {
            alert('Try Again.');
        }
    });
}
