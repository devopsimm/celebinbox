<div class="content-footer white " id="content-footer">
    <div class="d-flex p-3">
{{--        <span class="text-sm flex">&copy; {{ date('Y') }} OverSeek All Rights Reserved</span>--}}

    </div>
</div>
</div>
<!-- ############ Content END-->
<!-- ############ LAYOUT END-->
</div>

{{--@stack('beforeScripts')--}}
<script src="{{ url('admin-assets/libs/jquery/dist/jquery.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ url('admin-assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ url('admin-assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- core -->
<script src="{{ url('admin-assets/libs/pace-progress/pace.min.js') }}"></script>
<script src="{{ url('admin-assets/libs/pjax/pjax.min.js') }}"></script>

<script src="{{ url('admin-assets/js/nav.js') }}"></script>
<script src="{{ url('admin-assets/js/scrollto.js') }}"></script>
<script src="{{ url('admin-assets/js/toggleclass.js') }}"></script>

<script src="{{ url('admin-assets/js/app.js') }}"></script>
{{--<script src="{{ url('admin-assets/js/app/user.js') }}"></script>--}}
<script src="{{ url('admin-assets/libs/moment/min/moment-with-locales.min.js') }}"></script>
{{--<script src="{{ url('admin-assets/js/plugins/datetimepicker.js') }}"></script>--}}
<script src="{{ url('admin-assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('admin-assets/libs/parsleyjs/dist/parsley.min.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ url('admin-assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('admin-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--<script src="{{ route('admin.assets') }}/js/jquery.validate.min.js"></script>--}}
<style>
</style>
<script>
    ;

    $('form input').keydown(function (e) {
        if (e.keyCode == 13) {
            var inputs = $(this).parents("form").eq(0).find(":input");
            if (inputs[inputs.index(this) + 1] != null) {
                inputs[inputs.index(this) + 1].focus();
            }
            e.preventDefault();
            return false;
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>


<!-- endbuild -->

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script defer src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function (){

        $('select').select2();
    });
</script>
@stack('afterSelectScripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="{{ url('admin-assets/js/validation.js') }}"></script>

@stack('scripts')



</body>
</html>
