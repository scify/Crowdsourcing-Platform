<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>What are we crowdsourcing?</h2>
            <div class="content-container">
                <p>The <b><i>"Together"</i></b> crowdsourcing platform hosts various projects. Please check below those
                    that are the currently active and waiting for your contribution.
                    Please visit a project's page and make an impact by answering just a couple of questions!</p>
                @include('home.partials.projects-list-home')
            </div>
        </div>
    </div>
</div>
@if(isset($pastProjects))
    <section id="past-projects">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-6 col-xs-12 mx-auto text-center">
                    <h2>Check out our past projects:</h2>
                </div>
            </div>
            <div class="row">
                @include('home.partials.projects-list-home', ['projects' => $pastProjects, 'projectBtnText' => 'See more'])
            </div>
        </div>
    </section>
@endif
