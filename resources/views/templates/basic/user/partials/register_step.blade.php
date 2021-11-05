<div class="row">
    <div class="col-lg-12 d-flex justify-content-center">
        <ul class="d-flex w-100" id="form-progress">
            <li class="{{ request()->segment(1) == 'register' ? 'bc-active' : 'bc-check' }}">First Step</li>
            <li class="{{ request()->segment(1) == 'registerStep2' ? 'bc-active' : '' }} {{ (request()->segment(1) == 'registerStep3' || request()->segment(1) == 'registerStep4' || request()->segment(1) == 'registerStep5') ? 'bc-check' : '' }}">Second Step</li>
            <li class="{{ request()->segment(1) == 'registerStep3' ? 'bc-active' : '' }} {{ (request()->segment(1) == 'registerStep4' || request()->segment(1) == 'registerStep5' ? 'bc-check' : '' ) }}">Third Step</li>
            <li class="{{ request()->segment(1) == 'registerStep4' ? 'bc-active' : '' }} {{ (request()->segment(1) == 'registerStep5' ? 'bc-check' : '') }}">Fourth Step</li>
            <li class="{{ request()->segment(1) == 'registerStep5' ? 'bc-active' : '' }}">Fifth Step</li>
        </ul>
    </div>
</div>