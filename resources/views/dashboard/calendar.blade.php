<!DOCTYPE html>
<html lang="en">
<head>
	<base href="/">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Projects</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
    <link rel="stylesheet" href="css/calendar.css" />
    <style>
       #loading {
          display: none;
          position: absolute;
          top: 50px;
          right: 10px;
        }

        #calendar {
          max-width: 1100px;
          margin: 0 auto;
          margin-top: 50px;
        }
    </style>
</head>
<body>

  @include('dashboard.partials.header')
  <div class="container-fluid">
   
    <section class="projects_tabs">
      <div class="container">
        <ul>
          <li class="tab active"><a href="/projects/open">Projects</a></li>
          <li class="tab"><a href="/project-templates/open">Projects Templates</a></li>
          <li class="tab"><a href="/takeoff-templates/open">Take Off Templates</a></li>
        </ul>
      </div>
    </section>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
          {{-- Sidebar Start--}}
          @include('dashboard.partials.projects-sidebar')
          {{-- Sidebar End--}}
          <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg navbar-light bg-default myprojects--nav">
              <a class="navbar-brand nav--main--item" href="javacript::void(0)">Calendar</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            
            </nav>

            <div id='loading'>loading...</div>

            <div class="mb-4" id='calendar'></div>
          
          </div>
        </div>
      </div>
    </div>
  </div>
  


  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script type="text/javascript" src="js/calendar.js"></script>
  <script src="js/ajax.js"></script>
  <script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {

        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,listYear'
        },

        displayEventTime: false, // don't show the time column in list view

        // THIS KEY WON'T WORK IN PRODUCTION!!!
        // To make your own Google API key, follow the directions here:
        // http://fullcalendar.io/docs/google_calendar/
        // https://developers.google.com/calendar/quickstart/js

        googleCalendarApiKey: 'AIzaSyCBE3LXkwXKWT9o6XcpeUi-qpoT4w2f690',

        // US Holidays
        // events: 'en.usa#holiday@group.v.calendar.google.com',
        // events: 'classroom117812489943577687528@group.calendar.google.com',
        
        eventClick: function(arg) {
          // opens events in a popup window
          window.open(arg.event.url, 'google-calendar-event', 'width=700,height=600');

          arg.jsEvent.preventDefault() // don't navigate in main tab
        },

        loading: function(bool) {
          document.getElementById('loading').style.display =
            bool ? 'block' : 'none';
        }

      });


      calendar.render();

    });

  </script> 
</body>
</html>
