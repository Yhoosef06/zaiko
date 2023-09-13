
    var csrfToken = $('meta[name="csrf-token"]').attr('content');





    $(function() {


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

                                $('#showNotAddedTable').show();
                                var tableRow = $('<tr>');
                                $('<td class="d-none">').text(userID).appendTo(
                                tableRow);
                                $('<td class="d-none">').text(response.id).appendTo(
                                    tableRow);
                                $('<td>').text(response.brand).appendTo(tableRow);
                                $('<td>').text(response.model).appendTo(tableRow);
                                $('<td>').text(response.description).appendTo(tableRow);
                                $('<td>').text(response.serial_number).appendTo(
                                    tableRow);
                                var quantityInput = $('<input>').attr('type', 'number')
                                    .attr('max', response.available_quantity).val(
                                        response.available_quantity);
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
                                $('<td class="d-none">').text(response.id).appendTo(
                                    tableRow);
                                $('<td>').text(response.brand).appendTo(tableRow);
                                $('<td>').text(response.model).appendTo(tableRow);
                                $('<td>').text(response.description).appendTo(tableRow);
                                var quantityInput = $('<input>').attr('type', 'number')
                                    .attr('max', response.available_quantity).val(
                                        response.available_quantity);
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
        $("#search_for_serial_1").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchForSerial') }}",
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
            appendTo: "#user_serial_1",
            open: function(event, ui) {
                $("#user_serial_1 .ui-autocomplete").css("top", "auto");
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
                    $('#search_for_serial_1').val(ui.item.serialNumber);
                    $('#itemID_1').val(ui.item.itemID);


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
        $("#search_for_serial_2").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchForSerial') }}",
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
            appendTo: "#user_serial_2",
            open: function(event, ui) {
                $("#user_serial_2 .ui-autocomplete").css("top", "auto");
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
                    $('#search_for_serial_2').val(ui.item.serialNumber);
                    $('#itemID_2').val(ui.item.itemID);


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
        $("#search_for_serial_3").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchForSerial') }}",
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
            appendTo: "#user_serial_3",
            open: function(event, ui) {
                $(".user_serial .ui-autocomplete").css("top", "auto");
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
                    $('#search_for_serial_3').val(ui.item.serialNumber);
                    $('#itemID_3').val(ui.item.itemID);


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
        $("#search_for_serial_4").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchForSerial') }}",
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
            appendTo: "#user_serial_4",
            open: function(event, ui) {
                $("#user_serial_4 .ui-autocomplete").css("top", "auto");
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
                    $('#search_for_serial_4').val(ui.item.serialNumber);
                    $('#itemID_4').val(ui.item.itemID);


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
        $("#search_for_serial_5").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchForSerial') }}",
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
            appendTo: "#user_serial_5",
            open: function(event, ui) {
                $("#user_serial_5 .ui-autocomplete").css("top", "auto");
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
                    $('#search_for_serial_5').val(ui.item.serialNumber);
                    $('#itemID_5').val(ui.item.itemID);


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
        $("#search_for_serial_6").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchForSerial') }}",
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
            appendTo: "#user_serial_6",
            open: function(event, ui) {
                $("#user_serial_6 .ui-autocomplete").css("top", "auto");
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
                    $('#search_for_serial_6').val(ui.item.serialNumber);
                    $('#itemID_2').val(ui.item.itemID);


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
        $("#search_for_serial_7").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchForSerial') }}",
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
            appendTo: "#user_serial_7",
            open: function(event, ui) {
                $("#user_serial_7 .ui-autocomplete").css("top", "auto");
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
                    $('#search_for_serial_7').val(ui.item.serialNumber);
                    $('#itemID_7').val(ui.item.itemID);


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
        $("#search_for_serial_8").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchForSerial') }}",
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
            appendTo: "#user_serial_8",
            open: function(event, ui) {
                $("#user_serial_8 .ui-autocomplete").css("top", "auto");
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
                    $('#search_for_serial_8').val(ui.item.serialNumber);
                    $('#itemID_8').val(ui.item.itemID);


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
        $("#search_for_serial_9").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchForSerial') }}",
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
            appendTo: "#user_serial_9",
            open: function(event, ui) {
                $("#user_serial_9 .ui-autocomplete").css("top", "auto");
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
                    $('#search_for_serial_9').val(ui.item.serialNumber);
                    $('#itemID_9').val(ui.item.itemID);


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
        $("#search_for_serial_10").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchForSerial') }}",
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
            appendTo: "#user_serial_10",
            open: function(event, ui) {
                $("#user_serial_10 .ui-autocomplete").css("top", "auto");
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
                    $('#search_for_serial_10').val(ui.item.serialNumber);
                    $('#itemID_10').val(ui.item.itemID);


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
        $("#search_for_serial_11").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchForSerial') }}",
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
            appendTo: "#user_serial_11",
            open: function(event, ui) {
                $("#user_serial_11 .ui-autocomplete").css("top", "auto");
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
                    $('#search_for_serial_11').val(ui.item.serialNumber);
                    $('#itemID_11').val(ui.item.itemID);


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
        $("#search_for_serial_12").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchForSerial') }}",
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
            appendTo: "#user_serial_12",
            open: function(event, ui) {
                $("#user_serial_12 .ui-autocomplete").css("top", "auto");
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
                    $('#search_for_serial_12').val(ui.item.serialNumber);
                    $('#itemID_12').val(ui.item.itemID);


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
                        var itemId = ui.item.id;


                        var url = '/add-item/' + itemId;

                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {

                                $('#viewOrderAdminShowTable').show();
                                var tableRow = $('<tr>');
                                $('<td class="d-none">').text(userID).appendTo(
                                tableRow);
                                $('<td class="d-none">').text(response.id).appendTo(
                                    tableRow);
                                $('<td>').text(response.brand).appendTo(tableRow);
                                $('<td>').text(response.model).appendTo(tableRow);
                                $('<td>').text(response.description).appendTo(tableRow);
                                var quantityInput = $('<input>').attr('type', 'number')
                                    .attr('max', response.available_quantity).val(
                                        response.available_quantity);
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
                                window.location.href = '/view-order-admin/' + userID
                                    .trim();
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

                        console.log(userID);


                        var url = '/add-item/' + itemId;

                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {

                                $('#viewOrderUserShowTable').show();
                                var tableRow = $('<tr>');
                                $('<td class="d-none">').text(userID).appendTo(
                                tableRow);
                                $('<td class="d-none">').text(response.id).appendTo(
                                    tableRow);
                                $('<td>').text(response.brand).appendTo(tableRow);
                                $('<td>').text(response.model).appendTo(tableRow);
                                $('<td>').text(response.description).appendTo(tableRow);
                                var quantityInput = $('<input>').attr('type', 'number')
                                    .attr('max', response.available_quantity).val(
                                        response.available_quantity);
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
                                        brand: brand,
                                        model: model,
                                        description: description,
                                        serial: serial,
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
                                    $('#viewOrderUserShowTable').hide();

                                });
                            },

                            error: function(xhr) {
                                // Handle the error
                                console.log(xhr.responseText);
                            }
                        });

                    } else {
                        var userID = $("#student_id_added_user").val();
                        var itemId = ui.item.id;
                        var serialNumber = ui.item.serialNumber;


                        $.ajax({
                            url: "{{ route('userPendingBorrow') }}",
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
                                window.location.href = '/view-order-user/' + userID
                                    .trim();
                            },
                            error: function(xhr) {
                                // Handle the error
                                console.log(xhr.responseText);
                            }
                        });


                    }
                    // event.preventDefault();
                    // var orderID = $("#orderID").val();

                    // var tableRow = $('<tr>');
                    // $('<td class="d-none">').text(ui.item.id).appendTo(tableRow);
                    // $('<td class="d-none">').text(ui.item.itemID).appendTo(tableRow);
                    // $('<td class="d-none">').text(orderID).appendTo(tableRow);
                    // $('<td>').text(ui.item.brand).appendTo(tableRow);
                    // $('<td>').text(ui.item.model).appendTo(tableRow);
                    // $('<td>').text(ui.item.description).appendTo(tableRow);
                    // $('<td>').text(ui.item.serialNumber).appendTo(tableRow);
                    // var quantityInput = $('<input>').attr('type', 'number').attr('max', 1).val(1);
                    // $('<td>').append(quantityInput).appendTo(tableRow);
                    // var buttonCell = $('<td>');
                    // var addButton = $('<button class="btn btn-success">').text('Add').appendTo(buttonCell);
                    // var cancelButton = $('<button class="btn btn-danger">').text('Cancel').appendTo(buttonCell);
                    // tableRow.append(buttonCell);
                    // tableRow.appendTo('#orderUser tbody');

                    // quantityInput.on('input', function() {
                    //     var enteredValue = parseInt($(this).val());
                    //     var maxValue = parseInt($(this).attr('max'));
                    //     if (enteredValue > maxValue) {  
                    //     Swal.fire(
                    //         'Quantity cannot exceed ' + maxValue,
                    //         'Try input ' + maxValue + ' or below.',
                    //         'question'
                    //     );
                    //     $(this).val(maxValue);
                    //     }
                    // });

                    // cancelButton.on('click', function() {

                    //     tableRow.remove();
                    //     Swal.fire({

                    //         icon: 'success',
                    //         title: 'Successfuly Removed',
                    //         showConfirmButton: false,
                    //         timer: 1500
                    //         });

                    // });

                    // addButton.on('click', function() {

                    //     console.log('Add button clicked');
                    //     var userId = $(this).closest('tr').find('td:nth-child(1)').text();
                    //     var itemId = $(this).closest('tr').find('td:nth-child(2)').text();
                    //     var orderId = $(this).closest('tr').find('td:nth-child(3)').text();
                    //     var brand = $(this).closest('tr').find('td:nth-child(4)').text();
                    //     var model = $(this).closest('tr').find('td:nth-child(5)').text();
                    //     var description = $(this).closest('tr').find('td:nth-child(6)').text();
                    //     var serial = $(this).closest('tr').find('td:nth-child(7)').text();
                    //     var quantity = $(this).closest('tr').find('input').val();


                    //     var requestData = {
                    //     userId: userId,
                    //     itemId: itemId,
                    //     orderId: orderId,
                    //     brand: brand,
                    //     model: model,
                    //     description: description,
                    //     serial: serial,
                    //     quantity: quantity
                    //     };

                    //     $.ajax({
                    //     url: "{{ route('userNewOrder') }}",
                    //     type: 'POST',
                    //     headers: {
                    //         'X-CSRF-TOKEN': csrfToken
                    //     },
                    //     data: requestData,
                    //     success: function(response) {
                    //         if(response.success){
                    //             tableRow.remove();
                    //             Swal.fire({
                    //             position: 'top-end',
                    //             icon: 'success',
                    //             title: 'Successfully Added',
                    //             showConfirmButton: false,
                    //             timer: 1500
                    //             });
                    //         }


                    //     },
                    //     error: function(xhr) {
                    //         // Handle the error
                    //         console.log(xhr.responseText);
                    //     }
                    //     });
                    // });


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
                                    'Date Not Provided',
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

    function updateItemQuantity(quantity, rowIndex) {
        var itemId = $('#item_id_' + rowIndex).val();
        var orderItemId = $('#order_item_id_' + rowIndex).val();

        console.log(itemId);
        console.log(quantity);

        $.ajax({
            url: "{{ route('updateQuantity') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                quantity: quantity,
                itemId: itemId,
                orderItemId: orderItemId,
            },
            success: function(response) {

                console.log(response);
                //   $('#quantity_' + rowIndex).text(quantity);
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
            }
        });
    }

    function borrowUpdateItemQuantity(quantity, rowIndex) {
        var itemId = $('#borrow_item_id_' + rowIndex).val();
        var orderItemId = $('#borrow_order_item_id_' + rowIndex).val();

        console.log(itemId);
        console.log(quantity);

        $.ajax({
            url: "{{ route('updateQuantity') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                quantity: quantity,
                itemId: itemId,
                orderItemId: orderItemId,
            },
            success: function(response) {

                console.log(response);

            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
            }
        });
    }

