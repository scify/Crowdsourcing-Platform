<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <h4>FILTERS</h4>
        </div>
    </div><!--.panel-heading-->
    <div class="panel-body filtersContainer noInputStyles" id="mentorsFilters" data-url="{{ route('filterUsers') }}">
        <div class="row">
            <div class="col-md-2 filterName">Name</div><!--.col-md-3-->
            <div class="col-md-6">
                <div class="inputer">
                    <div class="input-wrapper">
                        <input name="mentorName" class="form-control" placeholder="Mentor name" type="text" id="mentorName">
                    </div>
                </div>
            </div><!--.col-md-6-->
        </div>
        <div class="form-buttons">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button id="searchBtn" class="searchBtn btn btn-primary btn-ripple margin-right-10">
                        Search <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="errorMsg" class="alert alert-danger stickyAlert margin-top-20 margin-bottom-20 margin-left-100 hidden" role="alert"></div>
