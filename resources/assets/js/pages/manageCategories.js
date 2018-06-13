(function () {
    let initEditCategoryModal = function () {
        self = $(this);
        let id = self.data('id');
        let name = self.data('name');
        let modal = $('#modal-edit-category');
        modal.find('input[name="category_name"]').val(name);
        modal.find('input[name="category_id"]').val(id);
        console.log(name);
    };

    let deleteCategory = function () {
        self = $(this);
        swal({
                title: "Are you sure?",
                text: "Do you wish to delete the selected category from your CMS? (The articles it contains, will be moved to the category 'Uncategorized')",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Delete",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                let id = self.data('id');
                let deleteUrl = self.data('url');
                $.ajax({
                    type: "POST",
                    url: deleteUrl,
                    data: {category_id: id},
                    success: function (response) {
                        if (response.status === '__SUCCESS') {
                            self.closest('tr').remove();
                            swal("Deleted!", response.message, "success");
                        } else {
                            swal("Oops!", response.message, "error");
                        }
                    },
                    error: function () {
                        swal("Oops!", "An error occurred.", "error");
                    }
                });
            });
    };

    let initEvents = function () {
        let body = $('body');
        body.on('click', '.edit-category', initEditCategoryModal);
        body.on('click', '.delete-category', deleteCategory);
    };

    initEvents();
})();