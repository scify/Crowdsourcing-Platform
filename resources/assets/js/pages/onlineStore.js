(function () {
    let buyArticle = function () {
        let self = $(this);
        swal({
                title: "Are you sure?",
                text: "Do you really want to buy the selected article?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Yes, buy now",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                let articleId = self.data("article-id");
                let buyUrl = self.data("buy-url");
                $.ajax({
                    type: "POST",
                    url: buyUrl,
                    data: {article_id: articleId},
                    success: function (response) {
                        if (response.purchaseCompleted) {
                            swal({
                                    title: "Success",
                                    text: "The article has been successfully bought.",
                                    type: "success",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Show new article",
                                    cancelButtonText: "Continue shopping",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                },
                                function () {
                                    window.location = window.location.href.replace(window.location.pathname, '/' + response.redirectUrl);
                                });
                        } else {
                            swal("Oops!", response.validationMessage, "error");
                        }
                    },
                    error: function () {
                        swal("Oops!", "An error occurred.", "error");
                    }
                });
            });
    };
    let initEvents = function () {
        let $body = $('body');
        $body.on('click', '.buy-article-btn', buyArticle);
    };
    initEvents();
})();