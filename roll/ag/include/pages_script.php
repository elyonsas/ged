<script>
    $(document).ready(function() {
        // Lorsqu'on click sur #kt_app_sidebar_toggle
        $(document).on('click', '#kt_app_sidebar_toggle', function() {
            sidebar_minimize = $('body').data('kt-app-sidebar-minimize');
            if (sidebar_minimize == 'on') {
                $.ajax({
                    url: "roll/ag/fetch.php",
                    method: "POST",
                    data: {
                        action: 'sidebar_minimize',
                        sidebar_minimize: 'on'
                    },
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data.message);
                    }
                });
            } else {
                $.ajax({
                    url: "roll/ag/fetch.php",
                    method: "POST",
                    data: {
                        action: 'sidebar_minimize',
                        sidebar_minimize: 'off'
                    },
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data.message);
                    }
                });
            }
        });
    });
</script>