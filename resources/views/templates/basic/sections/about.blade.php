@php
    $aboutCaption = getContent('about.content',true);
@endphp
@if($aboutCaption)
    <section class="about-section padding-top padding-bottom">
        <div class="container">
            <div class="row mb--50">
                <div class="col-lg-12 pr-xl-5 mb-50">
                    <div class="video-wrapper w-100 h-100 bg_img"
                         data-background="{{ getImage('assets/images/frontend/about/'.@$aboutCaption->data_values->background_image, '700x567') }}">
                    </div>
                </div>
                <div class="col-lg-12 mb-50">
                    <div class="about-content">
                        <div class="section-header left-style margin-olpo">
                            <h2 class="title">{{ __(@$aboutCaption->data_values->heading) }}</h2>
                        </div>
                        <p>@php echo @$aboutCaption->data_values->description; @endphp</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif
