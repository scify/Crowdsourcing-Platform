{{--<div class="row" id="about">--}}
    {{--<div class="col-md-12 no-padding">--}}
        {{--<div class="content-container">--}}
            {{--{!! $viewModel->project->about !!}--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<section id="about">
    @include('home.partials.' . config('app.project_resources_dir') . '.about-us')
</section>
<section id="features">
    @include('home.partials.' . config('app.project_resources_dir') . '.features')
</section>
<section id="crowdsourcing">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <h2>What are we crowdsourcing?</h2>
            <div class="content-container" style="color: #666; line-height: 1.2;">
                <p style="margin-bottom: 20px">
                    How can Information and Communication Technology make <b>VET</b> more inclusive?
                    We are focusing on <b>7 thematic areas</b>:
                </p>
                <ol style="margin-bottom: 20px">
                    <li>Pedagogy & teaching / learning approaches</li>
                    <li>Technology & infrastructure</li>
                    <li>Establishing & maintaining links to employment / labour market</li>
                    <li>Stakeholder involvement, collaboration & partnerships</li>
                    <li>Leadership</li>
                    <li>Transition & target scenarios for VET organisations</li>
                    <li>Continuous improvement process</li>
                </ol>
                Our work is being published for a certain time on the crowdsourcing platform to collect further <b>ideas</b>,
                <b>comments</b> or <b>suggested</b> changes from a wider audience in Europe.
                So we are bringing practitioners’ views in, to combine them with <b>theory</b> and <b>research results</b>.
                At the end, we will <b>publicly share</b> the knowledge gained!

                <br>
                <br>

                The future is being created <b>now</b>. By us all.
                <b>Join</b> the discussion now and <b>invite</b> whom you value most to <b>contribute</b>, too.
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</section>
