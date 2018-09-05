require('datatables.net-bs');
require('datatables.net-buttons');

(function () {

    let initializeDataTable = function () {
        var container = $("#table1");

        container.DataTable({

            destroy: true,
            "paging": true,
            "searching": true,
            "info": false,
            dom: 'Bfrtip',
            buttons: [
              'excelHtml5',
                'csvHtml5'
            ]
        });
    };


    let init = function () {
        initializeDataTable();
    };

    $(document).ready(function() {
        init();
    });
})();