import * as SurveyAnalytics from "survey-analytics";

require('../../lang');

export class AnswersData {
    static answerVotes = [];
    static userId = null;
}

function FreeTextQuestionStatisticsCustomVisualizer(question, data) {
    let translationExistsForQuestion = true;

    function renderHeader(table, visualizer) {
        const header = document.createElement("thead");
        const tr = document.createElement("tr");
        const header1 = document.createElement("th");
        header1.innerHTML = "Original Answer";
        tr.appendChild(header1);
        if (translationExistsForQuestion) {
            const header2 = document.createElement("th");
            header2.innerHTML = "Translated Answer";
            tr.appendChild(header2);
            const header3 = document.createElement("th");
            header3.innerHTML = "Language";
            tr.appendChild(header3);
        }
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
                if(!value.answerObj || !value.answerObj[questionName])
                    return;
                const answer = value.answerObj[questionName];
                const respondentUserId = value.respondent_user_id;
                if (!answer || !respondentUserId)
                    return;

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
                    td3.innerHTML = answer.initial_language_detected ? getLanguageName(answer.initial_language_detected) : '';
                }
                tr.appendChild(td1);
                if (translationExistsForQuestion) {
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                }
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
                const classNameForContainer = translationExistsForQuestion ? 'px-0' : '';
                td4.innerHTML = '<div class="container-fluid ' + classNameForContainer + '">' +
                    '<div class="row text-center no-gutters reaction-buttons">' +
                    '<div class="col">' +
                    '<button data-question-name="' + questionName + '" ' +
                    'data-respondent-user-id="' + respondentUserId + '" ' +
                    'type="button" class="btn btn-outline-secondary w-100 upvote vote-btn ' + userUpvotedClass + '">' +
                    '<i class="far fa-thumbs-up"></i><span class="count">' + upvotesNum + '</span>' +
                    '</button>' +
                    '</div>' +
                    '<div class="col-6 d-none">' +
                    '<button data-question-name="' + questionName + '" ' +
                    'data-respondent-user-id="' + respondentUserId + '" ' +
                    'type="button" class="btn btn-outline-secondary w-100 downvote vote-btn' + userDownvotedClass + '">' +
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
        const answersForCurrentQuestion = visualizer.dataProvider.data
            .map(a => a[visualizer.question.name]).filter(a => a !== undefined);
        translationExistsForQuestion = answersForCurrentQuestion.find(a => !isString(a));
        const table = document.createElement("table");
        table.className = "sa__matrix-table w-100 table table-striped custom-texts-table";
        renderHeader(table, visualizer);
        renderRows(table, visualizer);
        contentContainer.appendChild(table);
        contentContainer.className += " custom-texts-table-container";
        let columns = [
            {"width": "42.5%"},
            {"width": "42.5%"},
            {"width": "5%"},
            {"width": "10%"}
        ];
        if (!translationExistsForQuestion)
            columns = [
                {"width": "80%"},
                {"width": "20%"}
            ];
        $(table).DataTable({
            destroy: true,
            "paging": true,
            "responsive": true,
            "searching": true,
            "columns": columns,
            "order": [[(columns.length - 1), "desc"]],
            "dom": 'Bfrtip',
            "buttons": [
                {
                    extend: 'csvHtml5',
                    text: 'Download as CSV',
                    filename: 'Statistics_' + new Date().getTime()
                }

            ]
        });
    };
    return new SurveyAnalytics.VisualizerBase(question, data, {
        renderContent: renderContent
    }, "freeTextVisualizer");
}

export default FreeTextQuestionStatisticsCustomVisualizer;
