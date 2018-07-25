<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/10/18
 * Time: 4:21 PM
 */
class QuestionnairesSeeder extends Seeder
{
    public function run()
    {
        DB::table('questionnaire_html')->delete();
        DB::table('questionnaire_possible_answers')->delete();
        DB::table('questionnaire_questions')->delete();
        DB::table('questionnaire_languages')->delete();
        DB::table('questionnaires')->delete();
        DB::table('questionnaires')->insert([[
            'id' => 1,
            'project_id' => 1,
            'status_id' => 2,
            'default_language_id' => 6,
            'title' => 'Fair EU',
            'description' => 'Help us tackle the obstacles of low political participation levels, by responding to this questionnaire.',
            'questionnaire_json' => '{
    "pages": [
        {
            "name": "page1",
            "elements": [
                {
                    "type": "radiogroup",
                    "name": "question1",
                    "title": "Are you familiar with the term \"Citizen of the European Union\" and the rights this status confers?",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Yes"
                        },
                        {
                            "value": "item2",
                            "text": "No"
                        }
                    ]
                },
                {
                    "type": "html",
                    "name": "question2",
                    "visibleIf": "{question1} = \"item1\"",
                    "html": "<p>That’s great! It means that you know that EU citizens not only are allowed to move freely within the EU for work, studies, travel or joining their family members, but also have the right to vote and stand as candidates in municipal and European Parliament elections regardless of whether they are nationals of the EU country in which they reside. </p><p>This questionnaire, developed in the framework of the FAIR EU project (link to the project) aims at crowdsourcing EU citizens’ experience and opinion regarding the challenges to free movement and political participation.</p><p>Answering this questionnaire will take about 10 minutes. Your feedback will be invaluable in helping us to understand what obstacles EU citizens encounter when moving to or residing in an EU Member States other than their own, and being politically active.</p>"
                },
                {
                    "type": "html",
                    "name": "question3",
                    "visibleIf": "{question1} = \"item2\"",
                    "html": "<p>EU citizenship is at the heart of the European integration project. Citizenship of the European Union was established with the Maastricht treaty in 1993. It is supplementary to national citizenship and confers on every national of an EU country a set of rights, such as the right to move and reside freely within the EU, as well as the right to vote and stand as a candidate in European and local elections.</p><p>This questionnaire, developed in the framework of the FAIR EU project (link to the project) aims at crowdsourcing EU citizens’ experience and opinion regarding the challenges to free movement and political participation.</p><p>Answering this questionnaire will take about 10 minutes. Your feedback will be invaluable in helping us to understand what obstacles EU citizens encounter when moving to or residing in the EU Member States other than their own, and being politically active.</p>"
                },
                {
                    "type": "text",
                    "name": "question4",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Country of residence",
                    "enableIf": "{question1} notempty",
                    "isRequired": true
                },
                {
                    "type": "radiogroup",
                    "name": "question5",
                    "visible": false,
                    "title": "How long have you been residing in your current host Member State?",
                    "enableIf": "{question1} notempty",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Less than 3 months"
                        },
                        {
                            "value": "item2",
                            "text": "More than 3 months but less than 5 years"
                        },
                        {
                            "value": "item3",
                            "text": "5 years and more"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question6",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "What is your employment status?",
                    "isRequired": true,
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Employee"
                        },
                        {
                            "value": "item2",
                            "text": "Self-employed"
                        },
                        {
                            "value": "item3",
                            "text": "Unemployed"
                        },
                        {
                            "value": "item4",
                            "text": "Student"
                        },
                        {
                            "value": "item5",
                            "text": "Pensioner"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question7",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Gender",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Female"
                        },
                        {
                            "value": "item2",
                            "text": "Male"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question8",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Age",
                    "enableIf": "{question1} notempty",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "0-25"
                        },
                        {
                            "value": "item2",
                            "text": "26-40"
                        },
                        {
                            "value": "item3",
                            "text": "41-60"
                        },
                        {
                            "value": "item4",
                            "text": "More than 60"
                        }
                    ]
                },
                {
                    "type": "checkbox",
                    "name": "question9",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Have you encountered any obstacles when? (multiple answers possible)",
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Trying to enter the host Member State (these can include: over-scrutiny of identity documents, non-recognition of a national identity document, denial of access)"
                        },
                        {
                            "value": "item2",
                            "text": "Requesting residence documents (these can include: lengthy appointments, excessive requirements to prove the possession of sufficient resources)"
                        },
                        {
                            "value": "item3",
                            "text": "Requesting permanent residence documents (these can include: excessive requirements to prove the duration and continuity of residence, e.g. proof of sufficient resources, confirmation of having paid social security contributions, knowledge of the local language and culture, etc.)"
                        },
                        {
                            "value": "item4",
                            "text": "Accessing job market (these can include: difficulties in signing job contract as a result of not being able to receive required residency documents, discrimination on the basis of your nationality)"
                        },
                        {
                            "value": "item5",
                            "text": "I have not encountered any obstacles"
                        }
                    ]
                },
                {
                    "type": "html",
                    "name": "question10",
                    "visibleIf": "{question1} notempty",
                    "html": "<p>Please provide more details on the obstacles faced in your host Member State</p>"
                },
                {
                    "type": "checkbox",
                    "name": "question11",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "When residing in your host Member State, have you participated in: (multiple answers possible)",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "European Parliament elections"
                        },
                        {
                            "value": "item2",
                            "text": "Municipal elections (as a voter and/or a candidate)"
                        },
                        {
                            "value": "item3",
                            "text": "I have never participated in either EP or municipal elections"
                        }
                    ]
                },
                {
                    "type": "checkbox",
                    "name": "question12",
                    "visible": false,
                    "visibleIf": "{question1} notempty and {question11} notcontains \"item1\"",
                    "title": "Why did you decide not to participate in the elections to the EU Parliament in your host Member State: (multiple answers possible)",
                    "enableIf": "{question11} notcontains \"item1\"",
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "I was not aware of my right to participate"
                        },
                        {
                            "value": "item2",
                            "text": "I encountered difficulties in the registration process"
                        },
                        {
                            "value": "item3",
                            "text": "I missed the registration deadline"
                        },
                        {
                            "value": "item4",
                            "text": "I am not interested in politics and I do not vote"
                        },
                        {
                            "value": "item5",
                            "text": "I do not believe my vote would have any impact on the final election result"
                        },
                        {
                            "value": "item6",
                            "text": "I do not vote but I engage in alternative political and civic activities"
                        },
                        {
                            "value": "item7",
                            "text": "I participated in the elections to the European Parliament in my home country"
                        }
                    ]
                },
                {
                    "type": "checkbox",
                    "name": "question13",
                    "visible": false,
                    "visibleIf": "{question1} notempty and {question11} notcontains \"item2\"",
                    "title": "Why did you decide not to participate in the municipal elections in your host Member State: (multiple answers possible)",
                    "enableIf": "{question11} notcontains \"item2\"",
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "I was not allowed to participate (please explain the reasons given by the public administration)"
                        },
                        {
                            "value": "item2",
                            "text": "I was not aware of my right to participate"
                        },
                        {
                            "value": "item3",
                            "text": "I encountered difficulties in the registration process"
                        },
                        {
                            "value": "item4",
                            "text": "I missed the registration deadline"
                        },
                        {
                            "value": "item5",
                            "text": "I am not interested in politics and I do not vote"
                        },
                        {
                            "value": "item6",
                            "text": "I do not have enough knowledge of the local political system"
                        },
                        {
                            "value": "item7",
                            "text": "I do not believe my vote would have any impact on the final election result"
                        },
                        {
                            "value": "item8",
                            "text": "I do not vote but I engage in alternative political and civic activities (please specify below)"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question14",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Did you encounter any obstacles during the electoral registration process in your host Member State:",
                    "isRequired": true,
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "I did not receive correct or clear information on the procedures"
                        },
                        {
                            "value": "item2",
                            "text": "I experienced problems with local authorities based on my nationality"
                        },
                        {
                            "value": "item3",
                            "text": "Administrative procedures were lengthy and cumbersome"
                        },
                        {
                            "value": "item4",
                            "text": "I have never made an attempt to register on the electoral roll"
                        },
                        {
                            "value": "item5",
                            "text": "None"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question15",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "As an EU national residing in a host EU Member State, have you ever been refused registration for municipal or European Parliament elections on the grounds of?",
                    "isRequired": true,
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Not having your national ID document recognized"
                        },
                        {
                            "value": "item2",
                            "text": "Not having permanent residence"
                        },
                        {
                            "value": "item3",
                            "text": "Not having a nationality of the country where you reside"
                        },
                        {
                            "value": "item4",
                            "text": "I have never encountered such an issue"
                        }
                    ]
                },
                {
                    "type": "rating",
                    "name": "question16",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Do you believe that obstacles/problems encountered by the EU citizens in host Member States may contribute to their decisions not to participate in the municipal elections?",
                    "isRequired": true,
                    "minRateDescription": "I strongly disagree",
                    "maxRateDescription": "I strongly agree"
                },
                {
                    "type": "radiogroup",
                    "name": "question17",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Are you planning to participate in the next European Parliament elections in May 2019?",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Yes, in my home country"
                        },
                        {
                            "value": "item2",
                            "text": "Yes, in the EU Member State where I am currently residing"
                        },
                        {
                            "value": "item3",
                            "text": "No"
                        },
                        {
                            "value": "item4",
                            "text": "I do not know"
                        }
                    ]
                },
                {
                    "type": "comment",
                    "name": "question18",
                    "visible": false,
                    "visibleIf": "{question1} notempty and {question17} = \"item3\"",
                    "title": "Please explain why you are not going to vote",
                    "enableIf": "{question17} = \"item3\""
                },
                {
                    "type": "checkbox",
                    "name": "question19",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Have you ever participated in the following non-electoral political and/or civic activities? (multiple options possible)",
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Demonstrations"
                        },
                        {
                            "value": "item2",
                            "text": "Signing petitions"
                        },
                        {
                            "value": "item3",
                            "text": "Public meetings"
                        },
                        {
                            "value": "item4",
                            "text": "Volunteering"
                        },
                        {
                            "value": "item5",
                            "text": "Public consultations"
                        },
                        {
                            "value": "item6",
                            "text": "Membership of a political association/party"
                        },
                        {
                            "value": "item7",
                            "text": "Membership of a non-political association"
                        },
                        {
                            "value": "item8",
                            "text": "I have never participated in non-electoral political and/or civic activities"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question20",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Which in your opinion is the most important indicator of EU citizens’ integration in host countries?",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Knowledge of the local language and culture"
                        },
                        {
                            "value": "item2",
                            "text": "Participation in the labour market"
                        },
                        {
                            "value": "item3",
                            "text": "Understanding of local politics"
                        },
                        {
                            "value": "item4",
                            "text": "Participation in municipal elections"
                        },
                        {
                            "value": "item5",
                            "text": "Involvement in the issues relevant to the local community (e.g. signing petitions, participation in the local commissions, neighbours councils)"
                        }
                    ]
                },
                {
                    "type": "rating",
                    "name": "question21",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Do you agree with the following statement? Mobile EU Citizens who feel more integrated in their host Member State are more likely to participate in municipal elections.",
                    "isRequired": true,
                    "minRateDescription": "I strongly disagree",
                    "maxRateDescription": "I strongly agree"
                },
                {
                    "type": "rating",
                    "name": "question23",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Do you agree with the following statement? Political participation of mobile EU citizens would allow them to better defend their interests in their host country.",
                    "isRequired": true,
                    "minRateDescription": "I strongly disagree",
                    "maxRateDescription": "I strongly agree"
                },
                {
                    "type": "rating",
                    "name": "question22",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Do you believe that expats-friendly information campaigns would increase political participation of EU citizens in their country of residence?",
                    "isRequired": true,
                    "minRateDescription": "I strongly disagree",
                    "maxRateDescription": "I strongly agree"
                },
                {
                    "type": "comment",
                    "name": "question24",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Please share with us any good practices from your host Member State that helped to improve political participation of mobile EU citizens."
                }
            ]
        }
    ]
}'
        ]]);
        DB::table('questionnaire_questions')->insert([
            ['id' => 1, 'questionnaire_id' => 1, 'name' => 'question1', 'type' => 'radiogroup', 'question' => 'Are you familiar with the term "Citizen of the European Union" and the rights this status confers?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'questionnaire_id' => 1, 'name' => 'question2', 'type' => 'html', 'question' => 'question2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'questionnaire_id' => 1, 'name' => 'question3', 'type' => 'html', 'question' => 'question3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'questionnaire_id' => 1, 'name' => 'question4', 'type' => 'text', 'question' => 'Country of residence', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'questionnaire_id' => 1, 'name' => 'question5', 'type' => 'radiogroup', 'question' => 'How long have you been residing in your current host Member State?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'questionnaire_id' => 1, 'name' => 'question6', 'type' => 'radiogroup', 'question' => 'What is your employment status?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'questionnaire_id' => 1, 'name' => 'question7', 'type' => 'radiogroup', 'question' => 'Gender', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'questionnaire_id' => 1, 'name' => 'question8', 'type' => 'radiogroup', 'question' => 'Age', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'questionnaire_id' => 1, 'name' => 'question9', 'type' => 'checkbox', 'question' => 'Have you encountered any obstacles when? (multiple answers possible)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'questionnaire_id' => 1, 'name' => 'question10', 'type' => 'html', 'question' => 'question10', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'questionnaire_id' => 1, 'name' => 'question11', 'type' => 'checkbox', 'question' => 'When residing in your host Member State, have you participated in: (multiple answers possible)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'questionnaire_id' => 1, 'name' => 'question12', 'type' => 'checkbox', 'question' => 'Why did you decide not to participate in the elections to the EU Parliament in your host Member State: (multiple answers possible)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'questionnaire_id' => 1, 'name' => 'question13', 'type' => 'checkbox', 'question' => 'Why did you decide not to participate in the municipal elections in your host Member State: (multiple answers possible)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'questionnaire_id' => 1, 'name' => 'question14', 'type' => 'radiogroup', 'question' => 'Did you encounter any obstacles during the electoral registration process in your host Member State:', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'questionnaire_id' => 1, 'name' => 'question15', 'type' => 'radiogroup', 'question' => 'As an EU national residing in a host EU Member State, have you ever been refused registration for municipal or European Parliament elections on the grounds of?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 16, 'questionnaire_id' => 1, 'name' => 'question16', 'type' => 'rating', 'question' => 'Do you believe that obstacles/problems encountered by the EU citizens in host Member States may contribute to their decisions not to participate in the municipal elections?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 17, 'questionnaire_id' => 1, 'name' => 'question17', 'type' => 'radiogroup', 'question' => 'Are you planning to participate in the next European Parliament elections in May 2019?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 18, 'questionnaire_id' => 1, 'name' => 'question18', 'type' => 'comment', 'question' => 'Please explain why you are not going to vote', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 19, 'questionnaire_id' => 1, 'name' => 'question19', 'type' => 'checkbox', 'question' => 'Have you ever participated in the following non-electoral political and/or civic activities? (multiple options possible)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 20, 'questionnaire_id' => 1, 'name' => 'question20', 'type' => 'radiogroup', 'question' => 'Which in your opinion is the most important indicator of EU citizens’ integration in host countries?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 21, 'questionnaire_id' => 1, 'name' => 'question21', 'type' => 'rating', 'question' => 'Do you agree with the following statement? Mobile EU Citizens who feel more integrated in their host Member State are more likely to participate in municipal elections.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 22, 'questionnaire_id' => 1, 'name' => 'question22', 'type' => 'rating', 'question' => 'Do you agree with the following statement? Political participation of mobile EU citizens would allow them to better defend their interests in their host country.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 23, 'questionnaire_id' => 1, 'name' => 'question23', 'type' => 'rating', 'question' => 'Do you believe that expats-friendly information campaigns would increase political participation of EU citizens in their country of residence?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 24, 'questionnaire_id' => 1, 'name' => 'question24', 'type' => 'comment', 'question' => 'Please share with us any good practices from your host Member State that helped to improve political participation of mobile EU citizens.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
        DB::table('questionnaire_possible_answers')->insert([
            ['id' => 1, 'question_id' => 1, 'value' => 'item1', 'answer' => 'Yes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'question_id' => 1, 'value' => 'item2', 'answer' => 'No', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'question_id' => 5, 'value' => 'item1', 'answer' => 'Less than 3 months', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'question_id' => 5, 'value' => 'item2', 'answer' => 'More than 3 months but less than 5 years', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'question_id' => 5, 'value' => 'item3', 'answer' => '5 years and more', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'question_id' => 6, 'value' => 'item1', 'answer' => 'Employee', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'question_id' => 6, 'value' => 'item2', 'answer' => 'Self-employed', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'question_id' => 6, 'value' => 'item3', 'answer' => 'Unemployed', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'question_id' => 6, 'value' => 'item4', 'answer' => 'Student', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'question_id' => 6, 'value' => 'item5', 'answer' => 'Pensioner', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'question_id' => 7, 'value' => 'item1', 'answer' => 'Female', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'question_id' => 7, 'value' => 'item2', 'answer' => 'Male', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'question_id' => 8, 'value' => 'item1', 'answer' => '0-25', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'question_id' => 8, 'value' => 'item2', 'answer' => '26-40', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'question_id' => 8, 'value' => 'item3', 'answer' => '41-60', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 16, 'question_id' => 8, 'value' => 'item4', 'answer' => 'More than 60', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 17, 'question_id' => 9, 'value' => 'item1', 'answer' => 'Trying to enter the host Member State (these can include: over-scrutiny of identity documents, non-recognition of a national identity document, denial of access)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 18, 'question_id' => 9, 'value' => 'item2', 'answer' => 'Requesting residence documents (these can include: lengthy appointments, excessive requirements to prove the possession of sufficient resources)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 19, 'question_id' => 9, 'value' => 'item3', 'answer' => 'Requesting permanent residence documents (these can include: excessive requirements to prove the duration and continuity of residence, e.g. proof of sufficient resources, confirmation of having paid social security contributions, knowledge of the local language and culture, etc.)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 20, 'question_id' => 9, 'value' => 'item4', 'answer' => 'Accessing job market (these can include: difficulties in signing job contract as a result of not being able to receive required residency documents, discrimination on the basis of your nationality)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 21, 'question_id' => 9, 'value' => 'item5', 'answer' => 'I have not encountered any obstacles', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 22, 'question_id' => 11, 'value' => 'item1', 'answer' => 'European Parliament elections', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 23, 'question_id' => 11, 'value' => 'item2', 'answer' => 'Municipal elections (as a voter and/or a candidate)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 24, 'question_id' => 11, 'value' => 'item3', 'answer' => 'I have never participated in either EP or municipal elections', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 25, 'question_id' => 12, 'value' => 'item1', 'answer' => 'I was not aware of my right to participate', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 26, 'question_id' => 12, 'value' => 'item2', 'answer' => 'I encountered difficulties in the registration process', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 27, 'question_id' => 12, 'value' => 'item3', 'answer' => 'I missed the registration deadline', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 28, 'question_id' => 12, 'value' => 'item4', 'answer' => 'I am not interested in politics and I do not vote', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 29, 'question_id' => 12, 'value' => 'item5', 'answer' => 'I do not believe my vote would have any impact on the final election result', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 30, 'question_id' => 12, 'value' => 'item6', 'answer' => 'I do not vote but I engage in alternative political and civic activities', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 31, 'question_id' => 12, 'value' => 'item7', 'answer' => 'I participated in the elections to the European Parliament in my home country', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 32, 'question_id' => 13, 'value' => 'item1', 'answer' => 'I was not allowed to participate (please explain the reasons given by the public administration)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 33, 'question_id' => 13, 'value' => 'item2', 'answer' => 'I was not aware of my right to participate', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 34, 'question_id' => 13, 'value' => 'item3', 'answer' => 'I encountered difficulties in the registration process', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 35, 'question_id' => 13, 'value' => 'item4', 'answer' => 'I missed the registration deadline', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 36, 'question_id' => 13, 'value' => 'item5', 'answer' => 'I am not interested in politics and I do not vote', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 37, 'question_id' => 13, 'value' => 'item6', 'answer' => 'I do not have enough knowledge of the local political system', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 38, 'question_id' => 13, 'value' => 'item7', 'answer' => 'I do not believe my vote would have any impact on the final election result', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 39, 'question_id' => 13, 'value' => 'item8', 'answer' => 'I do not vote but I engage in alternative political and civic activities (please specify below)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 40, 'question_id' => 14, 'value' => 'item1', 'answer' => 'I did not receive correct or clear information on the procedures', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 41, 'question_id' => 14, 'value' => 'item2', 'answer' => 'I experienced problems with local authorities based on my nationality', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 42, 'question_id' => 14, 'value' => 'item3', 'answer' => 'Administrative procedures were lengthy and cumbersome', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 43, 'question_id' => 14, 'value' => 'item4', 'answer' => 'I have never made an attempt to register on the electoral roll', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 44, 'question_id' => 14, 'value' => 'item5', 'answer' => 'None', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 45, 'question_id' => 15, 'value' => 'item1', 'answer' => 'Not having your national ID document recognized', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 46, 'question_id' => 15, 'value' => 'item2', 'answer' => 'Not having permanent residence', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 47, 'question_id' => 15, 'value' => 'item3', 'answer' => 'Not having a nationality of the country where you reside', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 48, 'question_id' => 15, 'value' => 'item4', 'answer' => 'I have never encountered such an issue', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 49, 'question_id' => 17, 'value' => 'item1', 'answer' => 'Yes, in my home country', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 50, 'question_id' => 17, 'value' => 'item2', 'answer' => 'Yes, in the EU Member State where I am currently residing', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 51, 'question_id' => 17, 'value' => 'item3', 'answer' => 'No', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 52, 'question_id' => 17, 'value' => 'item4', 'answer' => 'I do not know', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 53, 'question_id' => 19, 'value' => 'item1', 'answer' => 'Demonstrations', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 54, 'question_id' => 19, 'value' => 'item2', 'answer' => 'Signing petitions', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 55, 'question_id' => 19, 'value' => 'item3', 'answer' => 'Public meetings', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 56, 'question_id' => 19, 'value' => 'item4', 'answer' => 'Volunteering', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 57, 'question_id' => 19, 'value' => 'item5', 'answer' => 'Public consultations', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 58, 'question_id' => 19, 'value' => 'item6', 'answer' => 'Membership of a political association/party', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 59, 'question_id' => 19, 'value' => 'item7', 'answer' => 'Membership of a non-political association', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 60, 'question_id' => 19, 'value' => 'item8', 'answer' => 'I have never participated in non-electoral political and/or civic activities', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 61, 'question_id' => 20, 'value' => 'item1', 'answer' => 'Knowledge of the local language and culture', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 62, 'question_id' => 20, 'value' => 'item2', 'answer' => 'Participation in the labour market', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 63, 'question_id' => 20, 'value' => 'item3', 'answer' => 'Understanding of local politics', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 64, 'question_id' => 20, 'value' => 'item4', 'answer' => 'Participation in municipal elections', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 65, 'question_id' => 20, 'value' => 'item5', 'answer' => 'Involvement in the issues relevant to the local community (e.g. signing petitions, participation in the local commissions, neighbours councils)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 66, 'question_id' => 16, 'value' => null, 'answer' => 'I strongly disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 67, 'question_id' => 16, 'value' => null, 'answer' => 'I strongly agree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 68, 'question_id' => 21, 'value' => null, 'answer' => 'I strongly disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 69, 'question_id' => 21, 'value' => null, 'answer' => 'I strongly agree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 70, 'question_id' => 22, 'value' => null, 'answer' => 'I strongly disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 71, 'question_id' => 22, 'value' => null, 'answer' => 'I strongly agree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 72, 'question_id' => 23, 'value' => null, 'answer' => 'I strongly disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 73, 'question_id' => 23, 'value' => null, 'answer' => 'I strongly agree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
        DB::table('questionnaire_html')->insert([
            ['id' => 1, 'question_id' => 2, 'html' => "<p>That’s great! It means that you know that EU citizens not only are allowed to move freely within the EU for work, studies, travel or joining their family members, but also have the right to vote and stand as candidates in municipal and European Parliament elections regardless of whether they are nationals of the EU country in which they reside. </p><p>This questionnaire, developed in the framework of the FAIR EU project (link to the project) aims at crowdsourcing EU citizens’ experience and opinion regarding the challenges to free movement and political participation.</p><p>Answering this questionnaire will take about 10 minutes. Your feedback will be invaluable in helping us to understand what obstacles EU citizens encounter when moving to or residing in an EU Member States other than their own, and being politically active.</p>", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'question_id' => 3, 'html' => "<p>EU citizenship is at the heart of the European integration project. Citizenship of the European Union was established with the Maastricht treaty in 1993. It is supplementary to national citizenship and confers on every national of an EU country a set of rights, such as the right to move and reside freely within the EU, as well as the right to vote and stand as a candidate in European and local elections.</p><p>This questionnaire, developed in the framework of the FAIR EU project (link to the project) aims at crowdsourcing EU citizens’ experience and opinion regarding the challenges to free movement and political participation.</p><p>Answering this questionnaire will take about 10 minutes. Your feedback will be invaluable in helping us to understand what obstacles EU citizens encounter when moving to or residing in the EU Member States other than their own, and being politically active.</p>", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'question_id' => 10, 'html' => "<p>Please provide more details on the obstacles faced in your host Member State</p>", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}