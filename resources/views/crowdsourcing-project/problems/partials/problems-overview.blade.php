<div class="container px-sm-0">

    <div class="row">
        <div class="col-12 my-4 my-lg-5 pt-4">
            <x-go-back-link href="{{ url()->previous() }}" class="d-none d-lg-block">Back</x-go-back-link> <!-- bookmark - href to project landing page - needs i18n -->
        </div>
    </div>

    <div class="row">

        <div class="col-12 col-lg-7">
            <!-- <h1 class="text">The topic: {{ $viewModel->project->currentTranslation->name }}</h1> --> <!-- bookmark - needs i18n -->
            <h1 class="project-title">The topic: Air quality in Europe</h1>
            <div class="project-overview pb-5 pb-lg-0">
                <!-- {!! $viewModel->project->currentTranslation->about !!} --> <!-- bookmark - 'about' field here or something else from DB? HTML or text? -->
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas pulvinar mi quis erat commodo rhoncus. Etiam at sapien leo. Vivamus non placerat mi, placerat consectetur ante. Pellentesque egestas mi sit amet leo feugiat bibendum. Donec ut placerat mauris. Donec dapibus varius venenatis. Cras congue est in gravida lobortis.</p>
                <p>Nunc at nisl eget ante sollicitudin elementum at quis magna. Nullam semper scelerisque lacus ut condimentum. Sed non finibus lacus. Fusce nec ornare turpis. Praesent ut sem sed metus semper auctor. Aenean in dui nec libero tempus convallis. Aenean rutrum felis laoreet dolor semper, commodo laoreet risus ultrices. Maecenas non urna hendrerit, faucibus arcu sed, commodo nulla. Phasellus eu tempor dui, ut sodales eros. Aliquam velit libero, malesuada eget laoreet ut, lobortis non sapien. Cras ex nulla, blandit nec luctus non, euismod at ipsum. Maecenas venenatis congue massa. Sed a odio quis mi scelerisque ornare eu sed libero. Sed malesuada diam nisl, ut maximus ligula tristique et. Sed vestibulum id felis ut blandit. Mauris mollis lectus lorem, vulputate tempor est egestas vel.</p>
            </div>
        </div>

        <div class="col-12 col-lg-4 offset-lg-1 align-self-end text-center">
            <img src="/images/problems/problem-page-main.png" alt="" width="384" height="416" class="img-fluid"> <!-- default image should be in public folder! -->
        </div>

    </div>

</div>
