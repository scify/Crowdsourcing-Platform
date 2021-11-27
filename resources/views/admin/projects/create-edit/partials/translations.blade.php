<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- Is the project has just been created, the user should complete it first --}}
                @if (!$viewModel->isEditMode())
                    Please <b>save the project first </b> to start translating.

                @else
                {{-- the view model should be extended to bring also
                 the language look up and
                 crowd_sourcing_project_translations data for this project
                  --}}
                <translations-manager
                        :model-meta-data='{
                            "name":{
                              "display_title" :"Project Name (*)",
                              "required": true
                            },
                            "description":{
                                "display_title" :"Project description (*)",
                                "required": true
                            },
                            "motto_title":{
                                "display_title" :"Project Motto Title (*)",
                                "required": true
                            },
                            "motto_subtitle":{
                                "display_title" :"Project Motto Subtitle",
                                "required": true
                            },
                            "about":{
                                "display_title" :"About Text (*)",
                                "required": true
                            },
                            "footer":{
                                "display_title" :"Footer Text (*)",
                                "required": true
                            },
                            "sm_title":{
                                "display_title" :"Social Media Title",
                                "required": true
                            },
                            "sm_description":{
                                "display_title" :"Social Media Description",
                                "required": true
                            },
                             "sm_keywords":{
                                "display_title" :"Social Media Keywords",
                                "required": true
                            },
                             "questionnaire_response_email_intro_text":{
                                "display_title" :"Congratulations email intro text",
                                "required": true
                            },
                             "questionnaire_response_email_outro_text":{
                                "display_title" :"Congratulations email outro text",
                                "required": true
                            }
                        }'
                        :available-languages='[
                        {
                            "id":1,
                            "language_name":"Bulgarian",
                            "language_code":"bg"
                        },
                        {
                            "id":6,
                            "language_name":"English",
                            "language_code":"en"
                        },
                        {
                            "id":11,
                            "language_name":"Greek",
                            "language_code":"el"
                        },
                         {
                            "id":2,
                            "language_name":"Croatian",
                            "language_code":"hr"
                        }
                        ]'
                    :existing-translations=' [{
                            "language_id": 6,
                            "project_id": 8,
                            "name" : " original translation name",
                            "motto_title": " original translation moto",
                            "motto_subtitle": " original translation subtitle",
                            "description": " original translation descritpion",
                            "about" :" original translation about",
                            "footer": " original translation footer",
                            "sm_title": " original translation sm title",
                            "sm_description": " original translation sm descr",
                            "sm_keywords": " original translation sm keywords",
                            "questionnaire_response_email_intro_text": "original email intro",
                            "questionnaire_response_email_outro_text": "original email outro"
                          },
                            {
                              "language_id": 1,
                              "project_id": 8,
                              "name" : "other name",
                              "motto_title" : "other moto",
                              "motto_subtitle":"other subtitle ",
                              "description": "other descritpion",
                              "about" : "other about",
                              "footer": "other footer",
                              "sm_title" : "other sm title",
                              "sm_description": "other sm descr",
                              "sm_keywords": "other  sm keywords",
                                "questionnaire_response_email_intro_text": "original email intro",
                                "questionnaire_response_email_outro_text": "original email outro"
                            },
                             {
                              "language_id": 2,
                              "project_id": 8,
                              "name" : "other name 2",
                              "motto_title" : "other moto2",
                              "motto_subtitle":"other subtitle 2",
                              "description": "other descritpion 2",
                              "about" : "other about 2",
                              "footer": "other footer 2",
                              "sm_title" : "other sm title 2",
                              "sm_description": "other sm descr 2",
                              "sm_keywords": "other  sm keywords 2",
                              "questionnaire_response_email_intro_text": "original email intro",
                              "questionnaire_response_email_outro_text": "original email outro"
                            }
                          ]'
                />




                @endif

            </div>
        </div>
    </div>
</div>

<script>
    import TranslationsManager from "../../../../../assets/js/vue-components/common/TranslationsManager";
    export default {
        components: {TranslationsManager}
    }
</script>
