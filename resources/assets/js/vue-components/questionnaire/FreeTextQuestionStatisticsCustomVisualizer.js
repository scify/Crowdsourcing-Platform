import * as SurveyAnalytics from "survey-analytics";

require('../../lang');

export class AnswersData {
    static answerVotes = [];
    static answerAnnotations = {};
    static userId = null;
    static userCanAnnotateAnswers = false;
}

function FreeTextQuestionStatisticsCustomVisualizer(question, data) {
    function renderHeader(table, visualizer) {
        const header = document.createElement("thead");
        const tr = document.createElement("tr");
        const header1 = document.createElement("th");
        header1.innerHTML = "Answer";
        tr.appendChild(header1);
        const header2 = document.createElement("th");
        header2.innerHTML = "";
        tr.appendChild(header2);
        header.appendChild(tr);
        table.appendChild(header);
    }

    function renderRows(table, visualizer) {
        const tbody = document.createElement("tbody");
        const questionName = visualizer.question.name;
        const answers = visualizer.dataProvider.data;

        answers
            .forEach(function (value) {
                if (!value.answerObj || !value.answerObj[questionName])
                    return;
                const answer = value.answerObj[questionName];
                const respondentUserId = value.respondent_user_id;
                if (!answer || !respondentUserId)
                    return;

                const tr = document.createElement("tr");
                const td1 = document.createElement("td");
                td1.setAttribute("id", "answer_" + questionName + "_" + respondentUserId)
                const td2 = document.createElement("td");
                let annotation = false;
                if (AnswersData.answerAnnotations[questionName]
                    && AnswersData.answerAnnotations[questionName][respondentUserId]) {
                    annotation = AnswersData.answerAnnotations[questionName][respondentUserId][0];
                }
                const annotationText = annotation ? annotation.annotation_text : "";
                if (AnswersData.userCanAnnotateAnswers) {
                    td1.innerHTML = '<span class="annotation-button"><button data-annotation="' + annotationText
                        + '" data-question="' + questionName
                        + '" data-respondent="' + respondentUserId + '" '
                        + 'class="btn annotate-btn"><i class="fa fa-edit"></i></button></span>';
                }
                if (annotation) {
                    td1.innerHTML += '<div class="annotation-wrapper"><b>Comment by the admin:</b><p class="annotation-text">'
                        + annotationText
                        + '</p></div><b>Original answer:</b><br>';
                }
                td1.innerHTML += '<p>' + getAnswerHTML(answer, 'initial_answer') + '</p>';


                if (!isString(answer) && answer.translated_answer !== "")
                    td1.innerHTML += '<b>Translation ('
                        + getLanguageName(answer.initial_language_detected) + '):</b><p>'
                        + getAnswerHTML(answer, 'translated_answer') + '</p>';
                tr.appendChild(td1);

                let userUpvotedClass = '';
                let userDownvotedClass = '';
                if (userHasUpvoted(questionName, respondentUserId))
                    userUpvotedClass = 'user-upvoted';
                else if (userHasDownvoted(questionName, respondentUserId))
                    userDownvotedClass = 'user-downvoted';
                const upvotesNum = getNumOfUpvotes(questionName, respondentUserId);
                const downvotesNum = getNumOfDownvotes(questionName, respondentUserId);
                if (upvotesNum)
                    td2.setAttribute('data-order', (upvotesNum * 10));
                else if (downvotesNum)
                    td2.setAttribute('data-order', '0.' + downvotesNum);
                else
                    td2.setAttribute('data-order', '1');
                td2.innerHTML = '<div class="container-fluid">' +
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
                tr.appendChild(td2);
                tbody.appendChild(tr);
            });
        table.appendChild(tbody);
    }

    function getAnswerHTML(answer, field_name) {
        const maxLength = 350;
        const answerText = isString(answer) ? answer.trim() : answer[field_name].trim();
        if (answerText.length < maxLength)
            return answerText;
        const shortStr = answerText.substring(0, maxLength);
        const removedStr = answerText.substring(maxLength, answerText.length);
        return shortStr + '<a href="javascript:void(0);" class="read-more">Read more...</a>' + '<span class="more-text hidden">' + removedStr + '</span>';
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
                return parseInt(AnswersData.answerVotes[i].upvoted_by_user);
        }
        return false;
    }

    function userHasDownvoted(questionName, respondent_user_id) {
        for (let i = 0; i < AnswersData.answerVotes.length; i++) {
            if (AnswersData.answerVotes[i].question_name === questionName
                && parseInt(respondent_user_id) === parseInt(AnswersData.answerVotes[i].respondent_user_id))
                return parseInt(AnswersData.answerVotes[i].downvoted_by_user);
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
        const columns = [
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
                    text: window.language[window.Laravel.locale].statistics.download_csv,
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
