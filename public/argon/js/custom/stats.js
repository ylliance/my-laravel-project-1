function getTodayRealtimeStatsCount() {
    $.ajax({
        url: '/transactions/today',
        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
        type: 'get',
        success: function(res) {
            if ($('#sidebar-badge-bills').length > 0) {
                $('#sidebar-badge-bills').text(res.pendingBills);
            }
            if ($('#sidebar-badge-refunds').length > 0) {
                $('#sidebar-badge-refunds').text(res.pendingRefunds);
            }
        }
    });
}

$(document).ready(function() {
    // realtime stats data
    if ( ($('#sidebar-badge-bills').length > 0) || ($('#sidebar-badge-refunds').length > 0) ) {
        getTodayRealtimeStatsCount();
        setInterval(getTodayRealtimeStatsCount, 60000);
    }
})