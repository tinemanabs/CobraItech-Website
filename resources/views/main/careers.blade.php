@extends('layouts.app')

@section('title', 'Careers')
@section('content')


    <!-- ======= Careers Section ======= -->
    <section id="careers" class="careers">
        <div class="container divider-caption mb-5">

            <h4>Careers</h4>
            <h1>Join our Team</h1>
            <p>Be the architects of our success. Join us and let’s make an impact together.
            </p>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-md-2">
                    <div class="card shadow-sm bg-body rounded border-0">
                        <div class="card-body">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <form action="{{ route('send.career') }}" method="post" role="form" class="php-email-form"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <p style="font-weight: bold">Name</p>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Your Name">
                                    </div>
                                    <div class="col-md-6 form-group mt-3 mt-md-0">
                                        <p style="font-weight: bold">Email</p>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Your Email">
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <p style="font-weight: bold">Job Category</p>
                                    <select class="form-select" name="job" id="job">
                                        <option selected disabled value="">Select Job Category</option>
                                        <option value="Consultant">Consultant</option>
                                        <option value="Data Scientist">Data Scientist</option>
                                        <option value="Designer">Designer</option>
                                        <option value="Developer">Developer</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <p style="font-weight: bold">Cover Letter</p>
                                    <textarea class="form-control" name="cover" id="cover" rows="3" placeholder="Message"></textarea>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="formFile" class="form-label" style="font-weight: bold">Resume/CV</label>
                                    <input class="form-control" type="file" name="cv" id="fileCV"
                                        onchange="fileValidation()">
                                </div>
                                <div><br></div>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <button class="btn text-white" style="background-color: #12519E;"
                                        id="career-btn">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section><!-- End Careers Section -->


@endsection
