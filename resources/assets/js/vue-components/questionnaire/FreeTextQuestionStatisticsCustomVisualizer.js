import * as SurveyAnalytics from "survey-analytics";
//import AnswersPresenter from "./AnswersPresenter.vue";

require('../../lang');

export class AnswersData {
    static answerVotes = [];
    static answerAnnotations = {};
    static userId = null;
    static userCanAnnotateAnswers = false;
    static currentIndex = 1
    static numberOfVotesForQuestionnaire;
    static languageResources = {};
}

function FreeTextQuestionStatisticsCustomVisualizer(question, data) {
    function renderHeader(table, visualizer) {
        const questionName = visualizer.question.name;
        if (questionName.includes("-Comment")) {
            renderHeaderSimple(table, visualizer)
        } else {
            renderHeaderFull(table, visualizer);
        }
    }

    function renderHeaderSimple(table, visualizer) {
        const header = document.createElement("thead");
        const tr = document.createElement("tr");
        const header0 = document.createElement("th");
        header0.innerHTML = "Initial Answer";
        const header1 = document.createElement("th");
        header1.innerHTML = "Translated Answer";
        const header2 = document.createElement("th");
        header2.innerHTML = "Language Detected";
        tr.appendChild(header0);
        tr.appendChild(header1);
        tr.appendChild(header2);
        header.appendChild(tr);
        table.appendChild(header);
    }

    function renderHeaderFull(table, visualizer) {
        const header = document.createElement("thead");
        const tr = document.createElement("tr");
        const header0 = document.createElement("th");
        header0.innerHTML = "Answer id";
        tr.appendChild(header0);
        const header1 = document.createElement("th");
        header1.innerHTML = "Answer";
        tr.appendChild(header1);
        const header2 = document.createElement("th");
        header2.classList.add("text-center");
        header2.innerHTML = "";
        const header3 = document.createElement("th");
        header3.innerHTML = "Number of votes";
        const header4 = document.createElement("th");
        header4.innerHTML = "Project name";
        tr.appendChild(header2);
        tr.appendChild(header3);
        tr.appendChild(header4);
        header.appendChild(tr);
        table.appendChild(header);
    }

    function renderRows(table, visualizer) {
        const questionName = visualizer.question.name;
        if (questionName.includes("-Comment")) {
            renderRowsSimple(table, visualizer)
        } else {
            renderRowsFull(table, visualizer);
        }
    }

    function renderRowsSimple(table, visualizer) {
        const tbody = document.createElement("tbody");
        const questionName = visualizer.question.name;
        const answers = visualizer.dataProvider.data;
        answers
            .forEach(function (answer) {
                const response = answer[questionName];
                if (!response || !response.initial_answer)
                    return;
                const tr = document.createElement("tr");
                const td0 = document.createElement("td");
                const td1 = document.createElement("td");
                const td2 = document.createElement("td");
                td0.innerHTML = response.initial_answer;
                td1.innerHTML = response.translated_answer;
                td2.innerHTML = getLanguageName(response.initial_language_detected);
                tr.appendChild(td0);
                tr.appendChild(td1);
                tr.appendChild(td2);
                tbody.appendChild(tr);
            });
        table.appendChild(tbody);
    }

    function renderRowsFull(table, visualizer) {
        const tbody = document.createElement("tbody");
        const questionName = visualizer.question.name;
        const answers = visualizer.dataProvider.data;
        answers
            .forEach(function (value) {
                if (!value.response_text || !value.response_text[questionName])
                    return;
                const responseId = value.response_id;
                const responseText = value.response_text[questionName];
                const respondentUserId = value.respondent_user_id;
                if (!responseText || !respondentUserId || isAnswerMarkedAsHidden(questionName, respondentUserId))
                    return;

                const tr = document.createElement("tr");
                const td0 = document.createElement("td");
                td0.innerHTML = '<span class="answer-id">' + responseId + '</span>';
                tr.appendChild(td0);
                const td1 = document.createElement("td");
                td1.className = "answer-column";
                td1.setAttribute("id", "answer_" + questionName + "_" + respondentUserId)
                const td2 = document.createElement("td");
                const td3 = document.createElement("td");
                const td4 = document.createElement("td");
                let annotation = getAnnotationForAnswer(questionName, respondentUserId);
                const annotationText = annotation ? annotation.annotation_text : "";
                let adminReviewStatusId = 0;
                if (annotation)
                    adminReviewStatusId = annotation.admin_review_status_id ? annotation.admin_review_status_id : 0;
                const adminReviewComment = annotation ? annotation.admin_review_comment : "";
                if (AnswersData.userCanAnnotateAnswers) {
                    let annotationIndication = annotation ? '<i class="fa fa-check" title="This answer has been reviewed by a moderator"></i>' : "";
                    td1.innerHTML = '<span class="annotation-button"><button ' +
                        'data-annotation="' + annotationText
                        + '" data-annotation-admin-review-status-id="' + adminReviewStatusId
                        + '" data-annotation-admin-review-comment="' + adminReviewComment
                        + '" data-question="' + questionName
                        + '" data-respondent="' + respondentUserId + '" '
                        + 'class="btn annotate-btn"><i class="fa fa-edit"></i>' + annotationIndication +
                        '</button></span>';
                }
                if (annotationText && annotationText !== "") {
                    td1.innerHTML += '<div class="annotation-wrapper"><b>Comment by the admin:</b><p class="annotation-text">'
                        + annotationText
                        + '</p></div><b>Original answer:</b><br>';
                }
                td1.innerHTML += '<p>' + getAnswerHTML(responseText, 'initial_answer') + '</p>';


                if (!isString(responseText) && responseText.translated_answer !== "")
                    td1.innerHTML += '<br><b>Translation ('
                        + getLanguageName(responseText.initial_language_detected) + '):</b><p>'
                        + getAnswerHTML(responseText, 'translated_answer') + '</p>';
                tr.appendChild(td1);

                let userUpvotedClass = '';
                let userDownvotedClass = '';
                if (userHasUpvoted(questionName, respondentUserId))
                    userUpvotedClass = 'user-upvoted';
                else if (userHasDownvoted(questionName, respondentUserId))
                    userDownvotedClass = 'user-downvoted';
                const upvotesNum = getNumOfUpvotes(questionName, respondentUserId);
                const downvotesNum = getNumOfDownvotes(questionName, respondentUserId);

                td2.setAttribute('data-order', getOrderingFactorForAnswer(annotation, upvotesNum, downvotesNum).toString());
                td2.innerHTML = '<div class="container-fluid">' +
                    '<div class="row text-center no-gutters reaction-buttons" ' +
                    '<div class="col">' +
                    '<button data-question-name="' + questionName + '" ' +
                    'data-respondent-user-id="' + respondentUserId + '" ' +
                    'type="button" title="You can vote up to 10 answers" class="btn btn-outline-secondary w-100 upvote vote-btn ' + userUpvotedClass + '">' +
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
                td3.innerHTML = upvotesNum;
                td4.innerHTML = value.project_name;
                tr.appendChild(td3);
                tr.appendChild(td4);
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
                && parseInt(AnswersData.userId) === parseInt(AnswersData.answerVotes[i].voter_user_id)
                && parseInt(respondent_user_id) === parseInt(AnswersData.answerVotes[i].respondent_user_id))
                return parseInt(AnswersData.answerVotes[i].upvote);
        }
        return false;
    }

    function userHasDownvoted(questionName, respondent_user_id) {
        for (let i = 0; i < AnswersData.answerVotes.length; i++) {
            if (AnswersData.answerVotes[i].question_name === questionName
                && parseInt(AnswersData.userId) === parseInt(AnswersData.answerVotes[i].voter_user_id)
                && parseInt(respondent_user_id) === parseInt(AnswersData.answerVotes[i].respondent_user_id))
                return !parseInt(AnswersData.answerVotes[i].upvote);
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

    function isAnswerMarkedAsHidden(questionName, respondentUserId) {
        const annotation = getAnnotationForAnswer(questionName, respondentUserId);
        return annotation && annotation.admin_review_status_id === 4;
    }

    function getAnnotationForAnswer(questionName, respondentUserId) {
        if (AnswersData.answerAnnotations[questionName] && AnswersData.answerAnnotations[questionName][respondentUserId])
            return AnswersData.answerAnnotations[questionName][respondentUserId][0];
        return false;
    }

    function getOrderingFactorForAnswer(annotation, upVotesNum, downVotesNum) {
        //
        let orderingFactor = 0;
        if (annotation) {
            if (annotation.admin_review_status_id === 2)
                orderingFactor += 1000;
            if (annotation.admin_review_status_id === 3)
                orderingFactor -= 1000;
        }
        if (upVotesNum)
            orderingFactor += (2 * upVotesNum);
        if (downVotesNum)
            orderingFactor -= (2 * downVotesNum);

        //calibrate scores to be from 0 - 1
        return sigmoid(orderingFactor);
    }

    const k = 2;

    function sigmoid(z) {
        return 1 / (1 + Math.exp(-z / k));
    }

    const renderContent = function (contentContainer, visualizer) {

        const div = document.createElement("div");
        div.id = question.name + "_answer_container"
        contentContainer.appendChild(div);

        const table = document.createElement("table");
        table.className = "sa__matrix-table w-100 table table-striped custom-texts-table";
        renderHeader(table, visualizer);
        renderRows(table, visualizer);
        const container = document.createElement("div");

        contentContainer.appendChild(container);
        container.appendChild(table);
        contentContainer.className += " custom-texts-table-container";
        AnswersData.currentIndex += 1;
        let columns;
        const questionName = visualizer.question.name;
        if (questionName.includes("-Comment")) {
            columns = [
                {"width": "45%"},
                {"width": "45%"},
                {"width": "10%"}
            ];
        } else {
            columns = [
                {"width": "0%"},
                {"width": "80%"},
                {"width": "20%"},
                {"width": "0%"},
                {"width": "0%"}
            ];
        }
        const options = {
            destroy: true,
            "paging": true,
            "responsive": true,
            "searching": true,
            "columns": columns,
            "order": [[(columns.length - 2), "desc"]],
            "dom": 'Bfrtip'
        };
        if (!questionName.includes("-Comment")) {
            options.columnDefs = [
                {
                    "targets": [0, 2, 4],
                    "visible": false
                }
            ]
        }
        if (AnswersData.userCanAnnotateAnswers) {
            options.buttons = [
                {
                    extend: 'csvHtml5',
                    text: AnswersData.languageResources.download_csv,
                    filename: 'Statistics_' + new Date().getTime(),
                    exportOptions: {
                        columns: questionName.includes("-Comment") ? [0, 1, 2] : [0, 1, 2, 4]
                    }
                }
            ]
        } else
            options.buttons = [];
        $(table).DataTable(options);
    };
    return new SurveyAnalytics.VisualizerBase(question, data, {
        renderContent: renderContent
    }, "freeTextVisualizer");
}

export default FreeTextQuestionStatisticsCustomVisualizer;
