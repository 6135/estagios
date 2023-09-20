var MyDashboard = function() {
    var init = function() {
        //alert('init');
    };

    var calendarInit = function() {
        if ($('#m_calendar').length === 0) {
            return;
        }

        var todayDate = moment().startOf('day');
        var YM = todayDate.format('YYYY-MM');
        var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
        var TODAY = todayDate.format('YYYY-MM-DD');
        var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

        $('#m_calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            navLinks: true,
            defaultDate: moment('2017-09-15'),
            events: '/dashboard/getEvents/',
/*
            eventRender: function(event, element) {
                if (element.hasClass('fc-day-grid-event')) {
                    element.data('content', event.description);
                    element.data('placement', 'top');
                    mApp.initPopover(element);
                } else if (element.hasClass('fc-time-grid-event')) {
                    element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>');
                } else if (element.find('.fc-list-item-title').lenght !== 0) {
                    element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>');
                }
            }*/
        });
    }

    var calendarInit2 = function() {
        if ($('#m_calendar').length === 0) {
            return;
        }
        $('#m_calendar').fullCalendar({
                events: '/dashboard/getEvents/',
                eventClick: function (calEvent, jsEvent, view) {
                    //alert('Event:' + calEvent.title);
                    if(calEvent.url){
                        window.open(calEvent.url);
                        return false;
                    }
                }

            /*events: {
                url: '/dashboard/getEvents/',
                type: 'POST'
            }*/
        });
    }

    return {
        init: function() {
            init();
            calendarInit2();
        }
    };
}();


jQuery(document).ready(function() {
    MyDashboard.init();
});