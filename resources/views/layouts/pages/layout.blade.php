<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zaiko.</title>
<style>
    .form_delete_btn {
    display: inline-block !important;
    }
    /* .form_control_approved{
        display: inline-block !important;
        width: 20px;
        height: calc(2.25rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        box-shadow: inset 0 0 0 transparent;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    } */
</style>
  


    <!-- Google Font: Source Sans Pro -->
    
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Ionicons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
    {{-- sidenav --}}
    <link rel="stylesheet" href="plugins/aasidenav/styles.css">




    
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    {{-- display content --}}
    @yield('nav')
   
    <div class="wrapper">
        <div class="content-wrapper">
        @if(session('success'))
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
@if(Session::has('success'))
    $(document).ready(function(){
        $('#success-message').addClass('alert alert-success').html('{{ Session::get('success') }}');
        $('#success-message').delay(5000).fadeOut('slow');
    });
@endif
</script> -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
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
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js" defer></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js" defer></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js" defer></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




<script>
  $(function () {
    $("#borrowed").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
      
    });
    $("#pending").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
      
    });
    $("#returned").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
      
    });
    $("#listofitems").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
      
    });
    $("#listofusers").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
      
    });
    
    
  });
</script>


<script type="text/javascript">
   


    $(document).ready(function(){
        $('.show-alert-delete-user').click(function(event){
        var form =  $(this).closest("form");
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

    
    $('.show-alert-delete-item').click(function(event){
            var form =  $(this).closest("form");
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