let collaborationModalHeader = function () {
    let initializeCollaborationModalHeader = function (modal) {
        let self = $(this);
        let status, userName, taskDescription;
        status = self.closest('td').siblings('.status').html();
        userName = self.closest('td').siblings('.user-name').text().trim();
        taskDescription = self.closest('td').siblings('.task-description').text().trim();
        modal.find('.task-description').html(taskDescription);
        modal.find('.user-name').html(userName);
        modal.find('.status').html(status);
    };

    return {
        initializeCollaborationModalHeader
    };
};

export default collaborationModalHeader;