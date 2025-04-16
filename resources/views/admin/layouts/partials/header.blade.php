<link rel="shortcut icon" sizes="196x196" href="{{ route('admin.assets') }}/images/logo.svg">
<!-- style -->
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/font-awesome/css/font-awesome.min.css" type="text/css"/>
<!-- build:css ../assets/css/app.min.css -->
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/css/app.css" type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/css/style.css?v=1" type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
      type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/owl.carousel/dist/assets/owl.carousel.min.css"
      type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/owl.carousel/dist/assets/owl.theme.default.css" type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/bootstrap-table/dist/bootstrap-table.min.css"
      type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/dropzone/dist/min/dropzone.min.css" type="text/css"/>

<link rel="stylesheet"
      href="{{ route('admin.assets') }}/libs/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css"
      type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"
      type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/fullcalendar/dist/fullcalendar.min.css" type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/select2/dist/css/select2.min.css" type="text/css"/>

<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/summernote/dist/summernote.css" type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/summernote/dist/summernote-bs4.css" type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/jqvmap/dist/jqvmap.min.css" type="text/css"/>
<link rel="stylesheet" href="{{ route('admin.assets') }}/libs/node-waves/dist/waves.min.css" type="text/css"/>

<link rel="stylesheet" href="{{ asset('assets/css/style_custom.css')}}">
<link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}"/>



<!-- endbuild -->


<script src="https://cdn.tiny.cloud/1/nnpb8io1jfy6h0aqrzne1p3j82etfjy54pxjrtbw53cny61l/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
     relative_urls: false,
        selector: '.html',
        image_class_list: [
            {title: 'img-responsive', value: 'img-responsive'},
        ],
        plugins:[
            "advlist autolink lists link image charmap print preview anchor media",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste imagetools","nonbreaking"
        ],
        image_advtab: true,
        min_height: 350,
        required: true,
        a11y_advanced_options: true,
        toolbar: 'undo redo  | code  | insertfile | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fontsizeselect |forecolor ',
        nonbreaking_force_tab: true,
        image_title: true,
        automatic_uploads: true,
        images_upload_url: '/admin/upload',
        file_picker_types: 'image',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
            };
            input.click();
        },
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        media_live_embeds: true,
        mediaembed_service_url: 'http://example.com/mediaembed_service'
        });</script>
