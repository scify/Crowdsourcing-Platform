<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h2>What are we crowdsourcing?</h2>
        <div class="content-container">
            <p style="margin-bottom: 20px">
                EICON has chosen a participatory approach to involve a wider audience in the creation of results:
            </p>
                <ol style="margin-bottom: 20px">
                    <li>Partners develop draft results</li>
                    <li>You can comment, revise, add points relevant from your point of view</li>
                    <li>EICON consolidates the results</li>
                    <li>Results are published at the website</li>
                </ol>
                For each of the seven topics that the project will focus upon, this procedure will be applied.<br>
                So there will be plenty of opportunities for you to contribute and shape the results such that they fit better your every
                day needs and requirements.

            <div class="projects-container row">
                <div class="col-md-5 col-sm-6 col-xs-12 col-sm-offset-0 col-md-offset-0" style="float: none; margin: 0 auto;">
                    <div class="project-wrapper">
                        <div class="project-logo">
                            <img src="{{ $defaultProject->logo_path }}" alt="">
                        </div>
                        <div class="project-info">
                            {!! $defaultProject->about !!}
                        </div>
                        <div class="project-visit-btn">
                            <a href="/{{ $defaultProject->slug }}" class="btn btn-block btn-primary">Contribute</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>