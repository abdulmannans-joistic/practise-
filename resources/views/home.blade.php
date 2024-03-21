@extends('layouts.layout')

@section('title', 'Callify Home')

@section('content')
<main id="main">
    <!-- Hero section -->
    <section id="hero_section">
      <div class="container">
        <div class="row" data-aos="fade-up">
          <div class="col-12 col-lg-6">
            <div>
              <h1 class="text-white jumbo-font">Power of <br />Recruiter’s Voice</h1>
              <p class="sm-font text-white">
                <span class="d-block">Candidates resonate deeply when they hear a recruiter's voice.</span> At Callify, our foundational belief in Talent Acquisition automation revolves around infusing a human touch, ensuring personalization even at scale. It's not just technology; it's a human connection amplified.
              </p>

              <div class="btn-wrapper d-flex gap-2 gap-md-4">
                <a class="btn btn-type-two" data-bs-toggle="modal" data-bs-target="#exampleModal">Demo?</a>
                <a href="about-us#" class="btn btn-outline-one">Know more</a>
              </div>
            </div>
          </div>

          <div class="col-12 col-lg-6">
              <div class=" center gap-2 align-items-end">
                <img src="img/Layer_1 (4).png" alt="">
                <img src="img/Isolation_Mode.png" alt="">

            </div>
          </div>
        </div>
      </div>
    </section>

  

    <!-- TATech Section -->
    <section>
      <div class="container">
        <div class="row pd-bottom-md mt-5">
          <div class="col-12">
            <div class="ta-tech-wrapper d-flex align-items-center">
              <div class="tt-img" data-aos="fade-up">
                <img src="img/Group 551.png" alt="ta-tech-01" class="img-fluid" />
              </div>
              <div class="tt-content">
                <h3>Define Campaign </h3>
                <p>
                  Easily define your campaign with uploaded JD to find candidates fitting your parameters 
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="row pd-bottom-md">
          <div class="col-12">
            <div class="ta-tech-wrapper d-flex flex-md-row-reverse align-items-center">
              <div class="tt-img" data-aos="fade-up">
                <img src="img/Group 63.png" alt="ta-tech-02" class="img-fluid" />
              </div>
              <div class="tt-content">
                <h3>Set MCQ questions</h3>
                <p>
                  Set MCQ based questions with your correct answers to filter out candidates for your job role
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="row pd-bottom-md">
          <div class="col-12">
            <div class="ta-tech-wrapper d-flex align-items-center">
              <div class="tt-img" data-aos="fade-up">
                <img src="img/Group 61.png" alt="ta-tech-03" class="img-fluid" />
              </div>
              <div class="tt-content">
                <h3>Generate QR</h3>
                <p>
                  Invite candidates easily through a Generated QR with a link provided to easily copy and share
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

 

  </main>


@endsection

@section('additional-js')
    <!-- If you have specific JS for home page, include here -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest"></script>
    <!-- More scripts as needed -->
@endsection
