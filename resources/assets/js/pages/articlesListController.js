(function () {
    let publishArticle = function () {
        let self = $(this);
        swal({
                title: "Are you sure?",
                text: "Do you wish the selected article to be published on your CMS?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Publish",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                let articleId = self.data("article-id");
                let publishUrl = self.data("publish-url");
                $.ajax({
                    type: "POST",
                    url: publishUrl,
                    data: {articleId: articleId},
                    success: function (response) {
                        self.closest("td").siblings(".status").html(response.statusLabel);
                        self.addClass("hide");
                        self.siblings(".unpublish-article").removeClass("hide");
                        self.siblings(".preview").removeClass("hide");
                        swal("Published!", "The article has been successfully published.", "success");
                    },
                    error: function () {
                        swal("Oops!", "An error occurred.", "error");
                    }
                });
            });
    };

    let unpublishArticle = function () {
        let self = $(this);
        swal({
                title: "Are you sure?",
                text: "Do you wish the selected article to be unpublished from your CMS?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Unpublish",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                let articleId = self.data("article-id");
                let unpublishUrl = self.data("unpublish-url");
                $.ajax({
                    type: "POST",
                    url: unpublishUrl,
                    data: {articleId: articleId},
                    success: function (response) {
                        self.closest("td").siblings(".status").html(response.statusLabel);
                        self.addClass("hide");
                        self.siblings(".publish-article").removeClass("hide");
                        self.siblings(".preview").addClass("hide");
                        swal("Unpublished!", "The article has been successfully unpublished.", "success");
                    },
                    error: function () {
                        swal("Oops!", "An error occurred.", "error");
                    }
                });
            });
    };

    let confirmArticleDeletion = function () {
        let deleteLink = $(this).attr("href");
        swal({
                title: "Are you sure?",
                text: "You are about to delete the article.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Delete",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                window.location.href = deleteLink;
            });

        return false;

    };

    let initEvents = function () {
        let $body = $('body');
        $body.on('click', '.publish-article:not([disabled])', publishArticle);
        $body.on('click', '.unpublish-article', unpublishArticle);
        $body.on('click', '.articles-list .deleteBtn', confirmArticleDeletion);

    };

    initEvents();
})();