<div class="row">
    <div class="col-lg-12 d-flex justify-content-center">
        <ul class="d-flex w-100" id="form-progress">
            <li class="{{ request()->segment(3) == 'create' ? 'bc-active' : 'bc-check' }}">First Step</li>
            <li class="{{ request()->segment(3) == 'createStep2' ? 'bc-active' : '' }} {{ (request()->segment(3) == 'createStep3' || request()->segment(3) == 'createStep4' || request()->segment(3) == 'createStep5') ? 'bc-check' : '' }}">Second Step</li>
            <li class="{{ request()->segment(3) == 'createStep3' ? 'bc-active' : '' }} {{ (request()->segment(3) == 'createStep4' || request()->segment(3) == 'createStep5' ? 'bc-check' : '' ) }}">Third Step</li>
            <li class="{{ request()->segment(3) == 'createStep4' ? 'bc-active' : '' }} {{ (request()->segment(3) == 'createStep5' ? 'bc-check' : '') }}">Fourth Step</li>
            <li class="{{ request()->segment(3) == 'createStep5' ? 'bc-active' : '' }}">Fifth Step</li>
        </ul>
    </div>
</div>