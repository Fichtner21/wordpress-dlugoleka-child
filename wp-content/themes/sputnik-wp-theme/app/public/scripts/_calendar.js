import { Calendar } from "@fullcalendar/core";
import plLocale from "@fullcalendar/core/locales/pl";

import dayGridPlugin from "@fullcalendar/daygrid";

// ! allEvents variable is from WordPress passed by php

document.addEventListener("DOMContentLoaded", function () {
  const calendarEl = document.getElementById("js-calendar");
  const allEventsArr = allEvents.allEvents;
  const calendarEvents = [];

  allEventsArr.forEach((event) => {
    if (event.event_type.value == "oneday") {
      const obj = {
        id: event.ID,
        title: event.post_title,
        url: event.event_permalink,
        type: event.event_type.label,
        start: event.event_type_data[0].date_start,
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
      const url = document.createElement("span");
      const type = document.createElement("span");
      const date = document.createElement("span");

      const thumbnail = document.createElement("div");

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
      url.textContent = element.event.url;
      type.textContent = element.event.extendedProps.type;
      date.textContent = element.event.start;

      eventContent.appendChild(title);
      eventContent.appendChild(url);
      eventContent.appendChild(type);
      eventContent.appendChild(date);

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
