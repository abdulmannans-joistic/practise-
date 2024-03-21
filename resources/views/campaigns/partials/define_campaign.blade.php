<div class="container" id="defineCampaign">
    <div class="row">
        <div class="col-12">
            <div class="headingCampaing center gap-3 ">
                <h2 class="mt-2">Define Your Campaign</h2>
            </div>
        </div>
        <form action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data" id="campaign-form" class="form-content">
            @csrf
            <div class="row">
                <!-- Left column for Campaign Name and Salary -->
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="CampaignTitle" class="form-label">Campaign Name</label>
                        <input type="text" class="form-control" id="CampaignTitle" name="campaign_name" placeholder="Campaign Title - this will be viewed by the Candidate">
                    </div>
                    <div class="mb-3">
                        <label for="minbillingrate" class="form-label">Salary upto (per annum)</label>
                        <select name="campaign_pref_salary" id="minbillingrate" class="form-control">
                            <option value="">Salary upto (per annum)</option>
                            <option value="income_efforts">Income based on your own efforts</option>
                            <option value="industry_standard">As per Industry Standards</option>
                            <option value="negotiable">Negotiable</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="webUrl" class="form-label">Website link, Assessment link, Recent blogs, News link</label>
                        <input type="url" class="form-control" id="webUrl" name="campaign_document_url" placeholder="http://www.yourWebUrl.com">
                    </div>
                </div>

                <!-- Right column for Experience and Job Location -->
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="totalExpMin" class="form-label">Experience upto</label>
                        <select name="campaign_experience_req" id="totalExpMin" class="form-control">
                            <option value="">Experience up to (years)</option>
                            <option value="any">Any Experience</option>
                            <option value="fresher">Freshers can also apply</option>
                            <option value="fresher_not">Freshers need not apply</option>
                            <option value="six_months">6 months experience can apply</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jobLocation_0" class="form-label">Job location</label>
                        <input type="text" class="form-control" id="jobLocation_0" name="campaign_location" placeholder="Job Location - e.g., Bangalore">
                    </div>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-type-one">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
