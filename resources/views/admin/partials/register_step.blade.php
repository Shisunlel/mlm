<div class="row">
    <div class="col-lg-12 d-flex justify-content-center">
        <ul class="d-flex w-100" id="form-progress">
            <li class="{{ request()->segment(3) == 'create' ? 'bc-active' : 'bc-check' }}">@lang('message.step1')</li>
            <li class="{{ request()->segment(3) == 'create-step-2' ? 'bc-active' : '' }} {{ (request()->segment(3) == 'create-step-3' || request()->segment(3) == 'create-step-4' || request()->segment(3) == 'create-step-5') ? 'bc-check' : '' }}">@lang('message.step2')</li>
            <li class="{{ request()->segment(3) == 'create-step-3' ? 'bc-active' : '' }} {{ (request()->segment(3) == 'create-step-4' || request()->segment(3) == 'create-step-5' ? 'bc-check' : '' ) }}">@lang('message.step3')</li>
            <li class="{{ request()->segment(3) == 'create-step-4' ? 'bc-active' : '' }} {{ (request()->segment(3) == 'create-step-5' ? 'bc-check' : '') }}">@lang('message.step4')</li>
            <li class="{{ request()->segment(3) == 'create-step-5' ? 'bc-active' : '' }}">@lang('message.step5')</li>
        </ul>
    </div>
</div>