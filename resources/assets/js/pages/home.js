import '../bootstrap';

let handleLogoutBtnClick = function () {
    $("#log-out").click(function (e) {
        e.preventDefault();
        $("#logout-form").submit();
    });
}
let init = function () {
    handleLogoutBtnClick();
};

$(document).ready(function () {
    init();
});
