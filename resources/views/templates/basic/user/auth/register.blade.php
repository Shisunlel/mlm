@extends($activeTemplate.'layouts.master')
@section('content')
    @include($activeTemplate.'layouts.breadcrumb')

    <section class="account-section padding-bottom padding-top">
        <div class="container">
            @include($activeTemplate.'user.partials.register_step')
            <div class="row mt-5 d-flex justify-content-center">
                <div class="col-3">
                    <div class="card mb-3" style="max-width: 18rem;">
                        <div class="card-header">ការចុះឈ្មោះជាសមាជិកខ្មែរ</div>
                        <div class="card-body">
                            <a href="{{ route('user.register.step2', ['lang' => 'kh']) }}"
                                class="btn btn-primary card-text">ការចូលជាសមាជិក</a>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card mb-3" style="max-width: 18rem;">
                        <div class="card-header">Foreign resident in Cambodia</div>
                        <div class="card-body">
                            <a href="{{ route('user.register.step2', ['lang' => 'en']) }}"
                                class="btn btn-primary card-text">Join</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
