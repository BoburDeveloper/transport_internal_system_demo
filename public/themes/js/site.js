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

var confirm_btn_msg = function(msg) {
   return confirm(msg);
}

var ascii_cymbols = function (id) {
    document.getElementById(id).addEventListener('input', function (e) {
        // Remove any non-ASCII character
        this.value = this.value.replace(/[^\x20-\x7E]/g, '');
    });
}

var ascii_uppercase_cymbols = function (id, modal_id) {
    document.getElementById(id).addEventListener('input', function () {
        const originalValue = this.value;
        let value = originalValue.toUpperCase();
        const updatedValue = value.replace(/[^A-Z0-9]/g, '');
        if (value !== updatedValue) {
            $(modal_id).modal('show');
            this.value = updatedValue; // Remove invalid characters
        } else {
            this.value = value;
        }
    });
}


$('.print-btn').on('click', function(){
    var classname = $(this).data('classname');
    printDiv(classname);
});

    function printDiv(divName) {
        var element = document.getElementsByClassName(divName);
        var i = 0;
        var printContents='';
        for (i = 0; i < element.length; i++) {
            var item = element[i].outerHTML;
            printContents +=  item;
        }
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

    }