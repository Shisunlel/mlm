@extends('admin.layouts.app')
@push('style')
    <style>
        ol > li {
            margin: 0 0 0 1em;
        }

        .bc-active {
            background: teal;
            color: whitesmoke;
        }
    </style>
@endpush
@section('panel')
<div class="row">
    <div class="col-lg-12 d-flex justify-content-center">
        <ol class="d-flex w-75 justify-content-between">
            <li class="bc-active">First Step</li>
            <li>Second Step</li>
            <li>Third Step</li>
            <li>Fourth Step</li>
            <li>Fifth Step</li>
        </ol>
    </div>
</div>
<div class="row mt-5 d-flex justify-content-center">
    <div class="col-3">
        <div class="card mb-3" style="max-width: 18rem;">
            <div class="card-header">ការចុះឈ្មោះជាសមាជិកខ្មែរ</div>
            <div class="card-body">
              <a href="{{ route('admin.members.createStep2') }}" class="btn btn-primary card-text">ការចូលជាសមាជិក</a>
            </div>
          </div>
    </div>
    <div class="col-3">
        <div class="card mb-3" style="max-width: 18rem;">
            <div class="card-header">Foreign resident in Cambodia</div>
            <div class="card-body">
              <a href="{{ route('admin.members.createStep2') }}" class="btn btn-primary card-text">Join</a>
            </div>
          </div>
    </div>
</div>
@endsection