<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/10/18
 * Time: 4:21 PM
 */
class QuestionnairesSeeder extends Seeder {
    public function run() {
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
            'title' => 'Break the barriers to free movement and political participation in the EU',
            'description' => '<p>What obstacles did you face when working / moving in Europe?</p>',
            'goal' => 500,
            'questionnaire_json' => '{
    "pages": [
        {
            "name": "page1",
            "elements": [
                {
                    "type": "radiogroup",
                    "name": "question1",
                    "title": "Are you familiar with the term \"Citizen of the European Union\" and the rights this status confers?",
                    "guid": "28087674-b577-408f-950d-39dc599713c2",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Yes",
                            "guid": "48b6bcaf-c306-49e0-cce9-16fc1d7832b1"
                        },
                        {
                            "value": "item2",
                            "text": "No",
                            "guid": "60bbf0a6-9b35-4629-bb7e-f7464337427e"
                        }
                    ]
                },
                {
                    "type": "html",
                    "name": "question2",
                    "visibleIf": "{question1} = \"item1\"",
                    "html": "<p>That’s great! It means that you know that EU citizens not only are allowed to move freely within the EU for work, studies, travel or joining their family members, but also have the right to vote and stand as candidates in municipal and European Parliament elections regardless of whether they are nationals of the EU country in which they reside. </p><p>This questionnaire, developed in the framework of the FAIR EU project (link to the project) aims at crowdsourcing EU citizens’ experience and opinion regarding the challenges to free movement and political participation.</p><p>Answering this questionnaire will take about 10 minutes. Your feedback will be invaluable in helping us to understand what obstacles EU citizens encounter when moving to or residing in an EU Member States other than their own, and being politically active.</p>",
                    "guid": "20fc8927-9f71-4330-22d7-61465ad2a251"
                },
                {
                    "type": "html",
                    "name": "question3",
                    "visibleIf": "{question1} = \"item2\"",
                    "html": "<p>EU citizenship is at the heart of the European integration project. Citizenship of the European Union was established with the Maastricht treaty in 1993. It is supplementary to national citizenship and confers on every national of an EU country a set of rights, such as the right to move and reside freely within the EU, as well as the right to vote and stand as a candidate in European and local elections.</p><p>This questionnaire, developed in the framework of the FAIR EU project (link to the project) aims at crowdsourcing EU citizens’ experience and opinion regarding the challenges to free movement and political participation.</p><p>Answering this questionnaire will take about 10 minutes. Your feedback will be invaluable in helping us to understand what obstacles EU citizens encounter when moving to or residing in the EU Member States other than their own, and being politically active.</p>",
                    "guid": "fc2ca61c-ecb1-4c0c-6668-94e59e194537"
                },
                {
                    "type": "text",
                    "name": "question4",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Country of residence",
                    "guid": "a421e0df-62a0-486f-8e5a-a9aa64d12912",
                    "enableIf": "{question1} notempty",
                    "isRequired": true
                },
                {
                    "type": "radiogroup",
                    "name": "question5",
                    "visible": false,
                    "title": "How long have you been residing in your current host Member State?",
                    "guid": "a4fef8e0-5e09-458c-1a82-c9ea09e80f37",
                    "enableIf": "{question1} notempty",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Less than 3 months",
                            "guid": "a0f79398-e848-494d-cb5d-0da38d85c640"
                        },
                        {
                            "value": "item2",
                            "text": "More than 3 months but less than 5 years",
                            "guid": "07e1fb9b-7c5e-4d57-af8c-4a37cebf50d8"
                        },
                        {
                            "value": "item3",
                            "text": "5 years and more",
                            "guid": "f23cf260-54ee-40d1-e9cc-2afda5dd61ed"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question6",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "What is your employment status?",
                    "guid": "912c7071-9ccf-467c-7c78-3799b45a2c00",
                    "isRequired": true,
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Employee",
                            "guid": "1269ad6b-e074-41e1-4ef6-12ddc649ad0f"
                        },
                        {
                            "value": "item2",
                            "text": "Self-employed",
                            "guid": "b595996f-b405-43d9-8e41-f2cb8cb7dab2"
                        },
                        {
                            "value": "item3",
                            "text": "Unemployed",
                            "guid": "3e4ee82c-a11d-4cd0-7b01-4901b8ced26b"
                        },
                        {
                            "value": "item4",
                            "text": "Student",
                            "guid": "d2824755-9013-491a-1fd8-1a3993568ce0"
                        },
                        {
                            "value": "item5",
                            "text": "Pensioner",
                            "guid": "acfda878-90a5-4ecc-de99-c08c2b6d548e"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question7",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Gender",
                    "guid": "a646030e-be12-419d-b26b-50ef5c5823ec",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Female",
                            "guid": "de148768-a187-4f51-825a-b0a6a2ba7845"
                        },
                        {
                            "value": "item2",
                            "text": "Male",
                            "guid": "7d150aba-4329-4356-6ebe-540ea587145b"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question8",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Age",
                    "guid": "7be58065-5f4f-4045-9f0a-c8819d4d6e30",
                    "enableIf": "{question1} notempty",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "0-25",
                            "guid": "33664a53-c923-4659-02b6-63c871d630f1"
                        },
                        {
                            "value": "item2",
                            "text": "26-40",
                            "guid": "8c986a2f-c03c-4782-54a5-910687eba99b"
                        },
                        {
                            "value": "item3",
                            "text": "41-60",
                            "guid": "5f3844b6-60cd-43d4-bd40-840bf66dc2b7"
                        },
                        {
                            "value": "item4",
                            "text": "More than 60",
                            "guid": "f36ce255-f697-45b4-828f-0c71150d5bf4"
                        }
                    ]
                },
                {
                    "type": "checkbox",
                    "name": "question9",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Have you encountered any obstacles when? (multiple answers possible)",
                    "guid": "e31e0668-c828-4202-0a65-2c12de1b4b44",
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Trying to enter the host Member State (these can include: over-scrutiny of identity documents, non-recognition of a national identity document, denial of access)",
                            "guid": "9d8b970c-9a27-4024-266b-11410e898084"
                        },
                        {
                            "value": "item2",
                            "text": "Requesting residence documents (these can include: lengthy appointments, excessive requirements to prove the possession of sufficient resources)",
                            "guid": "041a393c-d4c8-4fd2-373d-5063565f6391"
                        },
                        {
                            "value": "item3",
                            "text": "Requesting permanent residence documents (these can include: excessive requirements to prove the duration and continuity of residence, e.g. proof of sufficient resources, confirmation of having paid social security contributions, knowledge of the local language and culture, etc.)",
                            "guid": "e90e383a-0ef1-4e3e-6c16-ff5272960e10"
                        },
                        {
                            "value": "item4",
                            "text": "Accessing job market (these can include: difficulties in signing job contract as a result of not being able to receive required residency documents, discrimination on the basis of your nationality)",
                            "guid": "d4685f6a-47e3-4639-0674-b0e2972c00f3"
                        },
                        {
                            "value": "item5",
                            "text": "I have not encountered any obstacles",
                            "guid": "ce2335bc-a3e0-42a4-c15c-ff3e46f591cc"
                        }
                    ]
                },
                {
                    "type": "html",
                    "name": "question10",
                    "visibleIf": "{question1} notempty",
                    "html": "<p>Please provide more details on the obstacles faced in your host Member State</p>",
                    "guid": "7707dff7-3db8-4795-e2b9-2e8cd5860d1a"
                },
                {
                    "type": "checkbox",
                    "name": "question11",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "When residing in your host Member State, have you participated in: (multiple answers possible)",
                    "guid": "3661aabb-d4eb-4041-c46b-6023278649ad",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "European Parliament elections",
                            "guid": "4753b637-f325-47a4-e181-e3939f55c830"
                        },
                        {
                            "value": "item2",
                            "text": "Municipal elections (as a voter and/or a candidate)",
                            "guid": "db25355c-bab7-4f7a-5860-eb2c5b43e062"
                        },
                        {
                            "value": "item3",
                            "text": "I have never participated in either EP or municipal elections",
                            "guid": "b60cbf8e-74ba-42e5-9e54-1cf3fcbd4a55"
                        }
                    ]
                },
                {
                    "type": "checkbox",
                    "name": "question12",
                    "visible": false,
                    "visibleIf": "{question1} notempty and {question11} notcontains \"item1\"",
                    "title": "Why did you decide not to participate in the elections to the EU Parliament in your host Member State: (multiple answers possible)",
                    "guid": "66c1f426-db7a-48a7-4e71-4536c15c10dc",
                    "enableIf": "{question11} notcontains \"item1\"",
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "I was not aware of my right to participate",
                            "guid": "da1f4f4a-2c9d-4388-f86c-220e47b3b5e7"
                        },
                        {
                            "value": "item2",
                            "text": "I encountered difficulties in the registration process",
                            "guid": "aed9dd17-5fe8-4762-2ece-467192d85930"
                        },
                        {
                            "value": "item3",
                            "text": "I missed the registration deadline",
                            "guid": "6cf610e7-2c59-41c9-255e-ce725b2d95ee"
                        },
                        {
                            "value": "item4",
                            "text": "I am not interested in politics and I do not vote",
                            "guid": "ac5d007f-f319-4109-6139-ac2c7545dadd"
                        },
                        {
                            "value": "item5",
                            "text": "I do not believe my vote would have any impact on the final election result",
                            "guid": "f79d25b5-cdf8-4110-0055-112320cd64c2"
                        },
                        {
                            "value": "item6",
                            "text": "I do not vote but I engage in alternative political and civic activities",
                            "guid": "3edf3793-ac59-4d12-9b12-55149c56d61b"
                        },
                        {
                            "value": "item7",
                            "text": "I participated in the elections to the European Parliament in my home country",
                            "guid": "793f54a6-3bb0-43fd-9552-0732b9e3a24d"
                        }
                    ]
                },
                {
                    "type": "checkbox",
                    "name": "question13",
                    "visible": false,
                    "visibleIf": "{question1} notempty and {question11} notcontains \"item2\"",
                    "title": "Why did you decide not to participate in the municipal elections in your host Member State: (multiple answers possible)",
                    "guid": "89a986c5-a7d4-4a58-3fe6-fe4d16a65100",
                    "enableIf": "{question11} notcontains \"item2\"",
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "I was not allowed to participate (please explain the reasons given by the public administration)",
                            "guid": "e5ec7049-114b-4dd6-a64b-7d56630b9396"
                        },
                        {
                            "value": "item2",
                            "text": "I was not aware of my right to participate",
                            "guid": "2091daa1-008c-42f9-d178-9d38edbd7f10"
                        },
                        {
                            "value": "item3",
                            "text": "I encountered difficulties in the registration process",
                            "guid": "df17a845-6dd3-46f5-ef53-44004945d32f"
                        },
                        {
                            "value": "item4",
                            "text": "I missed the registration deadline",
                            "guid": "1c9eb4f0-9444-41c5-2953-2aa0dabaf174"
                        },
                        {
                            "value": "item5",
                            "text": "I am not interested in politics and I do not vote",
                            "guid": "239cdfe0-e55c-4d7e-0275-db719cc91826"
                        },
                        {
                            "value": "item6",
                            "text": "I do not have enough knowledge of the local political system",
                            "guid": "c0d59d42-37e8-40d2-5741-be692d8d3819"
                        },
                        {
                            "value": "item7",
                            "text": "I do not believe my vote would have any impact on the final election result",
                            "guid": "19e001e9-d732-45e7-f3cf-b79c828ba08c"
                        },
                        {
                            "value": "item8",
                            "text": "I do not vote but I engage in alternative political and civic activities (please specify below)",
                            "guid": "36ee4c5a-552e-4a1c-a3da-5515845a5ee5"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question14",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Did you encounter any obstacles during the electoral registration process in your host Member State:",
                    "guid": "6d973c22-c22f-48e3-8f40-23a39814b602",
                    "isRequired": true,
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "I did not receive correct or clear information on the procedures",
                            "guid": "efb631fb-288c-49ff-41dc-53849a3c524c"
                        },
                        {
                            "value": "item2",
                            "text": "I experienced problems with local authorities based on my nationality",
                            "guid": "ffa451b0-1e7b-450e-2584-5b9ae83de8d9"
                        },
                        {
                            "value": "item3",
                            "text": "Administrative procedures were lengthy and cumbersome",
                            "guid": "3feb44b2-8e16-4568-3749-3a30403153c3"
                        },
                        {
                            "value": "item4",
                            "text": "I have never made an attempt to register on the electoral roll",
                            "guid": "c7b78f7b-2882-408f-7117-624e67bc797a"
                        },
                        {
                            "value": "item5",
                            "text": "None",
                            "guid": "91ac133c-3e23-4aba-fb5c-a67ace9d6ee0"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question15",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "As an EU national residing in a host EU Member State, have you ever been refused registration for municipal or European Parliament elections on the grounds of?",
                    "guid": "d361ab0a-775c-46ad-f40f-67be3709b229",
                    "isRequired": true,
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Not having your national ID document recognized",
                            "guid": "c6ad7da2-0a8f-4fa5-25ec-9d31e90bcb58"
                        },
                        {
                            "value": "item2",
                            "text": "Not having permanent residence",
                            "guid": "6776d4d0-723b-4cf7-1f07-25330564aa51"
                        },
                        {
                            "value": "item3",
                            "text": "Not having a nationality of the country where you reside",
                            "guid": "4c2bd934-891e-44fa-eadf-e16d71d29902"
                        },
                        {
                            "value": "item4",
                            "text": "I have never encountered such an issue",
                            "guid": "07ec15ef-44e5-49dc-2097-ce64690f604b"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question16",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Do you believe that obstacles/problems encountered by the EU citizens in host Member States may contribute to their decisions not to participate in the municipal elections?",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "I strongly agree",
                            "guid": "cee8f784-4869-4ef6-7c23-82bcc9436182"
                        },
                        {
                            "value": "item2",
                            "text": "I agree",
                            "guid": "9e8e1a7e-c9de-4972-6f30-b1d1aca5daa0"
                        },
                        {
                            "value": "item3",
                            "text": "I neither agree nor disagree",
                            "guid": "bf5c33a9-6f36-46d4-2bec-df4da01627e0"
                        },
                        {
                            "value": "item4",
                            "text": "I disagree",
                            "guid": "8b8f0dad-8aa5-4e35-6ffb-5bae889263d3"
                        },
                        {
                            "value": "item5",
                            "text": "I strongly disagree",
                            "guid": "e3f1aeb8-40fc-4834-c723-4770b66d5d7e"
                        }
                    ],
                    "guid": "d51c0e60-130c-4ae9-964c-7c75126466f6"
                },
                {
                    "type": "radiogroup",
                    "name": "question17",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Are you planning to participate in the next European Parliament elections in May 2019?",
                    "guid": "9ecd8358-2bf2-4148-6f16-29356238afad",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Yes, in my home country",
                            "guid": "2141d5fe-5776-4f77-8cfe-c61fdd282741"
                        },
                        {
                            "value": "item2",
                            "text": "Yes, in the EU Member State where I am currently residing",
                            "guid": "9dbe0d44-b259-48b1-b248-5aa3ed2eba80"
                        },
                        {
                            "value": "item3",
                            "text": "No",
                            "guid": "063ff8a8-33bc-4ad9-6131-a9d1555abbee"
                        },
                        {
                            "value": "item4",
                            "text": "I do not know",
                            "guid": "e7099d6c-0ba0-46f4-1fbb-a3a834c61782"
                        }
                    ]
                },
                {
                    "type": "comment",
                    "name": "question18",
                    "visible": false,
                    "visibleIf": "{question1} notempty and {question17} = \"item3\"",
                    "title": "Please explain why you are not going to vote",
                    "guid": "d6106f94-7227-4381-ab1a-ebbac22699af",
                    "enableIf": "{question17} = \"item3\""
                },
                {
                    "type": "checkbox",
                    "name": "question19",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Have you ever participated in the following non-electoral political and/or civic activities? (multiple options possible)",
                    "guid": "6d975931-a6fb-4331-df3e-9d84b7f61fc6",
                    "hasOther": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Demonstrations",
                            "guid": "08109ed8-6519-43d2-9957-9bd19c3f7007"
                        },
                        {
                            "value": "item2",
                            "text": "Signing petitions",
                            "guid": "12b6b809-66ea-43f5-d7b5-54d0018ebc7c"
                        },
                        {
                            "value": "item3",
                            "text": "Public meetings",
                            "guid": "9f6bd44c-f6f6-4b6a-1c61-d591c3171526"
                        },
                        {
                            "value": "item4",
                            "text": "Volunteering",
                            "guid": "d8061e55-31eb-4a8a-3cdf-b2e902df6945"
                        },
                        {
                            "value": "item5",
                            "text": "Public consultations",
                            "guid": "5c28e886-01b4-4a9a-eabc-4a87d45d367f"
                        },
                        {
                            "value": "item6",
                            "text": "Membership of a political association/party",
                            "guid": "98a40015-9a8e-4045-eb45-52c61333c7e8"
                        },
                        {
                            "value": "item7",
                            "text": "Membership of a non-political association",
                            "guid": "7ffbec7b-e032-4769-5f93-f2a1135ec422"
                        },
                        {
                            "value": "item8",
                            "text": "I have never participated in non-electoral political and/or civic activities",
                            "guid": "a9da128c-a09f-4e2c-e050-37c7d2919afe"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question20",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Which in your opinion is the most important indicator of EU citizens’ integration in host countries?",
                    "guid": "a7ba5aa3-ccba-416f-88cd-12f723d72df2",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "Knowledge of the local language and culture",
                            "guid": "4447f644-f608-4fef-bbae-1f6685485af5"
                        },
                        {
                            "value": "item2",
                            "text": "Participation in the labour market",
                            "guid": "5fa884e1-d76a-4809-3a2c-362a502e9ba7"
                        },
                        {
                            "value": "item3",
                            "text": "Understanding of local politics",
                            "guid": "53295640-29e0-4356-4180-dbfdc8f29100"
                        },
                        {
                            "value": "item4",
                            "text": "Participation in municipal elections",
                            "guid": "8151cf2b-682f-4add-3b52-4f4e3f954e58"
                        },
                        {
                            "value": "item5",
                            "text": "Involvement in the issues relevant to the local community (e.g. signing petitions, participation in the local commissions, neighbours councils)",
                            "guid": "8c631c06-d733-4ec9-8648-d721354b28ec"
                        }
                    ]
                },
                {
                    "type": "radiogroup",
                    "name": "question21",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Do you agree with the following statement? Mobile EU Citizens who feel more integrated in their host Member State are more likely to participate in municipal elections.",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "I strongly agree",
                            "guid": "3d70a41f-6a20-48e7-7bc9-025363552952"
                        },
                        {
                            "value": "item2",
                            "text": "I agree",
                            "guid": "45f18bde-6c76-44ad-a8c5-41326ace47ba"
                        },
                        {
                            "value": "item3",
                            "text": "I neither agree nor disagree",
                            "guid": "51aeb713-b3ec-4675-b0ee-d90c1947209a"
                        },
                        {
                            "value": "item4",
                            "text": "I disagree",
                            "guid": "2ab4d871-055b-4d2a-c42c-bb3a5a5e52c4"
                        },
                        {
                            "value": "item5",
                            "text": "I strongly disagree",
                            "guid": "a332b067-8a8f-4f25-3559-61e75bb65c2f"
                        }
                    ],
                    "guid": "1012c7ec-c116-4ac9-b119-7a030ea0c50b"
                },
                {
                    "type": "radiogroup",
                    "name": "question23",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Do you agree with the following statement? Political participation of mobile EU citizens would allow them to better defend their interests in their host country.",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "I strongly agree",
                            "guid": "4d64bf79-b693-4bc1-c934-00b70f9c4f30"
                        },
                        {
                            "value": "item2",
                            "text": "I agree",
                            "guid": "4312bb54-9ac6-440a-bd2d-cae0536051df"
                        },
                        {
                            "value": "item3",
                            "text": "I neither agree nor disagree",
                            "guid": "a231f1ff-b1cd-45cc-e014-2ea8334cb54b"
                        },
                        {
                            "value": "item4",
                            "text": "I disagree",
                            "guid": "81a6a212-b9ac-4d2f-95f5-d23edaf280ae"
                        },
                        {
                            "value": "item5",
                            "text": "I strongly disagree",
                            "guid": "05f24856-8c46-4e0d-46a2-3c7040fc809e"
                        }
                    ],
                    "guid": "cd46991d-3863-44ed-d3db-ed56b9341fe6"
                },
                {
                    "type": "radiogroup",
                    "name": "question22",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Do you believe that expats-friendly information campaigns would increase political participation of EU citizens in their country of residence?",
                    "isRequired": true,
                    "choices": [
                        {
                            "value": "item1",
                            "text": "I strongly agree",
                            "guid": "6178e896-0c63-4257-b2df-f07f5df298c1"
                        },
                        {
                            "value": "item2",
                            "text": "I agree",
                            "guid": "4638248a-cafc-4b9c-5cf0-5639f3a964ff"
                        },
                        {
                            "value": "item3",
                            "text": "I neither agree nor disagree",
                            "guid": "7371e782-3a77-49c4-e5c5-b216e1b3a22b"
                        },
                        {
                            "value": "item4",
                            "text": "I disagree",
                            "guid": "bb275ecd-5afc-406f-fe07-1d681cacbe20"
                        },
                        {
                            "value": "item5",
                            "text": "I strongly disagree",
                            "guid": "a9d3762b-e0f5-44d6-445e-b229b795c692"
                        }
                    ],
                    "guid": "0bdde0ac-19f4-4b97-dfaf-298f8b7ff031"
                },
                {
                    "type": "comment",
                    "name": "question24",
                    "visible": false,
                    "visibleIf": "{question1} notempty",
                    "title": "Please share with us any good practices from your host Member State that helped to improve political participation of mobile EU citizens.",
                    "guid": "ea1ee0cc-c7d9-4c57-48fe-42d66bee3989"
                }
            ]
        }
    ]
}'
        ]]);
        DB::table('questionnaire_questions')->insert([
            ['id' => 1, 'questionnaire_id' => 1, 'guid' => '28087674-b577-408f-950d-39dc599713c2', 'name' => 'question1', 'type' => 'radiogroup', 'question' => 'Are you familiar with the term "Citizen of the European Union" and the rights this status confers?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'questionnaire_id' => 1, 'guid' => '20fc8927-9f71-4330-22d7-61465ad2a251', 'name' => 'question2', 'type' => 'html', 'question' => 'question2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'questionnaire_id' => 1, 'guid' => 'fc2ca61c-ecb1-4c0c-6668-94e59e194537', 'name' => 'question3', 'type' => 'html', 'question' => 'question3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'questionnaire_id' => 1, 'guid' => 'a421e0df-62a0-486f-8e5a-a9aa64d12912', 'name' => 'question4', 'type' => 'text', 'question' => 'Country of residence', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'questionnaire_id' => 1, 'guid' => 'a4fef8e0-5e09-458c-1a82-c9ea09e80f37', 'name' => 'question5', 'type' => 'radiogroup', 'question' => 'How long have you been residing in your current host Member State?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'questionnaire_id' => 1, 'guid' => '912c7071-9ccf-467c-7c78-3799b45a2c00', 'name' => 'question6', 'type' => 'radiogroup', 'question' => 'What is your employment status?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'questionnaire_id' => 1, 'guid' => 'a646030e-be12-419d-b26b-50ef5c5823ec', 'name' => 'question7', 'type' => 'radiogroup', 'question' => 'Gender', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'questionnaire_id' => 1, 'guid' => '7be58065-5f4f-4045-9f0a-c8819d4d6e30', 'name' => 'question8', 'type' => 'radiogroup', 'question' => 'Age', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'questionnaire_id' => 1, 'guid' => 'e31e0668-c828-4202-0a65-2c12de1b4b44', 'name' => 'question9', 'type' => 'checkbox', 'question' => 'Have you encountered any obstacles when? (multiple answers possible)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'questionnaire_id' => 1, 'guid' => '7707dff7-3db8-4795-e2b9-2e8cd5860d1a', 'name' => 'question10', 'type' => 'html', 'question' => 'question10', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'questionnaire_id' => 1, 'guid' => '3661aabb-d4eb-4041-c46b-6023278649ad', 'name' => 'question11', 'type' => 'checkbox', 'question' => 'When residing in your host Member State, have you participated in: (multiple answers possible)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'questionnaire_id' => 1, 'guid' => '66c1f426-db7a-48a7-4e71-4536c15c10dc', 'name' => 'question12', 'type' => 'checkbox', 'question' => 'Why did you decide not to participate in the elections to the EU Parliament in your host Member State: (multiple answers possible)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'questionnaire_id' => 1, 'guid' => '89a986c5-a7d4-4a58-3fe6-fe4d16a65100', 'name' => 'question13', 'type' => 'checkbox', 'question' => 'Why did you decide not to participate in the municipal elections in your host Member State: (multiple answers possible)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'questionnaire_id' => 1, 'guid' => '6d973c22-c22f-48e3-8f40-23a39814b602', 'name' => 'question14', 'type' => 'radiogroup', 'question' => 'Did you encounter any obstacles during the electoral registration process in your host Member State:', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'questionnaire_id' => 1, 'guid' => 'd361ab0a-775c-46ad-f40f-67be3709b229', 'name' => 'question15', 'type' => 'radiogroup', 'question' => 'As an EU national residing in a host EU Member State, have you ever been refused registration for municipal or European Parliament elections on the grounds of?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 16, 'questionnaire_id' => 1, 'guid' => 'd51c0e60-130c-4ae9-964c-7c75126466f6', 'name' => 'question16', 'type' => 'radiogroup', 'question' => 'Do you believe that obstacles/problems encountered by the EU citizens in host Member States may contribute to their decisions not to participate in the municipal elections?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 17, 'questionnaire_id' => 1, 'guid' => '9ecd8358-2bf2-4148-6f16-29356238afad', 'name' => 'question17', 'type' => 'radiogroup', 'question' => 'Are you planning to participate in the next European Parliament elections in May 2019?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 18, 'questionnaire_id' => 1, 'guid' => 'd6106f94-7227-4381-ab1a-ebbac22699af', 'name' => 'question18', 'type' => 'comment', 'question' => 'Please explain why you are not going to vote', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 19, 'questionnaire_id' => 1, 'guid' => '6d975931-a6fb-4331-df3e-9d84b7f61fc6', 'name' => 'question19', 'type' => 'checkbox', 'question' => 'Have you ever participated in the following non-electoral political and/or civic activities? (multiple options possible)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 20, 'questionnaire_id' => 1, 'guid' => 'a7ba5aa3-ccba-416f-88cd-12f723d72df2', 'name' => 'question20', 'type' => 'radiogroup', 'question' => 'Which in your opinion is the most important indicator of EU citizens’ integration in host countries?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 21, 'questionnaire_id' => 1, 'guid' => '1012c7ec-c116-4ac9-b119-7a030ea0c50b', 'name' => 'question21', 'type' => 'radiogroup', 'question' => 'Do you agree with the following statement? Mobile EU Citizens who feel more integrated in their host Member State are more likely to participate in municipal elections.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 22, 'questionnaire_id' => 1, 'guid' => 'cd46991d-3863-44ed-d3db-ed56b9341fe6', 'name' => 'question22', 'type' => 'radiogroup', 'question' => 'Do you agree with the following statement? Political participation of mobile EU citizens would allow them to better defend their interests in their host country.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 23, 'questionnaire_id' => 1, 'guid' => '0bdde0ac-19f4-4b97-dfaf-298f8b7ff031', 'name' => 'question23', 'type' => 'radiogroup', 'question' => 'Do you believe that expats-friendly information campaigns would increase political participation of EU citizens in their country of residence?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 24, 'questionnaire_id' => 1, 'guid' => 'ea1ee0cc-c7d9-4c57-48fe-42d66bee3989', 'name' => 'question24', 'type' => 'comment', 'question' => 'Please share with us any good practices from your host Member State that helped to improve political participation of mobile EU citizens.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
        DB::table('questionnaire_possible_answers')->insert([
            ['id' => 1, 'question_id' => 1, 'guid' => '7b9dd754-b575-4d5a-035f-f3d988c0d9b6', 'value' => 'item1', 'answer' => 'Yes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'question_id' => 1, 'guid' => 'cc5045b7-6708-4eb5-4a21-f87094792a46', 'value' => 'item2', 'answer' => 'No', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'question_id' => 5, 'guid' => 'd63f644d-fcb9-46c7-4c3b-89ee0d7c1136', 'value' => 'item1', 'answer' => 'Less than 3 months', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'question_id' => 5, 'guid' => 'e39bb2b2-c9be-400f-3812-d2ad56f8fdc2', 'value' => 'item2', 'answer' => 'More than 3 months but less than 5 years', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'question_id' => 5, 'guid' => 'a30bb365-8bff-4f3e-34ed-b51d34aa05fd', 'value' => 'item3', 'answer' => '5 years and more', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'question_id' => 6, 'guid' => '732567f6-e8b3-47f4-0f00-00211b2605d1', 'value' => 'item1', 'answer' => 'Employee', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'question_id' => 6, 'guid' => '1d027291-42a1-4ac9-8ca2-0223d8fd3daf', 'value' => 'item2', 'answer' => 'Self-employed', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'question_id' => 6, 'guid' => '5dc6aaee-3a1d-434e-a5e7-b2a3d25e5d27', 'value' => 'item3', 'answer' => 'Unemployed', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'question_id' => 6, 'guid' => '3d1ee84f-bc19-4e40-15d7-a4c6f03e9392', 'value' => 'item4', 'answer' => 'Student', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'question_id' => 6, 'guid' => 'c810555e-42b2-45cb-9683-10f52ad5bd32', 'value' => 'item5', 'answer' => 'Pensioner', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'question_id' => 7, 'guid' => '78e44105-8d5d-48d5-6688-f1f30b874b52', 'value' => 'item1', 'answer' => 'Female', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'question_id' => 7, 'guid' => '0dc4222e-48af-4c6d-46db-f1b759392ace', 'value' => 'item2', 'answer' => 'Male', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'question_id' => 8, 'guid' => 'a2b72f9a-5886-4c34-d4d6-9f8d81e03f0d', 'value' => 'item1', 'answer' => '0-25', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'question_id' => 8, 'guid' => '64a963e7-5738-4476-93e9-443cdad2c6ef', 'value' => 'item2', 'answer' => '26-40', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'question_id' => 8, 'guid' => '0cc29c25-c2ff-48a3-f9a2-4851e8cf5f4d', 'value' => 'item3', 'answer' => '41-60', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 16, 'question_id' => 8, 'guid' => '11201624-26c2-430c-2a96-4bcc4e213e9e', 'value' => 'item4', 'answer' => 'More than 60', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 17, 'question_id' => 9, 'guid' => 'dc1d246a-0014-4490-e235-9bf36b610703', 'value' => 'item1', 'answer' => 'Trying to enter the host Member State (these can include: over-scrutiny of identity documents, non-recognition of a national identity document, denial of access)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 18, 'question_id' => 9, 'guid' => 'f7ea141a-3376-4964-a186-1ba3bb033590', 'value' => 'item2', 'answer' => 'Requesting residence documents (these can include: lengthy appointments, excessive requirements to prove the possession of sufficient resources)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 19, 'question_id' => 9, 'guid' => '1dba8ef3-be7d-4911-8e1f-9a6a29d95879', 'value' => 'item3', 'answer' => 'Requesting permanent residence documents (these can include: excessive requirements to prove the duration and continuity of residence, e.g. proof of sufficient resources, confirmation of having paid social security contributions, knowledge of the local language and culture, etc.)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 20, 'question_id' => 9, 'guid' => 'c4c69b76-65c6-425a-ad7c-eedef5941d26', 'value' => 'item4', 'answer' => 'Accessing job market (these can include: difficulties in signing job contract as a result of not being able to receive required residency documents, discrimination on the basis of your nationality)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 21, 'question_id' => 9, 'guid' => '27c20f6b-dfdd-43d9-b373-7d449d07415e', 'value' => 'item5', 'answer' => 'I have not encountered any obstacles', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 22, 'question_id' => 11, 'guid' => '9b2e9a5e-d2e2-4ed5-6392-7331cba3ae45', 'value' => 'item1', 'answer' => 'European Parliament elections', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 23, 'question_id' => 11, 'guid' => '6e6509c4-409b-4b08-5589-47ca1f50ab98', 'value' => 'item2', 'answer' => 'Municipal elections (as a voter and/or a candidate)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 24, 'question_id' => 11, 'guid' => '0362cb26-57ef-4a2c-d094-8079ae5498e0', 'value' => 'item3', 'answer' => 'I have never participated in either EP or municipal elections', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 25, 'question_id' => 12, 'guid' => '722ad9f0-a50e-4cc2-7939-9dd6585ceeec', 'value' => 'item1', 'answer' => 'I was not aware of my right to participate', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 26, 'question_id' => 12, 'guid' => '9d87820d-25d5-46c8-0302-502e9d47f6fb', 'value' => 'item2', 'answer' => 'I encountered difficulties in the registration process', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 27, 'question_id' => 12, 'guid' => 'a679bf24-ff12-4b43-59b0-f0a2bef7d3d9', 'value' => 'item3', 'answer' => 'I missed the registration deadline', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 28, 'question_id' => 12, 'guid' => '8431978b-63cb-46b1-2161-9cafc73cf2b1', 'value' => 'item4', 'answer' => 'I am not interested in politics and I do not vote', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 29, 'question_id' => 12, 'guid' => '93aab746-2c98-42ca-ba80-fd2b8e2108e6', 'value' => 'item5', 'answer' => 'I do not believe my vote would have any impact on the final election result', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 30, 'question_id' => 12, 'guid' => '11ab3556-b35c-4736-c83e-3574dd2a4eed', 'value' => 'item6', 'answer' => 'I do not vote but I engage in alternative political and civic activities', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 31, 'question_id' => 12, 'guid' => '64dbdd43-ac78-4dc9-271c-872ddb31b61f', 'value' => 'item7', 'answer' => 'I participated in the elections to the European Parliament in my home country', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 32, 'question_id' => 13, 'guid' => '33f349c0-75a0-4141-1f19-3069df379b98', 'value' => 'item1', 'answer' => 'I was not allowed to participate (please explain the reasons given by the public administration)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 33, 'question_id' => 13, 'guid' => '2967116b-0dad-4ab5-9740-535ab984d1e1', 'value' => 'item2', 'answer' => 'I was not aware of my right to participate', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 34, 'question_id' => 13, 'guid' => '18f328d3-5784-4336-74cf-4687ff170c7d', 'value' => 'item3', 'answer' => 'I encountered difficulties in the registration process', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 35, 'question_id' => 13, 'guid' => '8f5202eb-4526-456e-6f62-45992fe5d93b', 'value' => 'item4', 'answer' => 'I missed the registration deadline', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 36, 'question_id' => 13, 'guid' => '80a7c629-51b1-4d47-b89e-35c323d3916e', 'value' => 'item5', 'answer' => 'I am not interested in politics and I do not vote', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 37, 'question_id' => 13, 'guid' => '62d2fd99-fed6-435d-e6c7-64803a3b2504', 'value' => 'item6', 'answer' => 'I do not have enough knowledge of the local political system', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 38, 'question_id' => 13, 'guid' => '6191ae41-9af7-4077-5578-46d332a618bf', 'value' => 'item7', 'answer' => 'I do not believe my vote would have any impact on the final election result', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 39, 'question_id' => 13, 'guid' => '611dd212-24ad-4e0b-2827-6ac438a847a3', 'value' => 'item8', 'answer' => 'I do not vote but I engage in alternative political and civic activities (please specify below)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 40, 'question_id' => 14, 'guid' => '42096760-8a6d-4db2-a4e7-baf4fbd7a387', 'value' => 'item1', 'answer' => 'I did not receive correct or clear information on the procedures', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 41, 'question_id' => 14, 'guid' => '02e95da2-be9a-4056-f607-96922b2a3713', 'value' => 'item2', 'answer' => 'I experienced problems with local authorities based on my nationality', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 42, 'question_id' => 14, 'guid' => '1978a37e-dc39-4898-c3ae-36c0fdadae21', 'value' => 'item3', 'answer' => 'Administrative procedures were lengthy and cumbersome', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 43, 'question_id' => 14, 'guid' => '0cfef759-c450-4a75-fce3-706fb4206f23', 'value' => 'item4', 'answer' => 'I have never made an attempt to register on the electoral roll', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 44, 'question_id' => 14, 'guid' => '9be7737d-0173-4176-a2cc-198fdbed06e1', 'value' => 'item5', 'answer' => 'None', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 45, 'question_id' => 15, 'guid' => '218bdc48-21cf-4d0a-43f3-8ac39880269f', 'value' => 'item1', 'answer' => 'Not having your national ID document recognized', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 46, 'question_id' => 15, 'guid' => 'dd2b2ce0-de23-4bcf-443f-0ceabe96cd6e', 'value' => 'item2', 'answer' => 'Not having permanent residence', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 47, 'question_id' => 15, 'guid' => 'ba26b50b-a64d-4d17-0a6d-4f406deaa26e', 'value' => 'item3', 'answer' => 'Not having a nationality of the country where you reside', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 48, 'question_id' => 15, 'guid' => '77424c5f-ab0e-4b8c-c715-fb910e0630af', 'value' => 'item4', 'answer' => 'I have never encountered such an issue', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 49, 'question_id' => 17, 'guid' => 'b1cc721c-f46f-4295-6dd9-7e1ca23d5f09', 'value' => 'item1', 'answer' => 'Yes, in my home country', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 50, 'question_id' => 17, 'guid' => 'fa9c52b3-d9fd-4a84-eb15-45abfa6b790f', 'value' => 'item2', 'answer' => 'Yes, in the EU Member State where I am currently residing', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 51, 'question_id' => 17, 'guid' => '4017cc49-ad29-4013-873d-e51e20739c86', 'value' => 'item3', 'answer' => 'No', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 52, 'question_id' => 17, 'guid' => 'c2565470-4852-42b6-198d-b85b8d621bca', 'value' => 'item4', 'answer' => 'I do not know', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 53, 'question_id' => 19, 'guid' => 'b1951f33-50b0-4731-b538-1767616de447', 'value' => 'item1', 'answer' => 'Demonstrations', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 54, 'question_id' => 19, 'guid' => '0a7d3052-810b-4bde-75b1-9b6e851e0cc6', 'value' => 'item2', 'answer' => 'Signing petitions', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 55, 'question_id' => 19, 'guid' => 'e84ca8ff-02da-4608-dd6b-f6376cfe71aa', 'value' => 'item3', 'answer' => 'Public meetings', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 56, 'question_id' => 19, 'guid' => '1bcdb62c-07f4-475c-99ea-02689dcaab4e', 'value' => 'item4', 'answer' => 'Volunteering', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 57, 'question_id' => 19, 'guid' => 'deaceec9-edaf-47cd-06f0-484667ff97c3', 'value' => 'item5', 'answer' => 'Public consultations', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 58, 'question_id' => 19, 'guid' => '78103aa1-4b9c-4785-9578-2175c85229d5', 'value' => 'item6', 'answer' => 'Membership of a political association/party', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 59, 'question_id' => 19, 'guid' => 'ea22bc82-4e78-4f14-4ef5-820ab60e3f1d', 'value' => 'item7', 'answer' => 'Membership of a non-political association', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 60, 'question_id' => 19, 'guid' => 'db3c1341-8de2-4934-97c1-a168f028889c', 'value' => 'item8', 'answer' => 'I have never participated in non-electoral political and/or civic activities', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 61, 'question_id' => 20, 'guid' => '5372d1cd-a092-4410-5e27-7ed0e45fe7f6', 'value' => 'item1', 'answer' => 'Knowledge of the local language and culture', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 62, 'question_id' => 20, 'guid' => '06938575-091c-4128-e8dc-29e43df518eb', 'value' => 'item2', 'answer' => 'Participation in the labour market', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 63, 'question_id' => 20, 'guid' => '1a2b45f1-3035-4ebf-c18a-562b6e90539a', 'value' => 'item3', 'answer' => 'Understanding of local politics', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 64, 'question_id' => 20, 'guid' => '792024f5-3125-4605-bc64-9062815c59d1', 'value' => 'item4', 'answer' => 'Participation in municipal elections', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 65, 'question_id' => 20, 'guid' => '7964e284-9f5e-428a-27e3-f8943a84a1be', 'value' => 'item5', 'answer' => 'Involvement in the issues relevant to the local community (e.g. signing petitions, participation in the local commissions, neighbours councils)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 66, 'question_id' => 16, 'guid' => 'cee8f784-4869-4ef6-7c23-82bcc9436182', 'value' => 'item1', 'answer' => 'I strongly agree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 67, 'question_id' => 16, 'guid' => '9e8e1a7e-c9de-4972-6f30-b1d1aca5daa0', 'value' => 'item2', 'answer' => 'I agree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 68, 'question_id' => 16, 'guid' => 'bf5c33a9-6f36-46d4-2bec-df4da01627e0', 'value' => 'item3', 'answer' => 'I neither agree nor disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 69, 'question_id' => 16, 'guid' => '8b8f0dad-8aa5-4e35-6ffb-5bae889263d3', 'value' => 'item4', 'answer' => 'I disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 70, 'question_id' => 16, 'guid' => 'e3f1aeb8-40fc-4834-c723-4770b66d5d7e', 'value' => 'item5', 'answer' => 'I strongly disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 71, 'question_id' => 21, 'guid' => '3d70a41f-6a20-48e7-7bc9-025363552952', 'value' => 'item1', 'answer' => 'I strongly agree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 72, 'question_id' => 21, 'guid' => '45f18bde-6c76-44ad-a8c5-41326ace47ba', 'value' => 'item2', 'answer' => 'I agree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 73, 'question_id' => 21, 'guid' => '51aeb713-b3ec-4675-b0ee-d90c1947209a', 'value' => 'item3', 'answer' => 'I neither agree nor disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 74, 'question_id' => 21, 'guid' => '2ab4d871-055b-4d2a-c42c-bb3a5a5e52c4', 'value' => 'item4', 'answer' => 'I disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 75, 'question_id' => 21, 'guid' => 'a332b067-8a8f-4f25-3559-61e75bb65c2f', 'value' => 'item5', 'answer' => 'I strongly disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 76, 'question_id' => 22, 'guid' => '4d64bf79-b693-4bc1-c934-00b70f9c4f30', 'value' => 'item1', 'answer' => 'I strongly agree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 77, 'question_id' => 22, 'guid' => '4312bb54-9ac6-440a-bd2d-cae0536051df', 'value' => 'item2', 'answer' => 'I agree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 78, 'question_id' => 22, 'guid' => 'a231f1ff-b1cd-45cc-e014-2ea8334cb54b', 'value' => 'item3', 'answer' => 'I neither agree nor disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 79, 'question_id' => 22, 'guid' => '81a6a212-b9ac-4d2f-95f5-d23edaf280ae', 'value' => 'item4', 'answer' => 'I disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 80, 'question_id' => 22, 'guid' => '05f24856-8c46-4e0d-46a2-3c7040fc809e', 'value' => 'item5', 'answer' => 'I strongly disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 81, 'question_id' => 23, 'guid' => '6178e896-0c63-4257-b2df-f07f5df298c1', 'value' => 'item1', 'answer' => 'I strongly agree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 82, 'question_id' => 23, 'guid' => '4638248a-cafc-4b9c-5cf0-5639f3a964ff', 'value' => 'item2', 'answer' => 'I agree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 83, 'question_id' => 23, 'guid' => '7371e782-3a77-49c4-e5c5-b216e1b3a22b', 'value' => 'item3', 'answer' => 'I neither agree nor disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 84, 'question_id' => 23, 'guid' => 'bb275ecd-5afc-406f-fe07-1d681cacbe20', 'value' => 'item4', 'answer' => 'I disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 85, 'question_id' => 23, 'guid' => 'a9d3762b-e0f5-44d6-445e-b229b795c692', 'value' => 'item5', 'answer' => 'I strongly disagree', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
        DB::table('questionnaire_html')->insert([
            ['id' => 1, 'question_id' => 2, 'html' => "<p>That’s great! It means that you know that EU citizens not only are allowed to move freely within the EU for work, studies, travel or joining their family members, but also have the right to vote and stand as candidates in municipal and European Parliament elections regardless of whether they are nationals of the EU country in which they reside. </p><p>This questionnaire, developed in the framework of the FAIR EU project (link to the project) aims at crowdsourcing EU citizens’ experience and opinion regarding the challenges to free movement and political participation.</p><p>Answering this questionnaire will take about 10 minutes. Your feedback will be invaluable in helping us to understand what obstacles EU citizens encounter when moving to or residing in an EU Member States other than their own, and being politically active.</p>", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'question_id' => 3, 'html' => "<p>EU citizenship is at the heart of the European integration project. Citizenship of the European Union was established with the Maastricht treaty in 1993. It is supplementary to national citizenship and confers on every national of an EU country a set of rights, such as the right to move and reside freely within the EU, as well as the right to vote and stand as a candidate in European and local elections.</p><p>This questionnaire, developed in the framework of the FAIR EU project (link to the project) aims at crowdsourcing EU citizens’ experience and opinion regarding the challenges to free movement and political participation.</p><p>Answering this questionnaire will take about 10 minutes. Your feedback will be invaluable in helping us to understand what obstacles EU citizens encounter when moving to or residing in the EU Member States other than their own, and being politically active.</p>", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'question_id' => 10, 'html' => "<p>Please provide more details on the obstacles faced in your host Member State</p>", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);


        DB::table('questionnaires')->insert([[
                    'id' => 2,
                    'project_id' => 3,
                    'status_id' => 2,
                    'default_language_id' => 6,
                    'title' => 'ICT for inclusive Pedagogy & Teaching',
                    'description' => 'What is the potential of ICT for inclusive Pedagogy & Teaching? Our preliminary results are now open for your insights. The consultation process has two parts.
                                    <br><br>
                                    <b>1st part - Your expert/practitioner profile:</b> Describe your background and experiences with ICT in practice. (Once you do this, you do not need to fill it in again; next time you contribute can just log in)
                                    <br>
                                    <b>2nd part - Your voice:</b> See our preliminary results and amend, change or revise the text from your experience. Please do also add your own examples of use of ICT that have been successful in the area of Vocational Education and Training.',
                    'goal' => 30,
                    'questionnaire_json' => '{  
           "pages":[  
              {  
                 "name":"page1",
                 "elements":[  
                    {  
                       "type":"html",
                       "name":"question1",
                       "guid":"b4897c7b-87a8-4fa0-b862-d003d744d5cb",
                       "html":"<h2>Part 1: Short survey</h2>"
                    },
                    {  
                       "type":"text",
                       "name":"question2",
                       "guid":"4dc86ae1-76e8-458f-722b-93edbdd0abfb",
                       "title":"Which types of diverse support needs for learning do you have to handle in your teaching?",
                       "isRequired":true
                    },
                    {  
                       "type":"text",
                       "name":"question3",
                       "guid":"55998ec9-805f-42e6-8fc5-80389ecabc34",
                       "title":"What are your most important objectives to use ICT in your teaching, and why?",
                       "isRequired":true
                    },
                    {  
                       "type":"text",
                       "name":"question4",
                       "guid":"728b8187-72d5-441f-4266-5c1d183140ed",
                       "title":"Which limiting factors have you experienced concerning using ICT in teaching?",
                       "isRequired":true
                    },
                    {  
                       "type":"text",
                       "name":"question5",
                       "guid":"c7be96bd-edb6-493d-ade6-2e20b240d83b",
                       "title":"What are your most important reasons not to use ICT in your teaching, and why?",
                       "isRequired":true
                    },
                    {  
                       "type":"text",
                       "name":"question6",
                       "guid":"daf6b6f8-7989-46d6-b36d-fc2f335f7d74",
                       "title":"Which obstacles and constraints do you encounter or think upon regarding the use of ICT in teaching?",
                       "isRequired":true
                    },
                    {  
                       "type":"text",
                       "name":"question7",
                       "guid":"0d13d4ac-f251-4fb5-5cc3-d9f2e178f243",
                       "title":"What are you missing to be able to use ICT in teaching?",
                       "isRequired":true
                    },
                    {  
                       "type":"text",
                       "name":"question8",
                       "guid":"8d6878d5-d10c-47f1-515a-addf1e3eaa6d",
                       "title":"In which way does ICT help out to minimise the ‘differences’ between your students / learners?",
                       "isRequired":true
                    },
                    {  
                       "type":"text",
                       "name":"question9",
                       "guid":"0e098756-ff27-4443-1fee-cab9afcb1031",
                       "title":"What is the expected outcome for students when ICT is used in your teaching,  and how do you find out?",
                       "isRequired":true
                    },
                    {  
                       "type":"text",
                       "name":"question10",
                       "guid":"86bd208f-4e85-418f-1fac-7c7c63cb19e3",
                       "title":"Anything else you want to add here?"
                    },
                    {  
                       "type":"html",
                       "name":"question11",
                       "guid":"d5eb99ec-72d1-401b-97c5-0d3d9e8944aa",
                       "html":"<h4>As to better understand your background and your context from which you answered the questions above, please allow us to ask some further questions regarding you. (If you want to be involved in future EICON surveys on the other thematic areas, please first register at this platform and create an account that you can use in the future; then you do not need to fill this data in for each survey, rather it is saved with your profile).</h4>"
                    },
                    {  
                       "type":"text",
                       "name":"question12",
                       "guid":"c311c515-1611-4d3b-1a28-e5e94fac2a71",
                       "title":"In which type of educational organisation are you working? ",
                       "isRequired":true,
                       "placeHolder":"(please let us know the type of organisation both in your native language and ideally also in English if possible)"
                    },
                    {  
                       "type":"text",
                       "name":"question13",
                       "guid":"6df1666d-682f-40b7-48b7-1017598a6bc4",
                       "title":"What is your role and education?",
                       "isRequired":true,
                       "placeHolder":"(roles: e.g. teacher, support / assistant teacher, trainer, instructor etc.)"
                    },
                    {  
                       "type":"text",
                       "name":"question14",
                       "guid":"0df503e2-71af-4aac-b5cc-24bd90f3d298",
                       "title":"For how long have you approximately been working in this role?",
                       "isRequired":true,
                       "inputType":"number",
                       "placeHolder":"(in years)"
                    },
                    {  
                       "type":"text",
                       "name":"question15",
                       "guid":"4639a0b5-ab1e-417e-3847-e26e75db190b",
                       "title":"Please describe shortly the ICT equipment and organization of ICT at your workplace",
                       "isRequired":true
                    },
                    {  
                       "type":"html",
                       "name":"question18",
                       "guid":"ad277ad4-fa74-4f20-c48a-18c2d9e92ffd",
                       "html":"<h4>How proficient are you with regard to using information and communication technology (ICT) with regard to:</h4>"
                    },
                    {  
                       "type":"dropdown",
                       "name":"question17",
                       "guid":"0edcad79-8cc7-44e7-90fe-5585e7501764",
                       "title":"... professional engagement?",
                       "isRequired":true,
                       "hasOther":true,
                       "choices":[  
                          {  
                             "value":"item1",
                             "text":"awareness, uncertainty, basic use",
                             "guid":"3d9fff03-b40a-4cd3-3fe0-09e2e15f6cb5"
                          },
                          {  
                             "value":"item2",
                             "text":"exploring digital options",
                             "guid":"d0941512-a41e-4d4e-3c58-481ef762d5c1"
                          },
                          {  
                             "value":"item3",
                             "text":"expanding professional practice",
                             "guid":"13e3d305-8cd2-4f8e-5dce-c700024d2cd6"
                          },
                          {  
                             "value":"item4",
                             "text":"enhancing professional practice",
                             "guid":"ed69f1d0-f131-4afc-0ac4-502bfaa32a34"
                          },
                          {  
                             "value":"item5",
                             "text":"discussing and renewing professional practice",
                             "guid":"42115332-8be2-4b52-0873-21dcfb67aa58"
                          },
                          {  
                             "value":"item6",
                             "text":"innovating professional practice",
                             "guid":"9f751f33-0db7-4a68-729b-b96e8faa3536"
                          }
                       ]
                    },
                    {  
                       "type":"dropdown",
                       "name":"question19",
                       "guid":"67d1ba8f-bcc3-4618-d288-c0092e298e85",
                       "title":"... digital resources?",
                       "isRequired":true,
                       "hasOther":true,
                       "choices":[  
                          {  
                             "value":"item1",
                             "text":"awareness, uncertainty, basic use",
                             "guid":"489718f9-09b9-4667-a202-8095874fa611"
                          },
                          {  
                             "value":"item2",
                             "text":"exploring digital resources",
                             "guid":"df81a9f2-1ad9-4ebd-6fef-c17594270ed4"
                          },
                          {  
                             "value":"item3",
                             "text":"fitting digital resources to the learning context",
                             "guid":"7c020161-55fa-4c9c-b254-68f508318295"
                          },
                          {  
                             "value":"item4",
                             "text":"strategically using interactive resources",
                             "guid":"0bb87c25-b8a7-43a7-2b9b-976816d95052"
                          },
                          {  
                             "value":"item5",
                             "text":"comprehensively using advanced strategies & resources",
                             "guid":"7e44cd17-5c9e-4bf4-9859-082fc5f8fa14"
                          },
                          {  
                             "value":"item6",
                             "text":"promoting the use of digital resources",
                             "guid":"8d54e9d2-470c-41cb-b9ba-fc575ba331fd"
                          }
                       ]
                    },
                    {  
                       "type":"dropdown",
                       "name":"question16",
                       "guid":"ac6d9e3b-d9d8-4517-4a51-819431fe5de5",
                       "title":"... teaching and learning?",
                       "isRequired":true,
                       "hasOther":true,
                       "choices":[  
                          {  
                             "value":"item1",
                             "text":"awareness, uncertainty, basic use",
                             "guid":"e53edaaa-5e3e-4f66-a825-feb427bc4a98"
                          },
                          {  
                             "value":"item2",
                             "text":"exploring digital teaching & learning strategies",
                             "guid":"a775d447-60de-4c58-858f-6f461e2bee3d"
                          },
                          {  
                             "value":"item3",
                             "text":"meaningfully integrating digital technologies",
                             "guid":"71f988d8-128c-4238-208f-baf644b74ed2"
                          },
                          {  
                             "value":"item4",
                             "text":"enhancing teaching & learning activities",
                             "guid":"6ce7976d-9036-4718-f033-4cfed1e84c0a"
                          },
                          {  
                             "value":"item5",
                             "text":"strategically & purposefully renewing teaching practice",
                             "guid":"8c5baef8-d922-4863-385b-0ec66524a62d"
                          },
                          {  
                             "value":"item6",
                             "text":"innovating teaching",
                             "guid":"1c4cd40b-b66c-46df-bc40-16f4061f306e"
                          }
                       ]
                    },
                    {  
                       "type":"dropdown",
                       "name":"question20",
                       "title":"... assessment?",
                       "isRequired":true,
                       "hasOther":true,
                       "choices":[  
                          {  
                             "value":"item1",
                             "text":"awareness, uncertainty, basic use",
                             "guid":"833b1053-f23f-497b-c7ad-566f1fe9c1dc"
                          },
                          {  
                             "value":"item2",
                             "text":"exploring digital assessment strategies",
                             "guid":"6176e187-0b6d-4f12-54fa-35c641e1c966"
                          },
                          {  
                             "value":"item3",
                             "text":"enhancing traditional assessment approaches",
                             "guid":"30dd2519-2428-4b7a-c4f7-4eb514f6ae0e"
                          },
                          {  
                             "value":"item4",
                             "text":"strategic and effective use of digital assessment",
                             "guid":"cf2debb7-bffa-44e2-b66d-d8ac442bd9a5"
                          },
                          {  
                             "value":"item5",
                             "text":"critically reflecting on digital assessment strategies",
                             "guid":"7d84344a-07f0-41d5-7adf-736e69e7ffa0"
                          },
                          {  
                             "value":"item6",
                             "text":"innovating assessment",
                             "guid":"7abbb1f7-46e2-4671-faf8-e6165c2d4eef"
                          }
                       ],
                       "guid":"ac76204e-493a-4712-0780-409e73c665db"
                    },
                    {  
                       "type":"dropdown",
                       "name":"question21",
                       "title":"... empowering learners?",
                       "isRequired":true,
                       "hasOther":true,
                       "choices":[  
                          {  
                             "value":"item1",
                             "text":"awareness, uncertainty, basic use",
                             "guid":"b24d981e-1082-4759-5d91-acbc8e195035"
                          },
                          {  
                             "value":"item2",
                             "text":"exploring learner-centred strategies",
                             "guid":"3d197f98-dde8-42cd-f8e2-645859147aa1"
                          },
                          {  
                             "value":"item3",
                             "text":"addressing learner empowerment",
                             "guid":"4a019589-7405-4cdf-bc99-38345273edd6"
                          },
                          {  
                             "value":"item4",
                             "text":"strategically using a range of tools to empower",
                             "guid":"30256845-a8fc-44be-d86d-6e95e42cea0b"
                          },
                          {  
                             "value":"item5",
                             "text":"holistically empowering learners",
                             "guid":"81c4eb22-8a78-458e-fb9f-9d7f8b5566d2"
                          },
                          {  
                             "value":"item6",
                             "text":"innovating learner involvement",
                             "guid":"87a87279-d84f-44a6-6ccf-9cf1433865e3"
                          }
                       ],
                       "guid":"3156ae6e-aa0a-4108-fd69-69acf5702e51"
                    },
                    {  
                       "type":"dropdown",
                       "name":"question22",
                       "title":"... facilitating learners’ digital competence?",
                       "isRequired":true,
                       "hasOther":true,
                       "choices":[  
                          {  
                             "value":"item1",
                             "text":"awareness, uncertainty, basic use",
                             "guid":"2d6be908-1eaa-4802-11b3-fb17c6906707"
                          },
                          {  
                             "value":"item2",
                             "text":"encouraging learners to use digital technologies",
                             "guid":"ab5d84af-8004-4668-e5e7-0ca039534227"
                          },
                          {  
                             "value":"item3",
                             "text":"implementing activities to foster learners’ digital competence",
                             "guid":"7e1ffbf8-3884-4eeb-8ef1-5f6bf0c8ea3a"
                          },
                          {  
                             "value":"item4",
                             "text":"strategically fostering learners’ digital competence",
                             "guid":"bf2cfd9f-9e18-403c-f06b-053945eb3bba"
                          },
                          {  
                             "value":"item5",
                             "text":"comprehensively & critically fostering learners’ digital competence",
                             "guid":"4fa0420b-0d97-460c-539a-62583198e286"
                          },
                          {  
                             "value":"item6",
                             "text":"using innovative formats to foster learners’ digital competence",
                             "guid":"f086523d-617c-4da9-f405-ea16770821a6"
                          }
                       ],
                       "guid":"db52d53b-119b-4dac-9a72-fa2c331f68f8"
                    },
                    {  
                       "type":"text",
                       "name":"question23",
                       "title":"Do you / does your organization follow up on how the pupils have completed their education and, if so, how crucial have their knowledge about ICT contributed to employment? ",
                       "isRequired":true,
                       "guid":"df4bad22-2b44-41f1-53e4-98d85956017a"
                    },
                    {  
                       "type":"text",
                       "name":"question24",
                       "title":"How do you handle the challenges in ICT use and gender?",
                       "isRequired":true,
                       "guid":"67440641-2721-4d40-654b-cabe5990de65"
                    },
                    {  
                       "type":"text",
                       "name":"question25",
                       "title":"How do you “catch” (recognize and understand) the needs of your students / learners?",
                       "isRequired":true,
                       "guid":"82c24361-9628-48b9-fe80-c9ddf49a8401"
                    },
                    {  
                       "type":"text",
                       "name":"question26",
                       "title":"Anything else you want to add?",
                       "guid":"21858088-6362-423c-2d31-315a242512fb"
                    },
                    {  
                       "type":"radiogroup",
                       "name":"Your gender",
                       "isRequired":true,
                       "hasOther":true,
                       "choices":[  
                          {  
                             "value":"item1",
                             "text":"Male",
                             "guid":"2eadabfd-253f-4f8b-54ec-c555405b50e7"
                          },
                          {  
                             "value":"item2",
                             "text":"Female",
                             "guid":"2e8350ff-df05-4c43-28d5-092a634921c4"
                          }
                       ],
                       "guid":"1741e679-e19b-42ca-3d1d-143761ca3e83"
                    },
                    {  
                       "type":"text",
                       "name":"question27",
                       "title":"Your age",
                       "isRequired":true,
                       "inputType":"number",
                       "guid":"22e87dd5-8b77-43fb-949d-1b19664e062b"
                    },
                    {  
                       "type":"text",
                       "name":"question28",
                       "title":"Your country",
                       "isRequired":true,
                       "guid":"497dc861-87ee-434d-5a15-1feb13ef574b"
                    }
                 ]
              }
           ]
        }']]);
        DB::table('questionnaire_questions')->insert([
            ['id' => 25, 'questionnaire_id' => 2, 'guid' => 'b4897c7b-87a8-4fa0-b862-d003d744d5cb', 'order_id' => 1, 'name' => 'question1', 'type' => 'html', 'question' => 'question1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 26, 'questionnaire_id' => 2, 'guid' => '4dc86ae1-76e8-458f-722b-93edbdd0abfb', 'order_id' => 2, 'name' => 'question2', 'type' => 'text', 'question' => 'Which types of diverse support needs for learning do you have to handle in your teaching?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 27, 'questionnaire_id' => 2, 'guid' => '55998ec9-805f-42e6-8fc5-80389ecabc34', 'order_id' => 3, 'name' => 'question3', 'type' => 'text', 'question' => 'What are your most important objectives to use ICT in your teaching, and why?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 28, 'questionnaire_id' => 2, 'guid' => '728b8187-72d5-441f-4266-5c1d183140ed', 'order_id' => 4, 'name' => 'question4', 'type' => 'text', 'question' => 'Which limiting factors have you experienced concerning using ICT in teaching?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 29, 'questionnaire_id' => 2, 'guid' => 'c7be96bd-edb6-493d-ade6-2e20b240d83b', 'order_id' => 5, 'name' => 'question5', 'type' => 'text', 'question' => 'What are your most important reasons not to use ICT in your teaching, and why?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 30, 'questionnaire_id' => 2, 'guid' => 'daf6b6f8-7989-46d6-b36d-fc2f335f7d74', 'order_id' => 6, 'name' => 'question6', 'type' => 'text', 'question' => 'Which obstacles and constraints do you encounter or think upon regarding the use of ICT in teaching?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 31, 'questionnaire_id' => 2, 'guid' => '0d13d4ac-f251-4fb5-5cc3-d9f2e178f243', 'order_id' => 7, 'name' => 'question7', 'type' => 'text', 'question' => 'What are you missing to be able to use ICT in teaching?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 32, 'questionnaire_id' => 2, 'guid' => '8d6878d5-d10c-47f1-515a-addf1e3eaa6d', 'order_id' => 8, 'name' => 'question8', 'type' => 'text', 'question' => 'In which way does ICT help out to minimise the ‘differences’ between your students / learners?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 33, 'questionnaire_id' => 2, 'guid' => '0e098756-ff27-4443-1fee-cab9afcb1031', 'order_id' => 9, 'name' => 'question9', 'type' => 'text', 'question' => 'What is the expected outcome for students when ICT is used in your teaching,  and how do you find out?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 34, 'questionnaire_id' => 2, 'guid' => '86bd208f-4e85-418f-1fac-7c7c63cb19e3', 'order_id' => 10, 'name' => 'question10', 'type' => 'text', 'question' => 'Anything else you want to add here?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 35, 'questionnaire_id' => 2, 'guid' => 'd5eb99ec-72d1-401b-97c5-0d3d9e8944aa', 'order_id' => 11, 'name' => 'question11', 'type' => 'html', 'question' => 'question11', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 36, 'questionnaire_id' => 2, 'guid' => 'c311c515-1611-4d3b-1a28-e5e94fac2a71', 'order_id' => 12, 'name' => 'question12', 'type' => 'text', 'question' => 'In which type of educational organisation are you working?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 37, 'questionnaire_id' => 2, 'guid' => '6df1666d-682f-40b7-48b7-1017598a6bc4', 'order_id' => 13, 'name' => 'question13', 'type' => 'text', 'question' => 'What is your role and education?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 38, 'questionnaire_id' => 2, 'guid' => '0df503e2-71af-4aac-b5cc-24bd90f3d298', 'order_id' => 14, 'name' => 'question14', 'type' => 'text', 'question' => 'For how long have you approximately been working in this role?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 39, 'questionnaire_id' => 2, 'guid' => '4639a0b5-ab1e-417e-3847-e26e75db190b', 'order_id' => 15, 'name' => 'question15', 'type' => 'text', 'question' => 'Please describe shortly the ICT equipment and organization of ICT at your workplace', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 40, 'questionnaire_id' => 2, 'guid' => 'ad277ad4-fa74-4f20-c48a-18c2d9e92ffd', 'order_id' => 16, 'name' => 'question18', 'type' => 'html', 'question' => 'question18', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 41, 'questionnaire_id' => 2, 'guid' => '0edcad79-8cc7-44e7-90fe-5585e7501764', 'order_id' => 17, 'name' => 'question17', 'type' => 'dropdown', 'question' => '... professional engagement?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 42, 'questionnaire_id' => 2, 'guid' => '67d1ba8f-bcc3-4618-d288-c0092e298e85', 'order_id' => 18, 'name' => 'question19', 'type' => 'dropdown', 'question' => '... digital resources?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 43, 'questionnaire_id' => 2, 'guid' => 'ac6d9e3b-d9d8-4517-4a51-819431fe5de5', 'order_id' => 19, 'name' => 'question16', 'type' => 'dropdown', 'question' => '... teaching and learning?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 44, 'questionnaire_id' => 2, 'guid' => 'ac76204e-493a-4712-0780-409e73c665db', 'order_id' => 20, 'name' => 'question20', 'type' => 'dropdown', 'question' => '... assessment?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 45, 'questionnaire_id' => 2, 'guid' => '3156ae6e-aa0a-4108-fd69-69acf5702e51', 'order_id' => 21, 'name' => 'question21', 'type' => 'dropdown', 'question' => '... empowering learners?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 46, 'questionnaire_id' => 2, 'guid' => 'db52d53b-119b-4dac-9a72-fa2c331f68f8', 'order_id' => 22, 'name' => 'question22', 'type' => 'dropdown', 'question' => '... facilitating learners’ digital competence?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 47, 'questionnaire_id' => 2, 'guid' => 'df4bad22-2b44-41f1-53e4-98d85956017a', 'order_id' => 23, 'name' => 'question23', 'type' => 'text', 'question' => 'Do you / does your organization follow up on how the pupils have completed their education and, if so, how crucial have their knowledge about ICT contributed to employment?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 48, 'questionnaire_id' => 2, 'guid' => '67440641-2721-4d40-654b-cabe5990de65', 'order_id' => 24, 'name' => 'question24', 'type' => 'text', 'question' => 'How do you handle the challenges in ICT use and gender?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 49, 'questionnaire_id' => 2, 'guid' => '82c24361-9628-48b9-fe80-c9ddf49a8401', 'order_id' => 25, 'name' => 'question25', 'type' => 'text', 'question' => 'How do you “catch” (recognize and understand) the needs of your students / learners?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 50, 'questionnaire_id' => 2, 'guid' => '21858088-6362-423c-2d31-315a242512fb', 'order_id' => 26, 'name' => 'question26', 'type' => 'text', 'question' => 'Anything else you want to add?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 51, 'questionnaire_id' => 2, 'guid' => '1741e679-e19b-42ca-3d1d-143761ca3e83', 'order_id' => 27, 'name' => 'Your gender', 'type' => 'radiogroup', 'question' => 'Your gender', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 52, 'questionnaire_id' => 2, 'guid' => '22e87dd5-8b77-43fb-949d-1b19664e062b', 'order_id' => 28, 'name' => 'question27', 'type' => 'text', 'question' => 'Your age', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 53, 'questionnaire_id' => 2, 'guid' => '497dc861-87ee-434d-5a15-1feb13ef574b', 'order_id' => 29, 'name' => 'question28', 'type' => 'text', 'question' => 'Your country', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);

        DB::table('questionnaire_possible_answers')->insert([
            ['id' => 86, 'question_id' => 41, 'guid' => '3d9fff03-b40a-4cd3-3fe0-09e2e15f6cb5', 'value' => 'item1', 'answer' => 'awareness, uncertainty, basic use', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 87, 'question_id' => 41, 'guid' => 'd0941512-a41e-4d4e-3c58-481ef762d5c1', 'value' => 'item2', 'answer' => 'exploring digital options', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 88, 'question_id' => 41, 'guid' => '13e3d305-8cd2-4f8e-5dce-c700024d2cd6', 'value' => 'item3', 'answer' => 'expanding professional practice', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 89, 'question_id' => 41, 'guid' => 'ed69f1d0-f131-4afc-0ac4-502bfaa32a34', 'value' => 'item4', 'answer' => 'enhancing professional practice', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 90, 'question_id' => 41, 'guid' => '42115332-8be2-4b52-0873-21dcfb67aa58', 'value' => 'item5', 'answer' => 'discussing and renewing professional practice', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 91, 'question_id' => 41, 'guid' => '9f751f33-0db7-4a68-729b-b96e8faa3536', 'value' => 'item6', 'answer' => 'innovating professional practice', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 92, 'question_id' => 41, 'guid' => 'other', 'value' => 'other', 'answer' => 'Other (please describe)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 93, 'question_id' => 42, 'guid' => '489718f9-09b9-4667-a202-8095874fa611', 'value' => 'item1', 'answer' => 'awareness, uncertainty, basic use', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 94, 'question_id' => 42, 'guid' => 'df81a9f2-1ad9-4ebd-6fef-c17594270ed4', 'value' => 'item2', 'answer' => 'exploring digital resources', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 95, 'question_id' => 42, 'guid' => '7c020161-55fa-4c9c-b254-68f508318295', 'value' => 'item3', 'answer' => 'fitting digital resources to the learning context', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 96, 'question_id' => 42, 'guid' => '0bb87c25-b8a7-43a7-2b9b-976816d95052', 'value' => 'item4', 'answer' => 'strategically using interactive resources', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 97, 'question_id' => 42, 'guid' => '7e44cd17-5c9e-4bf4-9859-082fc5f8fa14', 'value' => 'item5', 'answer' => 'strategically using interactive resources', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 98, 'question_id' => 42, 'guid' => '8d54e9d2-470c-41cb-b9ba-fc575ba331fd', 'value' => 'item6', 'answer' => 'promoting the use of digital resources', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 99, 'question_id' => 42, 'guid' => 'other', 'value' => 'other', 'answer' => 'Other (please describe)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 100, 'question_id' => 43, 'guid' => 'e53edaaa-5e3e-4f66-a825-feb427bc4a98', 'value' => 'item1', 'answer' => 'awareness, uncertainty, basic use', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 101, 'question_id' => 43, 'guid' => 'a775d447-60de-4c58-858f-6f461e2bee3d', 'value' => 'item2', 'answer' => 'exploring digital teaching & learning strategies', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 102, 'question_id' => 43, 'guid' => '71f988d8-128c-4238-208f-baf644b74ed2', 'value' => 'item3', 'answer' => 'meaningfully integrating digital technologies', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 103, 'question_id' => 43, 'guid' => '6ce7976d-9036-4718-f033-4cfed1e84c0a', 'value' => 'item4', 'answer' => 'enhancing teaching & learning activities', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 104, 'question_id' => 43, 'guid' => '8c5baef8-d922-4863-385b-0ec66524a62d', 'value' => 'item5', 'answer' => 'strategically & purposefully renewing teaching practice', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 105, 'question_id' => 43, 'guid' => '1c4cd40b-b66c-46df-bc40-16f4061f306e', 'value' => 'item6', 'answer' => 'innovating teaching', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 106, 'question_id' => 43, 'guid' => 'other', 'value' => 'other', 'answer' => 'Other (please describe)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 107, 'question_id' => 44, 'guid' => '833b1053-f23f-497b-c7ad-566f1fe9c1dc', 'value' => 'item1', 'answer' => 'awareness, uncertainty, basic use', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 108, 'question_id' => 44, 'guid' => '6176e187-0b6d-4f12-54fa-35c641e1c966', 'value' => 'item2', 'answer' => 'exploring digital assessment strategies', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 109, 'question_id' => 44, 'guid' => '30dd2519-2428-4b7a-c4f7-4eb514f6ae0e', 'value' => 'item3', 'answer' => 'enhancing traditional assessment approaches', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 110, 'question_id' => 44, 'guid' => 'cf2debb7-bffa-44e2-b66d-d8ac442bd9a5', 'value' => 'item4', 'answer' => 'strategic and effective use of digital assessment', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 111, 'question_id' => 44, 'guid' => '7d84344a-07f0-41d5-7adf-736e69e7ffa0', 'value' => 'item5', 'answer' => 'critically reflecting on digital assessment strategies', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 112, 'question_id' => 44, 'guid' => '7abbb1f7-46e2-4671-faf8-e6165c2d4eef', 'value' => 'item6', 'answer' => 'innovating assessment', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 113, 'question_id' => 44, 'guid' => 'other', 'value' => 'other', 'answer' => 'Other (please describe)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 114, 'question_id' => 45, 'guid' => 'b24d981e-1082-4759-5d91-acbc8e195035', 'value' => 'item1', 'answer' => 'awareness, uncertainty, basic use', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 115, 'question_id' => 45, 'guid' => '3d197f98-dde8-42cd-f8e2-645859147aa1', 'value' => 'item2', 'answer' => 'exploring learner-centred strategies', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 116, 'question_id' => 45, 'guid' => '4a019589-7405-4cdf-bc99-38345273edd6', 'value' => 'item3', 'answer' => 'addressing learner empowerment', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 117, 'question_id' => 45, 'guid' => '30256845-a8fc-44be-d86d-6e95e42cea0b', 'value' => 'item4', 'answer' => 'strategically using a range of tools to empower', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 118, 'question_id' => 45, 'guid' => '81c4eb22-8a78-458e-fb9f-9d7f8b5566d2', 'value' => 'item5', 'answer' => 'holistically empowering learners', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 119, 'question_id' => 45, 'guid' => '87a87279-d84f-44a6-6ccf-9cf1433865e3', 'value' => 'item6', 'answer' => 'innovating learner involvement', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 120, 'question_id' => 45, 'guid' => 'other', 'value' => 'other', 'answer' => 'Other (please describe)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 121, 'question_id' => 46, 'guid' => '2d6be908-1eaa-4802-11b3-fb17c6906707', 'value' => 'item1', 'answer' => 'awareness, uncertainty, basic use', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 122, 'question_id' => 46, 'guid' => 'ab5d84af-8004-4668-e5e7-0ca039534227', 'value' => 'item2', 'answer' => 'encouraging learners to use digital technologies', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 123, 'question_id' => 46, 'guid' => '7e1ffbf8-3884-4eeb-8ef1-5f6bf0c8ea3a', 'value' => 'item3', 'answer' => 'implementing activities to foster learners’ digital competence', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 124, 'question_id' => 46, 'guid' => 'bf2cfd9f-9e18-403c-f06b-053945eb3bba', 'value' => 'item4', 'answer' => 'strategically fostering learners’ digital competence', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 125, 'question_id' => 46, 'guid' => '4fa0420b-0d97-460c-539a-62583198e286', 'value' => 'item5', 'answer' => 'comprehensively & critically fostering learners’ digital competence', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 126, 'question_id' => 46, 'guid' => 'f086523d-617c-4da9-f405-ea16770821a6', 'value' => 'item6', 'answer' => 'using innovative formats to foster learners’ digital competence', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 127, 'question_id' => 46, 'guid' => 'other', 'value' => 'other', 'answer' => 'Other (please describe)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 128, 'question_id' => 51, 'guid' => '2eadabfd-253f-4f8b-54ec-c555405b50e7', 'value' => 'item1', 'answer' => 'Male', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 129, 'question_id' => 51, 'guid' => '2e8350ff-df05-4c43-28d5-092a634921c4', 'value' => 'item2', 'answer' => 'Female', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 130, 'question_id' => 51, 'guid' => 'other', 'value' => 'other', 'answer' => 'Other (please describe)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);

        DB::table('questionnaire_html')->insert([
            ['id' => 4, 'question_id' => 25, 'html' => "<h2>Part 1: Short survey</h2>", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'question_id' => 35, 'html' => "<h4>As to better understand your background and your context from which you answered the questions above, please allow us to ask some further questions regarding you. (If you want to be involved in future EICON surveys on the other thematic areas, please first register at this platform and create an account that you can use in the future; then you do not need to fill this data in for each survey, rather it is saved with your profile).</h4>", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'question_id' => 40, 'html' => "<h4>How proficient are you with regard to using information and communication technology (ICT) with regard to:</h4>", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            ]);
    }
}
