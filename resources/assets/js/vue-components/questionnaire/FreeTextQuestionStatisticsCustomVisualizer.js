import * as SurveyAnalytics from "survey-analytics";

export class AnswersData {
    static answerVotes = [];
    static userId = null;
}

function FreeTextQuestionStatisticsCustomVisualizer(question, data) {

    function renderHeader(table, visualizer) {
        const header = document.createElement("thead");
        const tr = document.createElement("tr");
        const header1 = document.createElement("th");
        header1.innerHTML = "Original Answer";
        tr.appendChild(header1);
        const header2 = document.createElement("th");
        header2.innerHTML = "Translated Answer";
        tr.appendChild(header2);
        const header3 = document.createElement("th");
        header3.innerHTML = "Initial Language Detected";
        tr.appendChild(header3);
        const header4 = document.createElement("th");
        header4.innerHTML = "";
        tr.appendChild(header4);
        header.appendChild(tr);
        table.appendChild(header);
    }

    function renderRows(table, visualizer) {
        const tbody = document.createElement("tbody");
        const questionName = visualizer.question.name;
        const answers = visualizer.dataProvider.data;

        answers
            .forEach(function (value) {
                const answer = value[questionName];
                if (!answer)
                    return;
                const respondentUserId = value.respondent_user_id;
                const tr = document.createElement("tr");
                const td1 = document.createElement("td");
                const td2 = document.createElement("td");
                const td3 = document.createElement("td");
                const td4 = document.createElement("td");

                if (isString(answer))
                    td1.innerHTML = answer;
                else {
                    td1.innerHTML = answer.initial_answer;
                    td2.innerHTML = answer.translated_answer;
                    td3.innerHTML = answer.initial_language_detected;
                }
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                let userUpvotedClass = '';
                let userDownvotedClass = '';
                if (userHasUpvoted(questionName, respondentUserId))
                    userUpvotedClass = 'user-upvoted';
                else if (userHasDownvoted(questionName, respondentUserId))
                    userDownvotedClass = 'user-downvoted';
                const upvotesNum = getNumOfUpvotes(questionName, respondentUserId);
                const downvotesNum = getNumOfDownvotes(questionName, respondentUserId);

                if (upvotesNum)
                    td4.setAttribute('data-order', (upvotesNum * 10));
                else if (downvotesNum)
                    td4.setAttribute('data-order', '0.' + downvotesNum);
                else
                    td4.setAttribute('data-order', '1');

                td4.innerHTML = '<div class="container-fluid">' +
                    '<div class="row text-center no-gutters">' +
                    '<div class="col-6 pr-1">' +
                    '<button data-question-name="' + questionName + '" ' +
                    'data-respondent-user-id="' + respondentUserId + '" ' +
                    'type="button" class="btn btn-light w-100 upvote vote-btn ' + userUpvotedClass + '">' +
                    '<i class="far fa-thumbs-up"></i><span class="count">' + upvotesNum + '</span>' +
                    '</button>' +
                    '</div>' +
                    '<div class="col-6 pl-1">' +
                    '<button data-question-name="' + questionName + '" ' +
                    'data-respondent-user-id="' + respondentUserId + '" ' +
                    'type="button" class="btn btn-light w-100 downvote vote-btn ' + userDownvotedClass + '">' +
                    '<i class="far fa-thumbs-down"></i><span class="count">' + downvotesNum + '</span>' +
                    '</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                tr.appendChild(td4);
                tbody.appendChild(tr);
            });
        table.appendChild(tbody);
    }

    function getNumOfUpvotes(questionName, respondent_user_id) {
        for (let i = 0; i < AnswersData.answerVotes.length; i++) {
            if (AnswersData.answerVotes[i].question_name === questionName
                && parseInt(respondent_user_id) === parseInt(AnswersData.answerVotes[i].respondent_user_id))
                return AnswersData.answerVotes[i].num_upvotes;
        }
        return 0;
    }

    function userHasUpvoted(questionName, respondent_user_id) {
        for (let i = 0; i < AnswersData.answerVotes.length; i++) {
            if (AnswersData.answerVotes[i].question_name === questionName
                && parseInt(respondent_user_id) === parseInt(AnswersData.answerVotes[i].respondent_user_id))
                return AnswersData.answerVotes[i].upvoted_by_user;
        }
        return false;
    }

    function userHasDownvoted(questionName, respondent_user_id) {
        for (let i = 0; i < AnswersData.answerVotes.length; i++) {
            if (AnswersData.answerVotes[i].question_name === questionName
                && parseInt(respondent_user_id) === parseInt(AnswersData.answerVotes[i].respondent_user_id))
                return AnswersData.answerVotes[i].downvoted_by_user;
        }
        return false;
    }

    function getNumOfDownvotes(questionName, respondent_user_id) {
        for (let i = 0; i < AnswersData.answerVotes.length; i++) {
            if (AnswersData.answerVotes[i].question_name === questionName
                && parseInt(respondent_user_id) === parseInt(AnswersData.answerVotes[i].respondent_user_id))
                return AnswersData.answerVotes[i].num_downvotes;
        }
        return 0;
    }

    function isString(str) {
        return (typeof str === 'string' || str instanceof String)
    }

    const renderContent = function (contentContainer, visualizer) {
        const table = document.createElement("table");
        table.className = "sa__matrix-table w-100 table table-striped custom-texts-table";
        renderHeader(table, visualizer);
        renderRows(table, visualizer);
        contentContainer.appendChild(table);
        contentContainer.className += " custom-texts-table-container";
        $(table).DataTable({
            destroy: true,
            "paging": true,
            "responsive": true,
            "searching": true,
            "columns": [
                {"width": "40%"},
                {"width": "40%"},
                {"width": "5%"},
                {"width": "15%"}
            ],
            "order": [[3, "desc"]]
        });
    };
    return new SurveyAnalytics.VisualizerBase(question, data, {
        renderContent: renderContent
    }, "freeTextVisualizer");
}

export default FreeTextQuestionStatisticsCustomVisualizer;
