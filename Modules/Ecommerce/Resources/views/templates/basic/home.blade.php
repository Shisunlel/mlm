@extends('ecommerce::'. $activeTemplate.'layouts.master')
@section('content')

    <div class="main-sections oh">

        {{-- Left Category Menu --}}
        @include('ecommerce::'.$activeTemplate.'sections.left_category_menu')

        <div class="all-sections">
            @include('ecommerce::'.$activeTemplate.'sections.sliders')

            @include('ecommerce::'.$activeTemplate.'sections.special_categories', ['special_categories' => $special_categories])
            @include('ecommerce::'.$activeTemplate.'sections.banners_top')
        </div>
        @include('ecommerce::'.$activeTemplate.'sections.right_category', ['products' => $special_products])
    </div>

    @include('ecommerce::'.$activeTemplate.'sections.offers')
    @include('ecommerce::'.$activeTemplate.'sections.banners_middle')

    @if($featured_products->count()>0)
        @include('ecommerce::'.$activeTemplate.'sections.featured_products', ['featured_products'=> $featured_products])
    @endif
    @php
        $f_categories = $categories->where('in_filter_menu');
    @endphp

    @if($f_categories->count()> 0)
        @include('ecommerce::'.$activeTemplate.'sections.filter_categories', ['f_categories'=> $f_categories])
    @endif

    @if($top_selling_products->count() > 0)
    @include('ecommerce::'.$activeTemplate.'sections.top_selling_products', ['products'=> $top_selling_products])
    @endif
    @include('ecommerce::'.$activeTemplate.'sections.top_categories_brands', ['top_categories'=> $top_categories, 'top_brands' => $top_brands])

@endsection

@push('meta-tags')
    @include('partials.seo')
@endpush
