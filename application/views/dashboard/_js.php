<script>
var KTDashboard = function() {

    // Revenue Change.
    // Based on Morris plugin - http://morrisjs.github.io/morris.js/
    var outstandingchart = function() {
        if ($('#kt_chart_outstanding').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'kt_chart_outstanding',
            data: [{
                    label: "Today",
                    value: 20
                },
                {
                    label: "Yesterday",
                    value: 80
                }
            ],
            colors: [
                KTApp.getStateColor('danger'),
                KTApp.getStateColor('brand')
            ],
        });
    }

    var bookingchart = function() {
        if ($('#kt_chart_booking').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'kt_chart_booking',
            data: [{
                    label: "Today",
                    value: 40
                },
                {
                    label: "Yesterday",
                    value: 60
                }
            ],
            colors: [
                KTApp.getStateColor('danger'),
                KTApp.getStateColor('brand')
            ],
        });
    }

    var dpdchart = function() {
        if ($('#kt_chart_dpd').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'kt_chart_dpd',
            data: [{
                    label: "Today",
                    value: 30
                },
                {
                    label: "Yesterday",
                    value: 70
                }
            ],
            colors: [
                KTApp.getStateColor('danger'),
                KTApp.getStateColor('brand')
            ],
        });
    }

    var pencairanchart = function() {
        if ($('#kt_chart_pencairan').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'kt_chart_pencairan',
            data: [{
                    label: "Reguler",
                    value: 35
                },
                {
                    label: "Cicilan",
                    value: 65
                }
            ],
            colors: [
                KTApp.getStateColor('danger'),
                KTApp.getStateColor('brand')
            ],
        });
    }

    var pelunasanchart = function() {
        if ($('#kt_chart_pelunasan').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'kt_chart_pelunasan',
            data: [{
                    label: "Reguler",
                    value: 55
                },
                {
                    label: "Cicilan",
                    value: 55
                }
            ],
            colors: [
                KTApp.getStateColor('danger'),
                KTApp.getStateColor('brand')
            ],
        });
    }

    var profitchart = function() {
        if ($('#kt_chart_profit').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'kt_chart_profit',
            data: [{
                    label: "Pendapatan",
                    value: 65
                },
                {
                    label: "Pengeluaran",
                    value: 45
                }
            ],
            colors: [
                KTApp.getStateColor('danger'),
                KTApp.getStateColor('brand')
            ],
        });
    }

    return {
        // Init demos
        init: function() {
            // init charts
            outstandingchart(); 
            bookingchart(); 
            dpdchart(); 
            pencairanchart();
            pelunasanchart();
            profitchart();

            // demo loading
            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'});
            loading.show();

            setTimeout(function() {
                loading.hide();
            }, 3000);
        }
    };
}();

// Class initialization on page load
jQuery(document).ready(function() {
    KTDashboard.init();
});
</script>