<script>
        "use strict";
        const config = {
            baseURL: "{{ url('/') }}",
            lang: "ar",
            alertActionTitle: "{{ \App\CPU\Helpers::translate('Are you sure?', 'user') }}",
            alertActionText: "{{ \App\CPU\Helpers::translate('Confirm that you want do this action', 'user') }}",
            alertActionConfirmButton: "{{ \App\CPU\Helpers::translate('Confirm', 'user') }}",
            alertActionCancelButton: "{{ \App\CPU\Helpers::translate('Cancel', 'user') }}",
            ticketsMaxFilesError: "{{ \App\CPU\Helpers::translate('Max 5 files can be uploaded', 'tickets') }}",
        };
</script>
<script>
    "use strict";
    let configObjects = JSON.stringify(config),
        getConfig = JSON.parse(configObjects);
</script>
