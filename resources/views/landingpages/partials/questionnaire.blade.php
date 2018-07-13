<div class="row">
    <div class="col-md-12">
        <div class="content-container">
            <div class="row">
                <div class="col-md-6">
                    <div class="questionnaire-wrapper"
                         style="border: 1px solid #99aec1; background-color: white;">
                        <div class="questionnaire-title"
                             style="background-color: #ced8e1; color: black; font-weight: 600;
                             border-bottom: 1px solid #99aec1; text-align: center; padding: 10px;">
                            <p style="font-size: 16px; margin: 0;">Questionnaire</p>
                        </div>
                        <div class="questionnaire-content" style="padding: 100px 10px;">
                            @if($viewModel->questionnaire)
                                <p style="font-size: 18px; text-align: center;">{{$viewModel->questionnaire->description}}</p>
                                @if(\Auth::user())
                                    <a href="javascript:void(0)" class="btn btn-block btn-primary" style="width: 250px;
                                        margin: 20px auto 0;" data-toggle="modal" data-target="#questionnaire-modal">Take questionnaire</a>
                                @else
                                    <a href="/login" class="btn btn-block btn-primary" style="width: 250px; margin: 20px auto 0;">Login</a>
                                @endif
                            @else
                                <i style="font-size: 18px; text-align: center;">No active questionnaire found.</i>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="gamification-wrapper"
                         style="border: 1px solid #99aec1; height: 250px; background-color: white;">
                        <div class="gamification-title"
                             style="background-color: #ced8e1; color: black; font-weight: 600;
                             border-bottom: 1px solid #99aec1; text-align: center; padding: 10px;">
                            <p style="font-size: 16px; margin: 0;">Gamification</p>
                        </div>
                        <div class="gamification-content">
                            <p style="font-size: 14px !important; text-align: center; font-style: italic; padding-top: 80px;">
                                Gamification elements will be displayed here
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="questionnaire-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{$viewModel->questionnaire->title}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="questionnaire-display-section" data-content="{{$viewModel->questionnaire->questionnaire_json}}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>