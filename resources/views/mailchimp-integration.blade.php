@extends('loggedin-environment.layout')

@section('content-header')
    <h1>MailChimp Integration</h1>
@stop

@push('css')

@endpush

@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Instructions</h3>
                </div>
                <div class="box-body">
                    First, login to your MailChimp account <a href="https://login.mailchimp.com/" target="_blank">here</a>.
                    Then, find your <b>Lists' IDs</b> by following the instructions provided by MailChimp
                    <a href="https://mailchimp.com/help/find-your-list-id/" target="_blank">here</a>.
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Integration Form</h3>
                </div>
                <form action="{{route('mailchimp-integration')}}" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="box-body">
                        <p>Please provide the following MailChimp lists IDs (see instructions above).</p>
                        {{--<div class="form-group">--}}
                            {{--<label for="newsletter">Newsletter <a href="javascript:void(0)" data-widget="tooltip"--}}
                                                                  {{--title="All mails subscribed to our newsletter via the landing pages will be added to this list"><span--}}
                                            {{--class="fa fa-info-circle"></span></a></label>--}}
                            {{--<input type="text" id="newsletter" class="form-control" name="newsletter"--}}
                                   {{--placeholder="Insert the Newsletter's list ID"--}}
                                   {{--value="{{isset($viewModel) && isset($viewModel->newsletterList) ? $viewModel->newsletterList->list_id : ''}}">--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label for="registered-users">Newsletter for registered users <a href="javascript:void(0)"
                                                                              data-widget="tooltip"
                                                                              title="All the registered users to the platform will be added to this list"><span
                                            class="fa fa-info-circle"></span></a></label>
                            <input type="text" id="registered-users" class="form-control" name="registered_users"
                                   placeholder="Insert the Registered Users' list ID"
                                   value="{{isset($viewModel) && isset($viewModel->registeredUsersList) ? $viewModel->registeredUsersList->list_id : ''}}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4 col-xs-12">
                                <button type="submit" class="btn btn-block btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('scripts')

@endpush
