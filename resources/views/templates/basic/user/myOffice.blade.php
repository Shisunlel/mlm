@extends($activeTemplate.'layouts.master')
@push('style')
    <style>
        .container {
            border: none;
        }

        .line {
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            height: 80%;
            display: inherit;
            border: 2px dotted #bbb;
            border-bottom: none;
            position: relative;
        }

        .line::before,
        .line::after {
            position: absolute;
            font-family: "Line Awesome Free";
            font-weight: 600;
            font-size: 24px;
            color: #bbb;
            bottom: -1em;
            width: 30%;
            text-align: center;
            background: #fff;
            z-index: 1;
            line-height: 20px;
            height: 20%;
            padding: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #@php echo $general->base_color; @endphp;
            color: #@php echo $general->base_color; @endphp;
            box-shadow: #@php echo $general->base_color; @endphp 4px 4px 0px 0px;
        }

        .line::before {
            content: attr(data-left);
            left: -15%;
        }

        .line::after {
            content: attr(data-right);
            right: -15%;
        }

        .grid {
            display: grid;
            font-size: 1rem;
            row-gap: 2rem;
            column-gap: 5rem;
            padding: 0 2em;
            grid-template-columns: minmax(100px, 15ch) repeat(3, 1fr);
            grid-template-rows: repeat(5, 1fr);
        }

        .user-id {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            grid-row: 1 / 6;
            grid-column: 1 / 2;
        }

        .total-pv {
            text-align: center;
            grid-row: 1 / 2;
            grid-column: 2 / 4;
        }

        .my-tree {
            position: relative;
            grid-row: 2 / 6;
            grid-column: 2 / 4;
            min-height: 120px;
        }

        .cta {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: inherit;
            gap: 1em;
            grid-row: 1 / 6;
            grid-column: 4 / 5;
        }

        .cta a {
            flex: 1 1 auto;
            text-align: center;
        }
        
        .btn-shadow-drop--blue {
            border: 1px solid #@php echo $general->base_color; @endphp;
            color: #@php echo $general->base_color; @endphp;
            box-shadow: #@php echo $general->base_color; @endphp 4px 4px 0px 0px;
        }

        .btn:focus{
            box-shadow: #@php echo $general->base_color; @endphp 4px 4px 0px 0px;
        }

        .my-tree>span:not(span:nth-child(1)) {
            position: absolute;
            bottom: 0;
        }

        .my-tree>span:nth-child(2) {
            left: 9.5%;
        }

        .my-tree>span:nth-child(3) {
            right: 9.5%;
        }

        @media only screen and (max-width: 1150px) {
            .grid {
                grid-template-columns: minmax(100px, 15ch) repeat(3, 1fr);
                grid-template-rows: repeat(3, 1fr);
            }
            .user-id {
                grid-row: 1 / 2;
                grid-column: 1 / 3;
            }

            .total-pv {
                grid-row: 1 / 2;
                grid-column: 3 / 5;
            }

            .my-tree {
                grid-row: 2 / 3;
                grid-column: 1 / 5;
            }

            .cta {
                flex-direction: row;
                align-items: center;
                grid-row: 3 / 4;
                grid-column: 1 / 5;
            }

            .cta a {
                flex: 1 1 100%;
            }
        }

        @media only screen and (max-width: 830px){
            .cta{
                flex-direction: column;
                align-items: inherit;
            }
        }

    </style>
@endpush
@section('content')
    <div class="padding-top padding-bottom">
        <div class="container-fluid">
            <div class="grid">
                <section class="user-id">
                    <h3>{{ auth()->user()->id }}</h3>
                    <p>{{ __('form.position') . ' :' . __(auth()->user()->plan->name) }}</p>
                </section>
                <section class="total-pv">
                    <h4>@lang('frontend.total_pv') <a href="{{ route('user.my_pv', ['type' => 'add pv']) }}"><span class="text-danger">{{ number_format(auth()->user()->balance, 0) }}</span></a> PV
                    </h4>
                </section>
                <section class="my-tree">
                    <span class="line" 
                          data-left="@php echo getAmount(getChildPV(auth()->user()->id, 1, 1),0) . ' PV'; @endphp"
                          data-right="@php echo getAmount(getChildPV(auth()->user()->id, 2, 1),0) . ' PV'; @endphp"
                    ></span>

                </section>
                <section class="cta">
                    <a href="{{ route('user.my_pv', ['type' => 'subtract pv']) }}"><button class="btn btn-shadow-drop btn-shadow-drop--blue p-2"><img class="img-fluid cta-icon" src="{{ asset('assets/images/spending.png') }}" alt="spending icon"><span>@lang('frontend.spending')</span></button></a>
                    <a href="{{ route('user.my_commission') }}"><button class="btn btn-shadow-drop btn-shadow-drop--blue p-2"><img class="img-fluid cta-icon" src="{{ asset('assets/images/hand.png') }}" alt="payment icon"><span>@lang('frontend.commission')</span></button></a>
                    <a href="{{ route('user.general_commission') }}"><button class="btn btn-shadow-drop btn-shadow-drop--blue p-2"><img class="img-fluid cta-icon" src="{{ asset('assets/images/commission.png') }}" alt="commission icon"><span>@lang('frontend.g_commission')</span></button></a>
                    <a href="{{ route('user.my.tree') }}" target="_blank" title="Icons made by Freepik from www.flaticon.com"><button class="btn btn-shadow-drop btn-shadow-drop--blue p-2"><img class="img-fluid cta-icon" src="{{ asset('assets/images/management.png') }}" alt="lineage icon"><span>@lang('frontend.tree')</span></button></a>
                </section>
            </div>
        </div>
    </div>
@endsection