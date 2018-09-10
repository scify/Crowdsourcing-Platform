require('datatables.net-bs');
require('datatables.net-buttons');
require('datatables.net-buttons/js/dataTables.buttons');
require('datatables.net-buttons/js/buttons.html5');

(function () {

    let initializeDataTable = function () {
        let usersTable = $("#responsesTable");
        usersTable.DataTable({
            "paging": true,
            "searching": true,
            "pageLength": 10,
            "dom": 'Bfrtip',
            "buttons": [
                {
                    extend: 'csvHtml5',
                    text: 'Download as CSV'
                }

            ],
            "columns": [
                { "width": "30%" },
                { "width": "40%" },
                { "width": "20%" },
            ],
            "initComplete": function(settings, json) {}
        });
    };

    let init = function() {
        initializeDataTable();
    };

    $(document).ready(function() {
        init();
    });
})();