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


       
    </style>


    <link rel="stylesheet" href="{{ asset('css/borrower.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  
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

<body class="hold-transition sidebar-mini layout-fixed" style="background-color: #BECBC9;">
    {{-- display content --}}
    @yield('nav')
    <div class="wrapper">
        <div class="content-wrapper" style="background-color: #BECBC9;">
            {{-- @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{ session('success') }}
                </div>
                <!-- <div class="alert alert-success">
                {{ session('success') }}
            </div> -->
            @endif --}}
            @yield('content-header')
            @yield('content')
        </div>

    </div>

</body>



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
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
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



  
   

    $(function() {
        $('#reservation').daterangepicker()

        $("#user-overdue").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false

        });
        $("#released-table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false

        });
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

        $('.select2').select2()
        // $("#listofitems").DataTable({
        //     "responsive": true,
        //     "lengthChange": false,
        //     "autoWidth": false

        // });
        // $("#listofusers").DataTable({
        //     "responsive": true,
        //     "lengthChange": false,
        //     "autoWidth": false
        // });
        // $("#listofcolleges").DataTable({
        //     "responsive": true,
        //     "lengthChange": false,
        //     "autoWidth": false
        // });
        // $("#listofdepartments").DataTable({
        //     "responsive": true,
        //     "lengthChange": false,
        //     "autoWidth": false
        // });
        // $("#listofcategories").DataTable({
        //     "responsive": true,
        //     "lengthChange": false,
        //     "autoWidth": false
        // });
        // $("#listofbrands").DataTable({
        //     "responsive": true,
        //     "lengthChange": false,
        //     "autoWidth": false
        // });
        // $("#listofmodels").DataTable({
        //     "responsive": true,
        //     "lengthChange": false,
        //     "autoWidth": false
        // });
        // $("#listofterms").DataTable({
        //     "responsive": true,
        //     "lengthChange": false,
        //     "autoWidth": false
        // });
        // $("#listofrooms").DataTable({
        //     "responsive": true,
        //     "lengthChange": false,
        //     "autoWidth": false
        // });


    });




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
                    var noResult = {
                        value: "",
                        label: "No matching ID numbers found"
                    };
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
                                    ui.item.lastName + ', ' + ui.item.firstName,
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
                return $("<li>").append("<div>" + item.value + " " + item.lastName + "," + " " + item
                    .firstName + "</div>").appendTo(ul);
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
            appendTo: "#search-item",
            open: function(event, ui) {
                $("#search-item .ui-autocomplete").css("top", "auto");
            },

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
                    // event.preventDefault();
                    if (!ui.item.serialNumber || ui.item.serialNumber === 'N/A') {
                        var userID = $("#student_id").val();
                        var itemId = ui.item.id;
                    


                        var url = '/add-item/' + itemId;

                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                console.log(response);
                                $('#showNotAddedTable').show();
                                var tableRow = $('<tr>');
                                $('<td class="d-none">').text(userID).appendTo(
                                    tableRow);
                                $('<td class="d-none">').text(response.item.id).appendTo(
                                    tableRow);
                                $('<td class="d-none">').text(response.item.duration).appendTo(
                                    tableRow);
                                $('<td>').text(response.item.brand).appendTo(tableRow);
                                $('<td>').text(response.item.model).appendTo(tableRow);
                                $('<td>').text(response.item.description).appendTo(tableRow);
                                $('<td>').text(response.item.serial_number).appendTo(
                                    tableRow);
                                var quantityInput = $('<input>').attr('type', 'number')
                                    .attr('max', response.availableQuantity).val(
                                        response.availableQuantity);
                                $('<td>').append(quantityInput).appendTo(tableRow);
                                var buttonCell = $('<td>');
                                var addButton = $('<button class="btn btn-success">')
                                    .text('Add').appendTo(buttonCell);
                                var cancelButton = $('<button class="btn btn-danger">')
                                    .text('Cancel').appendTo(buttonCell);
                                tableRow.append(buttonCell);
                                tableRow.appendTo('#notAdded tbody');

                                quantityInput.on('input', function() {
                                    var enteredValue = parseInt($(this).val());
                                    var maxValue = parseInt($(this).attr(
                                        'max'));
                                    if (enteredValue > maxValue) {
                                        Swal.fire(
                                            'Quantity cannot exceed ' +
                                            maxValue,
                                            'Try input ' + maxValue +
                                            ' or below.',
                                            'question'
                                        );
                                        $(this).val(maxValue);
                                    }
                                });

                                addButton.on('click', function() {


                                    var userId = $(this).closest('tr').find(
                                        'td:nth-child(1)').text();
                                    var itemId = $(this).closest('tr').find(
                                        'td:nth-child(2)').text();
                                        var duration = $(this).closest('tr').find(
                                        'td:nth-child(3)').text();
                                    var brand = $(this).closest('tr').find(
                                        'td:nth-child(4)').text();
                                    var model = $(this).closest('tr').find(
                                        'td:nth-child(5)').text();
                                    var description = $(this).closest('tr')
                                        .find('td:nth-child(6)').text();
                                    var serial = $(this).closest('tr').find(
                                        'td:nth-child(7)').text();
                                    var order_quantity = $(this).closest('tr')
                                        .find('input').val();


                                    var requestData = {
                                        userId: userId,
                                        itemId: itemId,
                                        brand: brand,
                                        model: model,
                                        description: description,
                                        serial: serial,
                                        duration:duration,
                                        quantity: order_quantity
                                    };
                                    console.log(requestData)
                                    $.ajax({
                                        url: "{{ route('adminAddedOrder') }}",
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        data: requestData,
                                        success: function(response) {

                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Successfully Added',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });

                                            window.location.href =
                                                '/borrow-item/' +
                                                userId;



                                        },
                                        error: function(xhr) {

                                            console.log(xhr
                                                .responseText);
                                        }
                                    });
                                });

                                cancelButton.on('click', function() {

                                    tableRow.remove();
                                    $('#showNotAddedTable').hide();

                                });
                            },

                            error: function(xhr) {
                                // Handle the error
                                console.log(xhr.responseText);
                            }
                        });

                    } else {
                        var userID = $("#student_id").val();
                        var itemId = ui.item.id;
                        var serialNumber = ui.item.serialNumber;
                        var duration = ui.item.duration;


                        $.ajax({
                            url: "{{ route('pendingBorrow') }}",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                userID: userID,
                                itemId: itemId,
                                duration:duration,
                                serialNumber: serialNumber
                            },
                            success: function(response) {

                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Successfully Added',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                window.location.href = '/borrow-item/' + userID;
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
        $("#admin_search_item").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchItemAdmin') }}",
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
            appendTo: "#search-item-admin-added",
            open: function(event, ui) {
                $("#search-item-admin-added .ui-autocomplete").css("top", "auto");
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
                    // event.preventDefault();
                    if (!ui.item.serialNumber || ui.item.serialNumber === 'N/A') {
                        var userID = $("#student_id_added").val();
                        var itemId = ui.item.id;


                        var url = '/add-item/' + itemId;

                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {

                                $('#showNotAddedAdmin').show();
                                var tableRow = $('<tr>');
                                $('<td class="d-none">').text(userID).appendTo(
                                    tableRow);
                                $('<td class="d-none">').text(response.item.id).appendTo(
                                    tableRow);
                                $('<td>').text(response.item.brand).appendTo(tableRow);
                                $('<td>').text(response.item.model).appendTo(tableRow);
                                $('<td>').text(response.item.description).appendTo(tableRow);
                                var quantityInput = $('<input>').attr('type', 'number')
                                    .attr('max', response.availableQuantity).val(
                                        response.availableQuantity);
                                $('<td>').append(quantityInput).appendTo(tableRow);
                                var buttonCell = $('<td>');
                                var addButton = $('<button class="btn btn-success">')
                                    .text('Add').appendTo(buttonCell);
                                var cancelButton = $('<button class="btn btn-danger">')
                                    .text('Cancel').appendTo(buttonCell);
                                tableRow.append(buttonCell);
                                tableRow.appendTo('#notAddedAdmin tbody');

                                quantityInput.on('input', function() {
                                    var enteredValue = parseInt($(this).val());
                                    var maxValue = parseInt($(this).attr(
                                        'max'));
                                    if (enteredValue > maxValue) {
                                        Swal.fire(
                                            'Quantity cannot exceed ' +
                                            maxValue,
                                            'Try input ' + maxValue +
                                            ' or below.',
                                            'question'
                                        );
                                        $(this).val(maxValue);
                                    }
                                });

                                addButton.on('click', function() {


                                    var userId = $(this).closest('tr').find(
                                        'td:nth-child(1)').text();
                                    var itemId = $(this).closest('tr').find(
                                        'td:nth-child(2)').text();
                                    var brand = $(this).closest('tr').find(
                                        'td:nth-child(3)').text();
                                    var model = $(this).closest('tr').find(
                                        'td:nth-child(4)').text();
                                    var description = $(this).closest('tr')
                                        .find('td:nth-child(5)').text();
                                    var serial = $(this).closest('tr').find(
                                        'td:nth-child(6)').text();
                                    var order_quantity = $(this).closest('tr')
                                        .find('input').val();


                                    var requestData = {
                                        userId: userId,
                                        itemId: itemId,
                                        brand: brand,
                                        model: model,
                                        description: description,
                                        serial: serial,
                                        quantity: order_quantity
                                    };

                                    $.ajax({
                                        url: "{{ route('adminAddedOrder') }}",
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        data: requestData,
                                        success: function(response) {

                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Successfully Added',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });

                                            window.location.href =
                                                '/borrow-item/' +
                                                userId.trim();



                                        },
                                        error: function(xhr) {

                                            console.log(xhr
                                                .responseText);
                                        }
                                    });
                                });

                                cancelButton.on('click', function() {

                                    tableRow.remove();
                                    $('#showNotAddedAdmin').hide();

                                });
                            },

                            error: function(xhr) {
                                // Handle the error
                                console.log(xhr.responseText);
                            }
                        });

                    } else {
                        var userID = $("#student_id_added").val();
                        var itemId = ui.item.id;
                        var serialNumber = ui.item.serialNumber;


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

                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Successfully Added',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                window.location.href = '/borrow-item/' + userID.trim();
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
//         var counterValue = $('#counterValue').data('counter');
// console.log(counterValue);
        for (let i = 1; i <= 20; i++) {
            $("#search_for_serial_" + i).autocomplete({
                
                minLength: 2,
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('searchForSerial') }}",
                        dataType: "json",
                        data: {
                            query: request.term
                        },
                        success: function(data) {

                            response(data);
                        }
                    });
                },
                appendTo: "#user_serial_" + i,
                open: function(event, ui) {
                    $("#user_serial_" + i + " .ui-autocomplete").css("top", "auto");
                },
               
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
                        $('#search_for_serial_' + i).val(ui.item.serialNumber);
                        $('#itemID_' + i).val(ui.item.itemID);
                        $('#duration_' + i).val(ui.item.duration);
                        console.log(ui.item.itemID);
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
        }
    });






    $(document).ready(function() {
        $("#searchItemAdmin").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchItemForAdmin') }}",
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
            appendTo: "#search-item-admin-to-borrow",
            open: function(event, ui) {
                $("#search-item-admin-to-borrow .ui-autocomplete").css("top", "auto");
            },

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
                        var userID = $("#student_id_added_admin").val();
                        var orderIdAdmin = $("#order-id").val().trim();
                        var itemId = ui.item.id;


                        var url = '/add-item/' + itemId;

                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                console.log(response);
                                $('#viewOrderAdminShowTable').show();
                                var tableRow = $('<tr>');
                                $('<td class="d-none">').text(userID).appendTo(
                                    tableRow);
                                $('<td class="d-none">').text(response.item.id).appendTo(
                                    tableRow);
                                $('<td>').text(response.item.brand).appendTo(tableRow);
                                $('<td>').text(response.item.model).appendTo(tableRow);
                                $('<td>').text(response.item.description).appendTo(tableRow);
                                var quantityInput = $('<input>').attr('type', 'number')
                                    .attr('max', response.availableQuantity).val(
                                        response.availableQuantity);
                                $('<td>').append(quantityInput).appendTo(tableRow);
                                var buttonCell = $('<td>');
                                var addButton = $('<button class="btn btn-success">')
                                    .text('Add').appendTo(buttonCell);
                                var cancelButton = $('<button class="btn btn-danger">')
                                    .text('Cancel').appendTo(buttonCell);
                                tableRow.append(buttonCell);
                                tableRow.appendTo('#orderAdmin tbody');

                                quantityInput.on('input', function() {
                                    var enteredValue = parseInt($(this).val());
                                    var maxValue = parseInt($(this).attr(
                                        'max'));
                                    if (enteredValue > maxValue) {
                                        Swal.fire(
                                            'Quantity cannot exceed ' +
                                            maxValue,
                                            'Try input ' + maxValue +
                                            ' or below.',
                                            'question'
                                        );
                                        $(this).val(maxValue);
                                    }
                                });

                                addButton.on('click', function() {


                                    var userId = $(this).closest('tr').find(
                                        'td:nth-child(1)').text();
                                    var itemId = $(this).closest('tr').find(
                                        'td:nth-child(2)').text();
                                    var brand = $(this).closest('tr').find(
                                        'td:nth-child(3)').text();
                                    var model = $(this).closest('tr').find(
                                        'td:nth-child(4)').text();
                                    var description = $(this).closest('tr')
                                        .find('td:nth-child(5)').text();
                                    var serial = $(this).closest('tr').find(
                                        'td:nth-child(6)').text();
                                    var order_quantity = $(this).closest('tr')
                                        .find('input').val();


                                    var requestData = {
                                        userId: userId,
                                        itemId: itemId,
                                        brand: brand,
                                        model: model,
                                        description: description,
                                        serial: serial,
                                        quantity: order_quantity
                                    };

                                    $.ajax({
                                        url: "{{ route('adminAddedOrder') }}",
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        data: requestData,
                                        success: function(response) {

                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Successfully Added',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });

                                            window.location.href =
                                                '/view-order-admin/' +
                                                orderIdAdmin;



                                        },
                                        error: function(xhr) {

                                            console.log(xhr
                                                .responseText);
                                        }
                                    });
                                });

                                cancelButton.on('click', function() {

                                    tableRow.remove();
                                    $('#viewOrderAdminShowTable').hide();

                                });
                            },

                            error: function(xhr) {
                                // Handle the error
                                console.log(xhr.responseText);
                            }
                        });

                    } else {
                        var userID = $("#student_id_added_admin").val();
                        var orderID = $("#order-id").val().trim();
                        var itemId = ui.item.id;
                        var serialNumber = ui.item.serialNumber;


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

                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Successfully Added',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                window.location.href = '/view-order-admin/' + orderID;
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
        $("#searchItemUser").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchItemForUser') }}",
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
            appendTo: "#search-item-user-to-borrow",
            open: function(event, ui) {
                $("#search-item-user-to-borrow .ui-autocomplete").css("top", "auto");
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

                    if (!ui.item.serialNumber || ui.item.serialNumber === 'N/A') {
                        var userID = $("#student_id_added_user").val();
                        var itemId = ui.item.id;
                        var order_id_user = $("#order-user-id").val();
                        var duration = ui.item.duration;

                        console.log(userID);


                        var url = '/add-item/' + itemId;

                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                console.log(response);
                                if( response.availableQuantity == 0){
                                    Swal.fire({
                                    title: "Not Available",
                                    text: "Items not Available",
                                    icon: "warning"
                                    });
                                }else{
                                    $('#viewOrderUserShowTable').show();
                                var tableRow = $('<tr>');
                                $('<td class="d-none">').text(userID).appendTo(
                                    tableRow);
                                $('<td class="d-none">').text(response.item.id).appendTo(
                                    tableRow);
                                $('<td>').text(response.item.brand).appendTo(tableRow);
                                $('<td>').text(response.item.model).appendTo(tableRow);
                                $('<td>').text(response.item.description).appendTo(tableRow);
                                var quantityInput = $('<input>').attr('type', 'number')
                                    .attr('max', response.availableQuantity).val(
                                        response.availableQuantity);
                                $('<td>').append(quantityInput).appendTo(tableRow);
                                var buttonCell = $('<td>');
                                var addButton = $('<button class="btn btn-success">')
                                    .text('Add').appendTo(buttonCell);
                                var cancelButton = $('<button class="btn btn-danger">')
                                    .text('Cancel').appendTo(buttonCell);
                                tableRow.append(buttonCell);
                                tableRow.appendTo('#orderUser tbody');

                                quantityInput.on('input', function() {
                                    var enteredValue = parseInt($(this).val());
                                    var maxValue = parseInt($(this).attr(
                                        'max'));
                                    if (enteredValue > maxValue) {
                                        Swal.fire(
                                            'Quantity cannot exceed ' +
                                            maxValue,
                                            'Try input ' + maxValue +
                                            ' or below.',
                                            'question'
                                        );
                                        $(this).val(maxValue);
                                    }
                                });

                                addButton.on('click', function() {


                                    var userId = $(this).closest('tr').find(
                                        'td:nth-child(1)').text();
                                    var itemId = $(this).closest('tr').find(
                                        'td:nth-child(2)').text();
                                    var brand = $(this).closest('tr').find(
                                        'td:nth-child(3)').text();
                                    var model = $(this).closest('tr').find(
                                        'td:nth-child(4)').text();
                                    var description = $(this).closest('tr')
                                        .find('td:nth-child(5)').text();
                                    var serial = $(this).closest('tr').find(
                                        'td:nth-child(6)').text();
                                    var order_quantity = $(this).closest('tr')
                                        .find('input').val();


                                    var requestData = {
                                        userId: userId,
                                        itemId: itemId,
                                        order_id_user: order_id_user,
                                        serial: serial,
                                        duration: duration,
                                        quantity: order_quantity
                                    };

                                    $.ajax({
                                        url: "{{ route('userNewOrder') }}",
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        data: requestData,
                                        success: function(response) {

                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Successfully Added',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });

                                            window.location.href =
                                                '/view-order-user/' +
                                                order_id_user.trim();



                                        },
                                        error: function(xhr) {

                                            console.log(xhr
                                                .responseText);
                                        }
                                    });
                                });

                                cancelButton.on('click', function() {

                                    tableRow.remove();
                                    $('#viewOrderUserShowTable').hide();

                                });
                                }
                                
                               
                            },

                            error: function(xhr) {
                                // Handle the error
                                console.log(xhr.responseText);
                            }
                        });

                    } else {
                        var userID = $("#student_id_added_user").val();
                        var itemId = ui.item.id;
                        var order_id_user = $("#order-user-id").val();
                        var serialNumber = ui.item.serialNumber;
                        var duration = ui.item.duration;


                        $.ajax({
                            url: "{{ route('userPendingBorrow') }}",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                userID: userID,
                                itemId: itemId,
                                duration: duration,
                                order_id_user:order_id_user,
                                serialNumber: serialNumber
                            },
                            success: function(response) {

                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Successfully Added',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                window.location.href = '/view-order-user/' + order_id_user.trim();
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
        $('#submitForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to make changes again!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('submitAdminBorrow') }}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Success',
                                    'Successfully Borrowed',
                                    'success'
                                );
                                window.location.href = "{{ url('pending') }}";
                            } else if (response.error) {
                                Swal.fire(
                                    'Error',
                                    'Date Not Provided',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error response, if needed
                            console.log(xhr.responseText);
                        }
                    });
                }
            })
        });
    });

    $(document).ready(function() {
    $("#transactionComplete").click(function(e) {
        var orderId = $(this).data("id");
        var url = '/complete-transaction/' + orderId;

        $.ajax({
            url: url,
            type: "GET",
            data: {
                orderId: orderId
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire(
                        'Success',
                        'Transaction Marked as Complete',
                        'success'
                    );
                    window.location.href = '/borrowed/';
                } else if (response.error) {
                    Swal.fire(
                        'Error',
                        'There are still items that must be returned.',
                        'error'
                    );
                }
            },
            error: function(xhr, status, error) {
                // Handle error response, if needed
                console.log(xhr.responseText);
            }
        });
    });
});

   

    $(document).ready(function() {
        $(".remove-borrow").click(function(e) {
            var orderId = $(this).data("id");
            var userID = $("#userIdNumber").val().trim();
            var url = '/remove-borrow/' + orderId;
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
                    $.ajax({
                        url: url,
                        type: "GET",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            orderId: orderId
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Success',
                                    'Successfully Removed',
                                    'success'
                                );
                                // Redirect to another page after success
                                window.location.href = '/borrow-item/' + userID;
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error response, if needed
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        $(".order-admin-remove").click(function(e) {
            var orderId = $(this).data("id");
            var currentOrderId = $("#order-id").val().trim();
            var url = '/order-admin-remove/' + orderId;
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
                    $.ajax({
                        url: url,
                        type: "GET",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            orderId: orderId
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Success',
                                    'Successfully Removed',
                                    'success'
                                );
                                // Redirect to another page after success
                                window.location.href = '/view-order-admin/' +
                                    currentOrderId;
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error response, if needed
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        $(".order-user-remove").click(function(e) {
            var orderId = $(this).data("id");
            var currentOrderId = $("#order-user-id").val().trim();
            console.log(orderId);
            var url = '/order-user-remove/' + orderId;
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
                    $.ajax({
                        url: url,
                        type: "GET",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            orderId: orderId
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Success',
                                    'Successfully Removed',
                                    'success'
                                );
                                // Redirect to another page after success
                                window.location.href = '/view-order-user/' +
                                    currentOrderId;
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error response, if needed
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });
    });




    $(document).ready(function() {
        $('#submitFormUser').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to make changes again!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('submitUserBorrow') }}",
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Success',
                                    'Successfully Borrowed',
                                    'success'
                                );
                                window.location.href = "{{ url('pending') }}";
                            } else if (response.error) {
                                Swal.fire(
                                    'Error',
                                    response.error,
                                    'error'
                                );
                            } else if (response.duplicate) {
                                Swal.fire(
                                    'Error',
                                    'The serial number is duplicated.',
                                    'error'
                                );
                            }else if(response.notavailable){
                                Swal.fire(
                                    'Error',
                                    'One item on the list isnt available to borrow.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            })
        });
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

 

    });

    $(document).ready(function() {
        $('#submitAdmin').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to make changes again!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('submitAdminBorrow') }}",
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Success',
                                    'Successfully Borrowed',
                                    'success'
                                );
                                window.location.href = "{{ url('pending') }}";
                            } else if (response.error) {
                                Swal.fire(
                                    'Error',
                                    'Date Not Provided',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error response, if needed
                            console.log(xhr.responseText);
                        }
                    });
                }
            })


        });
    });


    //Items Add Cart

    $(document).ready(function() {
      $("#addCart").click(function(e) {
          e.preventDefault();
          console.log('okay');
          
          Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
          }).then((result) => {
          if (result.isConfirmed) {
              Swal.fire({
              title: "Deleted!",
              text: "Your file has been deleted.",
              icon: "success"
              });
          }
          });
      });
  });

  $(document).ready(function() {
    $("#select-department").change(function(){
        var selectedValue = $(this).val();
        $.ajax({
            url: "{{ route('selectDepartment') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                department: selectedValue 
            },
            success: function(response) {
                if (response.success) {
                  
                    window.location.reload();
                } 
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }); 
});

$(document).ready(function() {
    $("#select-date-range").click(function(){
        var selectDate = $("#reservation").val(); 
         console.log(selectDate);
        $.ajax({
            url: "{{ route('selectDateRange') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                selectDate: selectDate 
            },
            success: function(response) {
                if (response.success) {
                  
                    window.location.reload();
                } 
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }); 
});





</script>


</html
