<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <h4>FILTERS</h4>
        </div>
    </div>
    <div class="panel-body filtersContainer noInputStyles" id="usersFilters" data-url="{{ route('filterUsers') }}">
        <div class="row">
            <div class="col-md-1 filterName">Email</div><!--.col-md-3-->
            <div class="col-md-4">
                <div class="inputer">
                    <div class="input-wrapper">
                        <input name="email" class="form-control" placeholder="User name" type="email" id="userEmail">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 form-buttons margin-top">
                <button id="searchBtn" class="searchBtn btn btn-primary btn-ripple margin-right-10">
                    Search <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="errorMsg" class="alert alert-danger stickyAlert margin-top-20 margin-bottom-20 margin-left-100 hidden" role="alert"></div>
