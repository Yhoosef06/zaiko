<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zaiko</title>
    <style>
        .form_delete_btn {
            display: inline-block !important;
        }

    
        /* .ui-autocomplete-loading {
            background: white url('/images/loading.gif') right center no-repeat;
        } */
 
    </style>



    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/jquery-ui/jquery-ui.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Ionicons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="@sweetalert2/themes/dark/dark.css"> -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    {{-- display content --}}
    @yield('nav')

    <div class="wrapper">
        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{ session('success') }}
                </div>
                <!-- <div class="alert alert-success">
        {{ session('success') }}
    </div> -->
            @endif
            @yield('content-header')
            @yield('content')
        </div>
    </div>



    @yield('footer')
    @yield('script')
</body>
<!-- <script>
    @if (Session::has('success'))
        $(document).ready(function() {
            $('#success-message').addClass('alert alert-success').html('{{ Session::get('success') }}');
            $('#success-message').delay(5000).fadeOut('slow');
        });
    @endif
</script> -->
<!-- Include jQuery library -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- Include jQuery UI library -->
<!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script> -->
<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/smoothness/jquery-ui.css"> -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- jQuery UI 1.11.4 -->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js" defer></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js" defer></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js" defer></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js" defer></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js" defer></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js" defer></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js" defer></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js" defer></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js" defer></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- sline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>

<script src="dist/js/bootstrap.bundle.min.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script> -->
<!-- <script src="sweetalert2/dist/sweetalert2.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    var csrfToken = $('meta[name="csrf-token"]').attr('content');





 $(function () {


        $("#borrowed").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false

        });
        $("#pending").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false

        });
        $("#returned").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false

        });
        $("#listofitems").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false

        });
        $("#listofusers").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false

        });


    });
</script>


<script type="text/javascript">

$(document).ready(function() {
    $("#idNumber").autocomplete({
        minLength: 2,
        source: function(request, response) {
            $.ajax({
                url: "{{ route('searchUser') }}",
                dataType: "json",
                data: {
                    query: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        appendTo: "#user_id_container",
        open: function(event, ui) {
            $("#user_id_container .ui-autocomplete").css("top", "auto");
        },
        // Custom rendering of autocomplete items
        response: function(event, ui) {
            if (!ui.content.length) {
                var noResult = { value: "", label: "No matching ID numbers found" };
                ui.content.push(noResult);
            }
        },
        select: function(event, ui) {
            if (ui.item.value === "") {
                event.preventDefault();
            } else {
                $('#profile').show();
                $('.item-category').show();
                $('#first_name').val(ui.item.firstName);
                $('#last_name').val(ui.item.lastName);
            }
        }

    }).autocomplete("instance")._renderItem = function(ul, item) {
        if (item.value === "") {
            return $("<li>")
                .append("<div>" + item.label + "</div>")
                .appendTo(ul);
        } else {
            return $("<li>").append("<div>" + item.value +" "+ item.lastName +"," +" "+ item.firstName +  "</div>").appendTo(ul);
        }
    };

});


$(document).ready(function() {
    $("#serial_number").autocomplete({
        minLength: 2,
        source: function(request, response) {
            $.ajax({
                url: "{{ route('searchItem') }}",
                dataType: "json",
                data: {
                    query: request.term
                },
                success: function(data) {
                    console.log(data);
                    response(data);
                }
            });
        },
        appendTo: "#user_id_container",
        open: function(event, ui) {
            $("#item-serial .ui-autocomplete").css("top", "auto");r
        },
        // Custom rendering of autocomplete items
        response: function(event, ui) {
            if (!ui.content.length) {
                var noResult = { value: "", brand: "No matching Serial Numbers found" };
                ui.content.push(noResult);
            }
        },
        select: function(event, ui) {
            if (ui.item.value === "") {
                event.preventDefault();
            } else {
                $('#brand').val(ui.item.brand);
                $('#model').val(ui.item.model);
                $('#item_description').val(ui.item.description);
            }
        }

    }).autocomplete("instance")._renderItem = function(ul, item) {
        if (item.value === "") {
            return $("<li>")
                .append("<div>" + item.brand + "</div>")
                .appendTo(ul);
        } else {
            return $("<li>").append("<div>" + item.value +" - "+ item.brand  +" - "+ item.model +  "</div>").appendTo(ul);
        }
    };
 });




    $(document).ready(function() {
        $('.show-alert-delete-user').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });


        $('.show-alert-delete-item').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();

                }
            });
        });

        // $('.borrowed-approve').click(function(event){
        //         var form =  $(this).closest("form");
        //         event.preventDefault();
        //         Swal.fire({
        //         position: 'top-end',
        //         icon: 'success',
        //         title: 'Borow has been approved,
        //         showConfirmButton: false,
        //         timer: 1500
        //         }).then((result) => {
        //         if (result.isConfirmed) {
        //                 form.submit();

        //             }
        //         });
        // });

    });



    //     Swal.fire(
    //       'Deleted!',
    //       'Your file has been deleted.',
    //       'success'
    //     )
    //   }
    // })
</script>


</html
