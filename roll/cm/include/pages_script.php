<script>
    $(document).ready(function() {
        // Lorsqu'on click sur #kt_app_sidebar_toggle
        $(document).on('click', '#kt_app_sidebar_toggle', function() {
            sidebar_minimize = $('body').data('kt-app-sidebar-minimize');
            if (sidebar_minimize == 'on') {
                $.ajax({
                    url: "roll/cm/fetch.php",
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
                    url: "roll/cm/fetch.php",
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

        // Lorsqu'on click sur #tab_alert_notif ou #header_btn_notif
        $(document).on('click', '#tab_alert_notif,#header_btn_notif', function() {
            $.ajax({
                url: "roll/cm/fetch.php",
                method: "POST",
                data: {
                    action: 'alert_notif_read'
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data.message);
                }
            });
        });

        // Lorsqu'on click sur #tab_log_notif
        $(document).on('click', '#tab_log_notif', function() {
            $.ajax({
                url: "roll/cm/fetch.php",
                method: "POST",
                data: {
                    action: 'log_notif_read'
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data.message);
                }
            });
        });
    });
</script>