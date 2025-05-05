@extends('layouts.web')
@push('css')
    <title>Contact US - CelebInbox Reach Out for Inquiries, Collaborations, and Support</title>
    <meta name="description" content="Connect with CelebInbox through our contact us page. If you have inquiries, collaboration proposals, or need support, our team is here to assist you. Reach out to us for a seamless communication experience.">
    <meta name="keywords" content="Contact Us, CelebInbox inquiries, collaborations, support">
    <link rel="canonical" href="{{ route('contactUs') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('website/category.css') }}" />
    <style>
        .form-control{display:block;width:100%;padding:.375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#212529;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;-webkit-appearance:none;-moz-appearance:none;appearance:none;border-radius:.375rem;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out}label{border:0;padding:0;font-size:100%;font:inherit;vertical-align:baseline}form{margin:50px 0}form button{width:250px;background:#212529;color:#fff;border:0;padding:10px;margin-top:10px;border-radius:5px;cursor:pointer}
    </style>
@endpush

@section('content')

    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-9">
                <h1 class="mb-3">Contact Us</h1>
                <form method="post" action="{{ route('contactUsPost') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <strong>Email</strong>
                            <br>
                            <p style="margin: 10px 0 6px 0;">info@gadinsider.com</p>
                        </div>
                        <div class="col-md-12">
                            <label for="your-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="your-name" name="name" required="">
                        </div>

                        <div class="col-md-12">
                            <label for="your-email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="your-email" name="email" required="">
                        </div>
                        <div class="col-md-12">
                            <label for="your-subject" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="your-subject" name="subject">
                        </div>
                        <div class="col-12">
                            <label for="your-message" class="form-label">Your Message</label>
                            <textarea class="form-control" id="your-message" name="messageText" rows="5" required=""></textarea>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <button data-res="" type="submit" class="btn btn-dark w-100 fw-bold">Send</button>
                                </div>
                            </div>
                        </div>
                        @if(Session::has('success'))
                            <p class="mailAlert alert-info">{!! Session::get('success') !!}</p>
                        @endif

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
