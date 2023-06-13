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

    
        /* .pending-yellow{
            col
        } */
 
    </style>



    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Ionicons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
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
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}" defer></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}" defer></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}" defer></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}" defer></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}" defer></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}" defer></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}" defer></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}" defer></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}" defer></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- sline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

<script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"></script>

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
        $("#admin-pending").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false

        });
        $("#user-pending").DataTable({
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
    $(document).on('click', '#btn-return', function() {
      var dataId = $(this).attr("data-id");
      var dataSerial = $(this).attr("data-serial");
      $("#idreturn").val(dataId);
      $("#serialreturn").val(dataSerial);
    });
  });
  
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
                var userID = ui.item.value;
                var url = '/check-userID/' + userID;

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.exists) {
                            Swal.fire(
                                ui.item.lastName +', '+ ui.item.firstName,
                                'Has already pending borrowing. Please go to the pending table to update. Thank you.',
                                'error'
                            );
                            $('#idNumber').val('');
                            // User ID exists
                            // Handle the case when the user ID already exists
                        } else {
                            $('#search-serial-desc').show();
                            $('#student_id').val(ui.item.value);
               

                        }
                    },
                    error: function(xhr) {
                        // Handle the error
                        console.log(xhr.responseText);
                    }
                });

                
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
    $("#search_item").autocomplete({
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
            $("#item-serial .ui-autocomplete").css("top", "auto");
        },
        // Custom rendering of autocomplete items
        response: function(event, ui) {
            if (!ui.content.length) {
                var noResult = {
                    value: "",
                    brand: "No matching Serial Numbers and Description found",
                    item_category: null,
                    model: null,
                    description: null
                };
                ui.content.push(noResult);
            }
        },
        select: function(event, ui) {
            if (ui.item.value === "") {
                event.preventDefault();
            } else {
                event.preventDefault();
                if (!ui.item.serialNumber || ui.item.serialNumber === 'N/A') {
                    var userID = $("#student_id").val();
                    var itemId = ui.item.id;
                    console.log(userID);

                    var url = '/add-item/' + itemId;
                    
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Successfully Added',
                    showConfirmButton: false,
                    timer: 1500
                });

                var tableRow = $('<tr>');
                $('<td class="d-none">').text(userID).appendTo(tableRow);
                $('<td class="d-none">').text(response.id).appendTo(tableRow);
                $('<td>').text(response.brand).appendTo(tableRow);
                $('<td>').text(response.model).appendTo(tableRow);
                $('<td>').text(response.description).appendTo(tableRow);
                var quantityInput = $('<input>').attr('type', 'number').attr('max', response.quantity).val(response.quantity);
                $('<td>').append(quantityInput).appendTo(tableRow);
                var buttonCell = $('<td>');
                var addButton = $('<button class="btn btn-success">').text('Add').appendTo(buttonCell);
                var cancelButton = $('<button class="btn btn-danger">').text('Cancel').appendTo(buttonCell);
                tableRow.append(buttonCell);
                tableRow.appendTo('#notAdded tbody');

                quantityInput.on('input', function() {
                    var enteredValue = parseInt($(this).val());
                    var maxValue = parseInt($(this).attr('max'));
                    if (enteredValue > maxValue) {  
                    Swal.fire(
                        'Quantity cannot exceed ' + maxValue,
                        'Try input ' + maxValue + ' or below.',
                        'question'
                    );
                    $(this).val(maxValue);
                    }
                });

                addButton.on('click', function() {
                    // Perform the "Add" action here
                    console.log('Add button clicked');
                    var userId = $(this).closest('tr').find('td:nth-child(1)').text();
                    var itemId = $(this).closest('tr').find('td:nth-child(2)').text();
                    var brand = $(this).closest('tr').find('td:nth-child(3)').text();
                    var model = $(this).closest('tr').find('td:nth-child(4)').text();
                    var description = $(this).closest('tr').find('td:nth-child(5)').text();
                    var serial = $(this).closest('tr').find('td:nth-child(6)').text();
                    var quantity = $(this).closest('tr').find('input').val();

                    // Create an object to send in the AJAX request
                    var requestData = {
                    userId: userId,
                    itemId: itemId,
                    brand: brand,
                    model: model,
                    description: description,
                    serial: serial,
                    quantity: quantity
                    };

                    $.ajax({
                    url: "{{ route('adminAddedOrder') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: requestData,
                    success: function(response) {
                        // Handle the response data
                        Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Successfully Added',
                        showConfirmButton: false,
                        timer: 1500
                        });

                        // Clear the inputs and remove the table row
                        tableRow.find('input').val('');
                        tableRow.remove();

                        // Append the data to the alreadyAdded table
                        var newRow = $('<tr>');
                        $('<td class="d-none">').text(response.userId).appendTo(newRow);
                        $('<td>').text(response.brand).appendTo(newRow);
                        $('<td>').text(response.model).appendTo(newRow);
                        $('<td>').text(response.description).appendTo(newRow);
                        $('<td>').text(response.serial).appendTo(newRow);
                        $('<td>').text(response.quantity).appendTo(newRow);
                        var cancelButton = $('<button class="btn btn-danger">').text('Cancel').appendTo(newRow);
                        newRow.appendTo('#alreadyAdded tbody');
                    },
                    error: function(xhr) {
                        // Handle the error
                        console.log(xhr.responseText);
                    }
                    });
                });

                cancelButton.on('click', function() {
                    // Perform the "Cancel" action here
                    tableRow.remove();
                    console.log('Cancel button clicked');
                });
                },

                                        error: function(xhr) {
                                            // Handle the error
                                            console.log(xhr.responseText);
                                        }
                                    });
                   
                }else{
                    var userID = $("#student_id").val();
                    var itemId = ui.item.id;
                    var serialNumber = ui.item.serialNumber;
                    console.log('added');

                    $.ajax({
                    url: "{{ route('pendingBorrow') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        userID: userID,
                        itemId: itemId,
                        serialNumber: serialNumber
                    },
                    success: function(response) {
                        // Handle the response data
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully Added',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // Clear the alreadyAdded table
                        $('#alreadyAdded tbody').empty();

                        for (var i = 0; i < response.length; i++) {
                            var rowData = response[i];
                            var tableRow = $('<tr>').appendTo('#alreadyAdded tbody');
                            $('<td class="d-none">').text(rowData.user_id).appendTo(tableRow);
                            $('<td>').text(rowData.brand).appendTo(tableRow);
                            $('<td>').text(rowData.model).appendTo(tableRow);
                            $('<td>').text(rowData.description).appendTo(tableRow);
                            $('<td>').text(rowData.order_serial_number).appendTo(tableRow);
                            $('<td>').text(rowData.quantity).appendTo(tableRow);
                            var buttonCell = $('<td>').appendTo(tableRow);
                            var cancelButton = $('<button class="btn btn-danger">').text('Cancel').appendTo(buttonCell);
                        }
                    },
                    error: function(xhr) {
                        // Handle the error
                        console.log(xhr.responseText);
                    }
                });

                  
                }
               
                
            }
        }

    }).autocomplete("instance")._renderItem = function(ul, item) {
        if (item.value === "") {
            return $("<li>")
                .append("<div>" + item.brand + "</div>")
                .appendTo(ul);
        } else {
            return $("<li>").append("<div>" + item.value + "</div>").appendTo(ul);
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
