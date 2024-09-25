<div class="container px-sm-0">

    <div class="row">
        <div class="col-12">
            <h2
                style="
                    font-weight: bold;
                    margin-top: 7.5rem;
                    margin-bottom:2rem;
                "
            >List of Problems</h2> <!-- bookmark - make i18n-able -->
        </div>
    </div>

    <div class="row justify-content-center" >
        <div class="col-12 col-md-10 col-lg-11 col-xl-9">
            <ul class="row">

{{--
        @foreach ($viewModel->crowdSourcingProjectProblems as $crowdSourcingProjectProblem)
            <li class="col-3">
                <div class="card">
                    <img class="card-img-top" src="{{ $crowdSourcingProjectProblem->img_url }}" alt="Card image cap">
                    <div class="card-body">
                        <h5
                            class="card-title"
                            style="font-weight: 600;"
                        >
                            {{ $crowdSourcingProjectProblem->currentTranslation->title }}
                        </h5>
                        <p
                            class="card-text"
                            style="font-size: 1.21rem;"
                        >
                            {{ $crowdSourcingProjectProblem->currentTranslation->description }}
                        </p>
                    </div>
                </div>
            </li>
        @endforeach
--}}

        @php
            for ($i=0 ; $i < 6 ; $i++):
        @endphp
            <li class="col-12 col-sm-6 col-md-6 col-lg-4">
                <a class="card-link" href="#">
                    <div class="card" style="border-radius: 1rem; margin-bottom: 2rem; overflow: clip;">
                        @php
                            if (($i%2) === 0):
                        @endphp
                            <div style="background-color: var(--secondary-grey); padding-top: 4.3rem; padding-bottom: 2.2rem;">
                                <img class="card-img-top" src="/images/problems/problem-card-default.svg" alt="Card image cap" width="141" height="90">
                            </div>
                        @php
                            endif;
                            if ($i === 1):
                        @endphp
                            <div style="background-color: var(--secondary-grey);height: 180px;">
                                <img class="card-img-top" src="/storage/uploads/project_problem_img/panda_tall.jpg" alt="Card image cap" width="282" height="180" style="width: 100%;object-fit:cover;">
                            </div>
                        @php
                            endif;
                            if ($i === 3):
                        @endphp
                            <div style="background-color: var(--secondary-grey);height: 180px;">
                                <img class="card-img-top" src="/storage/uploads/project_problem_img/panda_wide.jpg" alt="Card image cap" width="282" height="180" style="width: 100%;object-fit:cover;">
                            </div>
                        @php
                            endif;
                            if ($i === 5):
                        @endphp
                            <div style="background-color: var(--secondary-grey);height: 180px;">
                                <img class="card-img-top" src="/storage/uploads/project_problem_img/panda_square.jpg" alt="Card image cap" width="282" height="180" style="width: 100%;object-fit:cover;">
                            </div>
                        @php
                            endif;
                        @endphp
                        <div class="card-body">
                            <h5 class="card-title">
                                Solutions for health Issues
                            </h5>
                            <p class="card-text mb-4">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas pulvinar mi quis erat commodo rhoncus.
                            </p>
                        </div>
                    </div>
                </a>
                <x-share-circle-btn />
            </li>
        @php
            endfor;
        @endphp

            </ul>
        </div>
    </div>
    <div class="row pb-5">
        <div class="col-12 d-flex justify-content-center">
            <button class="cta-btn">See all problems</button> <!-- bookmark - add click handler - make i18n-able -->
        </div>
    </div>

</div>
