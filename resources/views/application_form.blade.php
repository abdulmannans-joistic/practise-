@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $campaign->campaign_name }} Application Form</h1>
    <form action="{{ route('application.submit', ['campaignId' => $campaign->id, 'userId' => $userId]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="applicant_name">Name:</label>
            <input type="text" class="form-control" name="applicant_name" required>
        </div>
        <div class="form-group">
            <label for="applicant_email">Email:</label>
            <input type="email" class="form-control" name="applicant_email" required>
        </div>
        <div class="form-group">
            <label for="applicant_resume_url">Resume URL:</label>
            <input type="url" class="form-control" name="applicant_resume_url">
        </div>

        @foreach ($questions as $question)
            <div class="form-group">
                <label>{{ $question->question_text }}</label>
                @foreach ($question->choices as $choice)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $choice->id }}" required>
                        <label class="form-check-label">
                            {{ $choice->choice_text }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>
@endsection
