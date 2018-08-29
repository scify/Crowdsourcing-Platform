(function () {

    let socialShareHandler = function() {
        $("body").on("click", ".social-share-button", function (e) {
            let dataElement = $('.social-share');
            let url = dataElement.data('href');
            let questionnaireId = dataElement.data('questionnaireid');
            let postShareURL = dataElement.data('postshareurl');
            if($(this).hasClass('fb-share-button')) {
                shareToFacebook(url, questionnaireId, postShareURL);
            } else if($(this).hasClass('twitter-share-button')) {
                shareToTwitter(url, questionnaireId, postShareURL);
            }
        });
    };

    let shareToFacebook = function(url, questionnaireId, postShareURL) {
        FB.ui({
            method: 'share',
            href: url,
        }, function(response){
            if(response) {
                // the user shared the questionnaire,
                // so we should do an AJAX call to handle the action
                postShareAction(questionnaireId, postShareURL);
            }
        });
    };

    let shareToTwitter = function(url, questionnaireId, postShareURL) {
        window.open("https://twitter.com/share?url="+escape(url)+
            "&text="+document.title, '', 'resizable=yes,scrollbars=yes,height=400,width=600');
        postShareAction(questionnaireId, postShareURL);
    };

    let postShareAction = function(questionnaireId, postShareURL) {
        $.ajax({
            method: "POST",
            url: postShareURL,
            cache: false,
            data: {'questionnaire-id': questionnaireId},
            beforeSend: function () {
            },
            success: function (response) {
                console.log(response);
            },
            error: function (xhr, status, errorThrown) {
                console.log(errorThrown);
            }
        });
    };

    let init = function () {
        socialShareHandler();
    };

    init();
})();