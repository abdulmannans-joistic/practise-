<div class="container DashboardTop ">
    <div class="col-md-12 vertical-middle row">
        <div class="col-md-6">
            Welcome, , {{ Auth::user()->name }}
            <div class="fs28 orange " style="font-weight: 500;">Dashboard</div>
        </div>
        <div class="col-md-6 row center">
            <div class="col-md-6 text-right"></div>
            <div class="col-md-6 text-right">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('campaigns.create') }}" class="btn btn-type-one"><i class="fa-solid fa-plus"> </i> &nbsp Source New </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container p-0 d-flex justify-content-between ">
    <div class="col-md-3 m-2 ">
        <div class="picassoDashboardStatsCol vertical-middle">
        <span class="dashboardStatsIcon"><img src="img/Group 288.png"></span>
            <span class="fw-500">
                Total Job Posts<br>
                <span class="orange fs35">{{ $metrics['totalJobPosts'] }}</span>
            </span>
        </div>
    </div>
    <div class="col-md-3 m-2">
        <div class="picassoDashboardStatsCol vertical-middle">
        <span class="dashboardStatsIcon"><img src="img/Group 287.png"></span>
            <span class="fw-500">
                Total Applied<br>
                <span class="orange fs35">{{ $metrics['totalApplied'] }}</span>
            </span>
        </div>
    </div>
    <div class="col-md-3 m-2">
        <div class="picassoDashboardStatsCol vertical-middle">
        <span class="dashboardStatsIcon"><img src="img/Group 286.png"></span>
            <span class="fw-500">
                Total Matches<br>
                <span class="orange fs35">{{ $metrics['totalMatches'] }}</span>
            </span>
        </div>
    </div>
</div>