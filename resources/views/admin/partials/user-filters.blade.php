<div class="panel">
        <div class="panel-body filtersContainer noInputStyles" id="usersFilters" data-url="{{ route('filterUsers') }}">
        <div class="row">
            <div class="col-md-4">
                <div class="inputer">
                    <div class="input-wrapper">
                        <input name="email" class="form-control" placeholder="email" type="email" id="userEmail">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <button id="searchBtn" class="searchBtn btn btn-primary btn-ripple mr-1">
                    Search <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="errorMsg" class="alert alert-danger stickyAlert margin-top-20 margin-bottom-20 margin-left-100 hidden" role="alert"></div>
