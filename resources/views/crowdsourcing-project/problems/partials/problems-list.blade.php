<div class="container">

    <div class="row w-100 align-items-center mx-0">
        <div class="col-md-12 p-0">
            <h2
                style="
                    color: {{ $viewModel->project->lp_primary_color }};
                    font-weight: bold;
                    margin-top: 6rem;
                    margin-bottom: 5rem;
                "
            >Problems</h2> <!-- bookmark - text must be dynamic-translatable! -->
        </div>
    </div>

    <ul
        class="row"
        style="margin-bottom: 5rem;"
    >

        @foreach ($viewModel->crowdSourcingProjectProblems as $crowdSourcingProjectProblem)
            <li class="col-4">
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
                        <a
                            href="#" 
                            class="btn btn-primary text-center w-100"
                            style="font-size: 1.21rem; margin-top: 1rem;"
                        >
                            Details
                        </a> <!-- bookmark - text must be dynamic-translatable! -->
                    </div>
                </div>
            </li>
        @endforeach

    </ul>

</div>
