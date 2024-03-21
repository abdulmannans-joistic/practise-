<!-- <div class="card">
    <div class="card-header">
        Job Posts
        <input type="text" class="form-control w-auto d-inline-block ml-auto" placeholder="Search...">
    </div>
    <div class="card-body p-0">
        <table class="table table-responsive-md mb-0">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Job Title</th>
                    <th>Applied</th>
                    <th>Match Percentage</th>
                    <th>Other Matches</th>
                    <th>100% Matched</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobPosts as $campaign)
                <tr>
                    <td><input type="checkbox" name="selected[]" value="{{ isset($campaign['id']) ? $campaign['id'] : '' }}"></td>
                    <td>{{ $campaign['name'] ?? '' }}</td>
                    <td>{{ $campaign['applied'] ?? '' }}</td>
                    <td>
                        @if(isset($campaign['applied']) && isset($campaign['perfectMatches']))
                            {{ number_format($campaign['perfectMatches'] / max($campaign['applied'], 1) * 100, 2) }}%
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if(isset($campaign['applied']) && isset($campaign['perfectMatches']))
                            {{ $campaign['applied'] - $campaign['perfectMatches'] }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ isset($campaign['perfectMatches']) && $campaign['perfectMatches'] > 0 ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-clone"></i> Clone
                        </a>
                        <button onclick="confirm('Are you sure?') && deleteCampaign({{ isset($campaign['id']) ? $campaign['id'] : '' }})" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div> -->

<div class="container picassoCampaignListingHeader">
    <div class="col-md-12 vertical-middle no-padding-left  no-margin row">
        <div class="col-md-9 row">
            <div class="col-md-1 center" title="Select all campaigns to Delete/End">
                <div class="checkbox" onclick="toggleCheckbox(this)">
                    <i class="fa-solid fa-check"></i>
                </div>
            </div>
            <div class="col-md-3 no-padding " style="font-weight: 600">Campaign Title</div>
            <div class="col-md-3 text-center " style="font-weight: 600" >Applied</div>
            <!-- <div class="col-md-3 text-center " style="font-weight: 600" >Match Percentage</div>             -->
            <div class="col-md-2 text-center " style="font-weight: 600" >100% Matched</div>
            <div class="col-md-3 text-center " style="font-weight: 600" >Other Matches</div>
        </div>
        <div class="col-md-3 row" >
            
            <div class="col-10 center justify-content-end" style="padding-left: 20px;">
                <div id="Actiontext" style="padding-right: 75px; font-weight: 600" >
                    Action
                </div>
                <input type="text" name="" id="searchIN"  onkeyup="seacrhFilter()"  style="width: 100%; border-radius: 10px; display: none; margin-bottom: 0;  position: relative; left: 32px;">
            </div>
            <div class="col-1" style=" margin-left: 25px;">
            
                    <button class="search" onclick="myFunction()">
                        <a style="text-decoration: none; color: #fff;">
                        <i class="fa-solid fa-magnifying-glass" id="searchBTN"></i>
                        <i class="fa-solid fa-xmark close" id="cancelBtn" style="display: none;"></i>
                        </a>
                    </button>
            </div>
            
        </div>
    </div>
</div>

<div class="container no-padding" style="margin-bottom: 50px;" id="myTable">
    @foreach ($jobPosts as $campaign)
        <div class="picassoCampaignsListingPage" id="picassoCampaignsListingPage">
            <div class="container picassoCampaignListingContainer myJobPostDetails" id="campaignListContainer">
                <div class="col-md-12 vertical-middle no-padding-left campaignListingInfo" id="containerJobDiv_{{ $campaign['id'] }}">
                    <div class="col-md-9 vertical-middle">
                        <div class="col-md-1 center align-self-start mt-2" title="Select to Delete/End multiple campaigns">
                            <div class="checkbox" onclick="toggleCheckbox(this)">
                                <i class="fa-solid fa-check"></i>
                            </div>
                        </div>

                        <div class="col-md-3 no-padding align-self-start">
                            <div>
                                <a href="" class="CmpTitle orange fs21 fw-500" title="{{ $campaign['name'] }}">
                                    {{ $campaign['name'] }}
                                </a>
                            </div>

                            <div class="fs12">
                                <div class="p999 blue mt5">Verification Process <span id="jmode_container_39810">
                                        <span class=""></span> </span>
                                </div>
                            </div>
                            <div class="p999 fs12 mt5 fw-500 ">{{ $campaign['date'] ?? 'N/A' }} | {{ $campaign['time'] ?? 'N/A' }}</div>
                        </div>

                        <div class="col-md-3 no-padding vertical-middle justify-center">
                            <span class="picassoInterested orange fs35 fw-700 " style="padding-right: 13px; padding-left: 30px;">
                                {{ $campaign['applied'] ?? '0' }}
                            </span>
                        </div>
                        <div class="col-md-3 center">
                            <span class="picassoInterested primaryColor fs35 fw-500 " style="padding-right: 13px; padding-left: 30px;">
                            {{ $campaign['perfectMatches'] }}
                            </span>
                        </div>
                        <div class="col-md-2 center flex-column list-inline " style="padding-right: 13px; padding-left: 30px;" >
                                <li class=" fs12 fw-500  center gap-2 ">75%   <span class="primaryColor">{{ $campaign['seventyFiveMatches'] }}</span></li>
                                <li class=" fs12 fw-500  center gap-2 ">50%   <span class="primaryColor">{{ $campaign['fiftyMatches'] }}</span></li>
                                <li class=" fs12 fw-500  center gap-2 ">30%   <span class="primaryColor">{{ $campaign['thirtyMatches'] }}</span></li>
                            </div>
                    </div>
                    <div class="col-md-3 center justify-content-start fs22 gap-4" style="padding-left: 120px;">
                        <input type="hidden" id="jmode_0" value="on">

                        <div class="icon-col">
                            <div class="picassoTooltip">
                                <a href="#" id="dashjd_{{ $campaign['id'] }}" rel="{{ $campaign['id'] }}">
                                    <img src="img/Group 224.png" alt="jd-preview">
                                </a>
                            </div>
                        </div>

                        <div class="icon-col">
                            <div class="picassoTooltip">
                                <a href="#" id="endjob_{{ $campaign['id'] }}" class="popupLink iopp endjob accessCtrlnk" onclick="confirm('Are you sure?') && deleteCampaign({{ $campaign['id'] }})">
                                    <img src="img/ic_baseline-delete.png" alt="close-campaign">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <ul id="pagination" class="mt-4">
        <li><a class="" href="#">«</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#" class="active">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">6</a></li>
        <li><a href="#">7</a></li>
        <li><a href="#">»</a></li>
    </ul>
</div>





@section('scripts')
<script>
    function deleteCampaign(id) {
        // Add your delete logic here
    }
</script>
@endsection
