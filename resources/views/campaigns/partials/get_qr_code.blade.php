<div class="container  row qr-code-section"  id="QrCode">
    <div class="headingCampaing d-flex justify-content-start align-items-center gap-3 mb-4">
        <i class="fa-solid fa-qrcode blue fs35"></i>
        <p class="primaryColor " style="font-size: 32px; font-weight: 600; margin-bottom: 0;" id="define-qr-heading">Get Your Qr Code</p>
    </div>

    <div class="center justify-content-around">
        <h3>Here is your generated QR code</h3>
        @if(isset($localQrCodeUrl))
            <img src="{{ $localQrCodeUrl }}" alt="QR Code">
        @endif
    </div>
        <!-- <input type="hidden" id="qrCodeData" value="{{ old('qr_code_data', $localQrCodeUrl ?? '') }}"> -->

    <div class="d-flex mt-5 justify-content-center ">
        <a class="btn btn-type-one p-3" href="{{ route('dashboard') }}">Go to Dashboard</a>
    </div>
</div>
