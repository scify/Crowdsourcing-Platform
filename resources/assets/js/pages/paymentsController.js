(function () {
    let buyerPaymentReceived = function () {
        let self = $(this);
        swal({
                title: "Are you sure?",
                text: "Do you wish to indicate the selected purchase's amount as received from buyer?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Proceed",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                let purchaseId = self.data("id");
                let url = self.data("url-received-payment");
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {purchaseId},
                    success: function () {
                        self.attr('disabled', 'disabled').attr('title', 'The buyer\'s payment has been received')
                            .removeClass('btn-danger').addClass('btn-success');
                        swal("Payment received!", "The payment has been successfully received.", "success");
                    },
                    error: function () {
                        swal("Oops!", "An error occurred.", "error");
                    }
                });
            });
    };

    let creatorHasBeenPaid = function () {
        let self = $(this);
        swal({
                title: "Are you sure?",
                text: "Do you wish to indicate the selected purchase's amount as sent to the article's creator?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Proceed",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                let purchaseId = self.data("id");
                let url = self.data("url-sent-payment");
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {purchaseId},
                    success: function () {
                        self.attr('disabled', 'disabled').attr('title', 'The creator\'s payment has been sent')
                            .removeClass('btn-danger').addClass('btn-success');
                        swal("Payment sent!", "The payment has been successfully sent.", "success");
                    },
                    error: function () {
                        swal("Oops!", "An error occurred.", "error");
                    }
                });
            });
    };

    let initEvents = function () {
        let $body = $('body');
        $body.on('click', '.btn-buyer', buyerPaymentReceived);
        $body.on('click', '.btn-creator', creatorHasBeenPaid);
    };

    initEvents();
})();