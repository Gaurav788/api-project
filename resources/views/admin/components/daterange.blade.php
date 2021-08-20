<script>
    jQuery(document).ready(function(){  

        var today = new Date();
        jQuery("#daterange_filter").daterangepicker({
            format: 'YYYY-MM-DD',
            autoclose:true,
            maxDate: new Date(),
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        jQuery('#daterange_filter').on('apply.daterangepicker', function(ev, picker) {
            jQuery(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
        });
        jQuery('#daterange_filter').on('cancel.daterangepicker', function(ev, picker) {
            jQuery(this).val('');
        });
    }); 
</script>