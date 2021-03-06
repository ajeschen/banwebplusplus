<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-115012867-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-115012867-1');
    </script>


    <link rel="shortcut icon" href="plusplus.ico"/>
    <title>A Better Banweb Scheduler</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <!-- Icon Set -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" />
    
    <!-- Calendar CSS -->
    <link rel="stylesheet" href="cal.css" />

  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">BanWeb++</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">

          <li class="nav-item signedInOnly">
            <a class="nav-link" href="#" onclick="clearCalendar('new')">New Schedule</a>
          </li>
          <li class="nav-item signedInOnly">
            <a class="nav-link" href="#" data-toggle='modal' data-target='.openScheduleBox'>Open Schedule</a>
          </li>
          <li class="nav-item signedInOnly">
            <a class="nav-link" href="#" onclick="saveAs()">Save Schedule As...</a>
          </li>
          <li class="nav-item signedInOnly">
            <a id="calendarTest" class="nav-link" href="#">Add Schedule to Google Calendar</a>
          </li>
          <!--
          <li class="nav-item dropdown signedInOnly">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Schedule
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">New</a>
              <a class="dropdown-item" href="#">Open</a>
              <a class="dropdown-item" href="#">Save</a>
              <a class="dropdown-item" href="#">Add to Google Calendar</a>
            </div>
          </li>
        -->

        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li>
            <a class="nav-link nav-link-right" id='signInButton' href="#">Sign In</a>
          </li>
          <li class="nav-item dropdown signedInOnly">
            <a class="nav-link dropdown-toggle signInDropdown" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Signing In...
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#" data-toggle='modal' data-target='.completedCoursesBox'>Add courses taken</a>
              <a class="dropdown-item" href="#">Email alerts</a>
              <a class="dropdown-item" href="#" id='signOutButton'>Sign Out</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <div class='container-fluid mt-5'>

      <div class="alert alert-danger" role="alert" style='display:none;'></div>
      <div class="alert alert-success" role="alert" style='display:none;'></div>

      <div class="row">
        <div class='col-4'>
          <p>Search for courses to add:</p>
          <div class='form-row'>
            <div class='col-9'>
              <input type='text' id='searchBox' class='form-control' placeholder='Search by course number, course name, or instructor'/>
            </div>
            <div class='col-3'>
              <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="semester">
                <!-- values filled with javascript on page load -->
              </select>
            </div>
          </div>
          <ul id='searchResults' class='list-group' style='max-height:500px;overflow:auto;'></ul>
        </div>

        <div class='col-xl'>
          <p id='currentScheduleName'></p>
          <table id='calendar'>
            <colgroup>
              <col span='1' class='timeLabelCol' />
            </colgroup>
            <tr class='labels'>
              <th class='timeLabel'></th>
              <th>Monday</th>
              <th>Tuesday</th>
              <th>Wednesday</th>
              <th>Thursday</th>
              <th>Friday</th>
            </tr>

              <?php
                $timeLabels = ['6am', '7am', '8am', '9am', '10am', '11am', '12pm', '1pm', '2pm', '3pm', '4pm', '5pm', '6pm', '7pm', '8pm', '9pm', '10pm'];
                $timeList = ['0600am', '0630am', '0700am', '0730am', '0800am', '0830am', '0900am', '0930am', '1000am', '1030am', 
                             '1100am', '1130am', '1200pm', '1230pm', '0100pm', '0130pm', '0200pm', '0230pm', '0300pm', '0330pm', 
                             '0400pm', '0430pm', '0500pm', '0530pm', '0600pm', '0630pm', '0700pm', '0730pm', '0800pm', '0830pm', 
                             '0900pm', '0930pm', '1000pm', '1030pm'];
                $days = ['M', 'T', 'W', 'R', 'F'];
                foreach($timeLabels as $i => $time) {
                  echo "<tr>";
                  echo "<td class='timeLabel'><div class='timeLabelText'>$time</div></td>";
                  $timeListIndex = $i*2;
                  $topTime = $timeList[$timeListIndex];
                  $bottomTime = $timeList[$timeListIndex + 1];
                  foreach($days as $day) {
                    echo "<td class='normal $day-$topTime'>";
                      echo "<div class='tdWrapper'>";
                      echo "<div class='courseFiller top $day-$topTime'></div>";
                      echo "</div>";
                    echo "</td>";
                  }
                  echo "</tr>";
                }
                //echo "<tr><td class='timeLabel'><div class='timeLabelText'>11pm</div></td></tr>";
              ?>
            </tr>
          </table>
        </div>

        <div class='col-2'>
          <p>Courses Added:</p>
          <b><span id='classCount'>0</span> Classes | <span id='creditCount'>0</span> Credits</b><br/>
          <ul id='coursesAddedList' class='list-group' style='max-height:500px;overflow:auto;'></ul>
        </div>

      </div>
    </div>

    <div class='modal fade courseInfoBox' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" area-hidden="true">
      <div class='modal-dialog modal-lg'>
        <div class='modal-content p-2 text-center'></div>
      </div>
    </div>

    <div class='modal fade completedCoursesBox' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" area-hidden="true">
      <div class='modal-dialog modal-lg'>
        <div class='modal-content p-2 text-center'></div>
      </div>
    </div>

    <div class='modal fade openScheduleBox' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" area-hidden="true">
      <div class='modal-dialog modal-lg'>
        <div class='modal-content p-2 text-center'></div>
      </div>
    </div>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>

    <!-- Custom JS -->
    <script src="calendar.js"></script> <!-- contains global vars, include first -->
    <script src="googleCal.js"></script>
    <script src="completedCourses.js"></script>
    <script src="search.js"></script>
    <script src="saveLoad.js"></script>



    <!-- Google Login API JS -->
    <script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>


    <!-- Start of StatCounter Code for Default Guide -->
    <script type="text/javascript">
    var sc_project=11617823; 
    var sc_invisible=1; 
    var sc_security="c739cb3e"; 
    var scJsHost = (("https:" == document.location.protocol) ?
    "https://secure." : "http://www.");
    </script>
    <script type="text/javascript"
    src="https://www.statcounter.com/counter/counter.js"
    async></script>
    <noscript><div class="statcounter"><a title="website
    statistics" href="http://statcounter.com/"
    target="_blank"><img class="statcounter"
    src="//c.statcounter.com/11617823/0/c739cb3e/1/"
    alt="website statistics"></a></div></noscript>
    <!-- End of StatCounter Code for Default Guide -->
  </body>
</html>
