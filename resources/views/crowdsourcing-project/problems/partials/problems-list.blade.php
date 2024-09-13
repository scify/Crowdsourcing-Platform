<ul>
    @foreach ($viewModel->crowdSourcingProjectProblems as $crowdSourcingProjectProblem)
        <li>
            <h3>{{ $crowdSourcingProjectProblem->currentTranslation->title}}</h3>
            <img src="{{ $crowdSourcingProjectProblem->img_url }}" alt="">
            <p>{{ $crowdSourcingProjectProblem->currentTranslation->description}}</p>
        </li>
    @endforeach
</ul>
