window.wa ={};
window.wa.enums = {};
window.swal = require('bootstrap-sweetalert');
require('datatables.net-bs' );
require('datatables.net-buttons');
require("icheck");

//if jquery ui is loaded make sure it doesnt conflict with bootstrap button
//$.widget.bridge('uibutton', $.ui.button);

//load dependencies for template
require("bootstrap");
// require("jquery-slimscroll");
require("fastclick");
require('admin-lte'); // 'admin-lte/dist/js/app.min.js'

(function(){

    Number.prototype.round = function(places) {
        return +(Math.round(this + "e+" + places)  + "e-" + places);
    }

    window.wa.roundNumber = function(num, places) {
        return +(Math.round(parseFloat(num) + "e+" + places)  + "e-" + places);
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var initializeIcheck = function(){
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });


    };

    var initializeSummernote = function() {
        $('.summernote').summernote({
            tabsize: 2,
            height: 500
        });
    };

    var closeDismissableAlerts = function() {
        setTimeout(function(){
            /*Close any flash message after some time*/
            $(".alert-dismissable").fadeTo(4000, 500).slideUp(500, function(){
                $(".alert-dismissable").alert('close');
            });
        }, 3000);
    };

    $(function(){
        initializeIcheck();
        initializeSummernote();
        closeDismissableAlerts();
        $("#log-out").click(function(e){
            e.preventDefault();
            $("#logout-form").submit();
        })
    });
})();

