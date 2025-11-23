@extends('layouts.app')

@section('title', 'Transactions History')

@section('content')
<div class="container-xxl">
    <div class="row vh-100 d-flex justify-content-center">
        <div class="col-12 align-self-center">
            <div class="card-body">
                <div class="row">
                    <div class="text-center">
                        <!-- FULL IMAGE -->
                        <img src="rentus/assets/images/success.webp"
                            alt="Thank You"
                            class="img-fluid mb-4"
                            style="max-width: 420px;">

                        <!-- TITLE -->
                        <h2 class="fw-bold text-dark mb-2">Thank You!</h2>

                        <!-- DESCRIPTION -->
                        <p class="text-muted fs-15 mb-4">
                            Your request has been successfully submitted.
                        </p>

                        <!-- BUTTON -->
                        <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 py-2">
                            Go to Dashboard
                        </a>
                    </div>
                </div><!--end row-->
            </div><!--end card-body-->
        </div><!--end col-->
    </div><!--end row-->
</div><!-- container -->

@endsection