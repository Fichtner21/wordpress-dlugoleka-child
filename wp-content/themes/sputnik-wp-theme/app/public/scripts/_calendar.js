import { Calendar, formatDate } from "@fullcalendar/core";
import plLocale from "@fullcalendar/core/locales/pl";

import dayGridPlugin from "@fullcalendar/daygrid";

// ! allEvents variable is from WordPress passed by php

document.addEventListener("DOMContentLoaded", function () {
  const calendarEl = document.getElementById("js-calendar");
  const allEventsArr = allEvents.allEvents;
  const calendarEvents = [];

  // console.log(allEventsArr);

  allEventsArr.forEach((event) => {
    if (event.event_type.value == "oneday") {
      const dateTimeStart = `${event.event_type_data[0].date_start} ${event.event_type_data[0].event_times[0].time_start}`;
      const dateTimeEnd = `${event.event_type_data[0].date_start} ${event.event_type_data[0].event_times[0].time_end}`;

      const obj = {
        id: event.ID,
        title: event.post_title,
        url: event.event_permalink,
        type: event.event_type.label,
        start: dateTimeStart,
        end: dateTimeEnd,
        thumbnail: event.event_thumbnail,
        display: "auto",
      };

      calendarEvents.push(obj);
    }
  });

  const calendar = new Calendar(calendarEl, {
    locale: plLocale,
    plugins: [dayGridPlugin],
    events: calendarEvents,

    eventContent: function (element) {
      const eventItem = document.createElement("div");
      const eventContent = document.createElement("div");
      const title = document.createElement("span");
      const url = document.createElement("a");
      const type = document.createElement("span");
      const date = document.createElement("span");

      const thumbnail = document.createElement("a");

      if (element.event.extendedProps.thumbnail != false) {
        const img = document.createElement("img");

        thumbnail.className = "event__thumbnail";
        thumbnail.appendChild(img);

        img.src = element.event.extendedProps.thumbnail;
      }

      eventItem.className = "event";
      eventContent.className = "event__content";

      title.className = "event__title";
      url.className = "event__url";
      type.className = "event__type";
      date.className = "event__date";

      title.textContent = element.event.title;

      url.href = element.event.url;
      url.title = "Czytaj";
      url.textContent = "Czytaj";

      thumbnail.href = element.event.url;
      thumbnail.title = element.event.title;

      type.textContent = element.event.extendedProps.type;

      let fromatedDate = formatDate(element.event.start, {
        month: "numeric",
        year: "numeric",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        // timeZoneName: "short",
        // timeZone: "UTC",
        locale: "pl",
      });

      date.textContent = fromatedDate;

      eventContent.appendChild(title);
      // eventContent.appendChild(type);
      eventContent.appendChild(date);
      eventContent.appendChild(url);

      eventItem.appendChild(thumbnail);
      eventItem.appendChild(eventContent);

      let arrayOfDomNodes = [eventItem];

      return { domNodes: arrayOfDomNodes };
    },

    height: "auto",
  });

  calendar.render();

  const calendarDays = document.querySelectorAll(".fc-daygrid-day-top");
  const calendarResults = document.querySelector(".calendar-results");

  calendarDays.forEach((day) => {
    const eventsWrapper = day.nextSibling;
    const events = [...eventsWrapper.querySelectorAll(".fc-daygrid-event-harness")];
    const eventsCount = events.length;

    if (eventsCount > 0) {
      day.classList.add("has-events");

      const eventsCountElement = document.createElement("span");

      eventsCountElement.className = "events-count";
      eventsCountElement.textContent = eventsCount;

      day.appendChild(eventsCountElement);
    }

    day.addEventListener("click", function () {
      const eventsData = this.nextSibling.cloneNode(true);

      calendarResults.innerHTML = "";

      calendarResults.appendChild(eventsData);
    });
  });
});
