{{-- 
<script src="plugins/jquery/jquery.min.js"></script> --}}
{{-- <!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
{{-- <!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>  --}}
{{-- 
<script>
    $(function() {
        // Get the current page's URL
        var url = window.location.href;

        // Loop through each navigation link
        $('a.nav-link').each(function() {
            // Check if the link's href matches the current URL
            if ($(this).attr('href') == url) {
                // Add the 'active' class to the link
                $(this).addClass('active');

                // Keep the parent 'ul' element open
                $(this).parents('.nav-item').addClass('menu-open');

                // Check if the link is a child of the Borrowing dropdown
                if ($(this).parents('.nav-treeview').length > 0) {
                    // Add the 'active' class to the Borrowing dropdown
                    $('.nav-item > a.nav-link').filter(function() {
                        return $(this).text().trim() == 'Borrowing';
                    }).addClass('active');
                }
            }
        });

        // Show/hide dropdown on click
        $('a.nav-link.dropdown-toggle').click(function() {
            $(this).next('.nav-treeview').toggleClass('show');
        });
    }); --}}
{{-- </script> --}}
