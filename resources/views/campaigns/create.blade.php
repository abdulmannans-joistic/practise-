@extends('layouts.app')

@section('title', 'Create Campaign')

@section('content')
<div class="CampaignsPage ">
    <div class="container mt-4 d-flex justify-content-center align-items-center flex-column">
        <!-- Stepper Header -->
        <div class="center container mb-4" style="padding: 0 50px">
            <div class="step center flex-column">
                <span class="step-number stepActive" id="step1">1</span>
                <span class="step-title">Define Campaign</span>
            </div>
            <div class="center step-title">--------------------</div>
            <div class="step center flex-column">
                <span class="step-number" id="step2">2</span>
                <span class="step-title">Set Questions</span>
            </div>
            <div class="center step-title">--------------------</div>
            <div class="step center flex-column">
                <span class="step-number" id="step3">3</span>
                <span class="step-title">Invite Candidates</span>
            </div>
        </div>
        
        <!-- Content Containers -->
        <div class="card newProductFlowContainer mb-5" style="width: 1320px; padding: 0 30px;">
            <div class="card-body" style="width:100%">

                <!-- Define Campaign Content -->
                <div id="define-campaign-container">
                    @include('campaigns.partials.define_campaign')
                </div>

                <!-- Set Questions Content -->
                <div id="set-questions-container" style="display: none;">
                    @include('campaigns.partials.set_questions')
                </div>

                <!-- QR Code Content -->
                <div id="get-qr-code-container" style="display: none;">
                    @include('campaigns.partials.get_qr_code')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
