import { Calendar } from "@fullcalendar/core";
import plLocale from "@fullcalendar/core/locales/pl";
import dayGridPlugin from "@fullcalendar/daygrid";

// ! allEvents variable is from WordPress passed by php

document.addEventListener("DOMContentLoaded", function () {
  const calendarEl = document.getElementById("js-calendar");
  const allEventsArr = allEvents.allEvents;
  const calendarEvents = [];

  allEventsArr.forEach((event) => {
    console.log(event.event_type.value);
    if (event.event_type.value == "oneday") {
      const obj = {
        id: event.ID,
        title: event.post_title,
        type: event.event_type.label,
        start: event.event_type_data[0].date_start,
        // display: "background",
      };

      calendarEvents.push(obj);
    }
  });

  const calendar = new Calendar(calendarEl, {
    locale: plLocale,
    plugins: [dayGridPlugin],
    events: calendarEvents,
    height: "auto",
  });

  calendar.render();
});
