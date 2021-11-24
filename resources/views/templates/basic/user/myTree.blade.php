<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/png" href="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'users/css/vendor/bootstrap.min.css') }}">
    <!-- bootstrap toggle css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'users/css/vendor/bootstrap-toggle.min.css')}}">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'users/css/all.min.css')}}">
    <!-- line-awesome webfont -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'users/css/line-awesome.min.css')}}">
    <link href="{{asset($activeTemplateTrue.'users/css/tree.css')}}" rel="stylesheet">
    <title>{{ $general->sitename($page_title ?? '') }}</title>
</head>
<body>
    <a class="d-flex justify-content-end px-2 py-2" href="{{route('user.office')}}"><button class="btn btn-success">Go Back</button></a>
    <div class="card p-5" style="border: none;">
        <div class="row text-center justify-content-center llll">
            <!-- <div class="col"> -->
            <div class="w-1">
                @php echo showSingleUserinTree($tree['a']); @endphp
            </div>
        </div>
        <div class="row text-center justify-content-center llll">
            <!-- <div class="col"> -->
            <div class="w-2">
                @php echo showSingleUserinTree($tree['b']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-2 ">
                @php echo showSingleUserinTree($tree['c']); @endphp
            </div>
        </div>
        <div class="row text-center justify-content-center llll">
            <!-- <div class="col"> -->
            <div class="w-4 ">
                @php echo showSingleUserinTree($tree['d']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-4 ">
                @php echo showSingleUserinTree($tree['e']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-4 ">
                @php echo showSingleUserinTree($tree['f']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-4 ">
                @php echo showSingleUserinTree($tree['g']); @endphp
            </div>
            <!-- <div class="col"> -->

        </div>
        <div class="row text-center justify-content-center llll">
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['h']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['i']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['j']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['k']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['l']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['m']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['n']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['o']); @endphp
            </div>


        </div>
    </div>


    <div class="modal fade user-details-modal-area" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">@lang('User Details')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="@lang('Close')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="user-details-modal">
                        <div class="user-details-header ">
                            <div class="thumb"><img src="#" alt="*" class="tree_image w-h-100-p"
                                ></div>
                            <div class="content">
                                <a class="user-name tree_url tree_name" href=""></a>
                                <span class="user-status tree_plan"></span>
                            </div>
                        </div>
                        <div class="user-details-body text-center">

                            <h6 class="my-3">@lang('frontend.referred_by'): <span class="tree_ref"></span></h6>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset($activeTemplateTrue.'users/js/vendor/jquery-3.5.1.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset($activeTemplateTrue.'users/js/vendor/bootstrap.bundle.min.js')}}"></script></script>
<!-- bootstrap-toggle js -->
<script src="{{asset($activeTemplateTrue.'users/js/vendor/bootstrap-toggle.min.js')}}"></script>

    <script>
        "use strict";
        (function ($) {
            $('.showDetails').on('click', function () {
                var modal = $('#exampleModalCenter');

                $('.tree_name').text($(this).data('name'));
                $('.tree_url').attr({"href": $(this).data('treeurl')});
                $('.tree_status').text($(this).data('status'));
                $('.tree_plan').text($(this).data('plan'));
                $('.tree_image').attr({"src": $(this).data('image')});
                $('.user-details-header').removeClass('Paid');
                $('.user-details-header').removeClass('Free');
                $('.user-details-header').addClass($(this).data('status'));
                $('.tree_ref').text($(this).data('refby'));
                $('#exampleModalCenter').modal('show');
            });
        })(jQuery);
    </script>




</body>
</html>