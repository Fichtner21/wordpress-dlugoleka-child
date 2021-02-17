import { Calendar, formatDate, formatRange } from "@fullcalendar/core";
import plLocale from "@fullcalendar/core/locales/pl";

import dayGridPlugin from "@fullcalendar/daygrid";

// ! allEvents variable is from WordPress passed by php

document.addEventListener("DOMContentLoaded", function () {
  // Returns an array of dates between the two dates
  const getDates = function (startDate, endDate) {
    const dates = [];

    let currentDate = startDate;

    function addDays(days) {
      const date = new Date(this.valueOf());

      date.setDate(date.getDate() + days);

      return date;
    }

    while (currentDate <= endDate) {
      dates.push(currentDate);

      currentDate = addDays.call(currentDate, 1);
    }

    return dates;
  };

  function formatDateCustom(date) {
    let d = new Date(date),
      month = "" + (d.getMonth() + 1),
      day = "" + d.getDate(),
      year = d.getFullYear(),
      hours = d.getHours(),
      minutes = d.getMinutes(),
      time,
      formatedDate;

    if (hours.toString().length < 2) hours = "0" + hours;

    if (minutes.toString().length < 2) minutes = "0" + minutes;

    time = `${hours}:${minutes}`;

    if (month.length < 2) month = "0" + month;

    if (day.length < 2) day = "0" + day;

    formatedDate = [year, month, day].join("-");

    formatedDate = `${formatedDate} ${time}`;

    return formatedDate;
  }

  const calendarEl = document.getElementById("js-calendar");
  const allEventsArr = allEvents.allEvents;
  const calendarEvents = [];

  let dateTimeStart, dateTimeEnd, obj;

  allEventsArr.forEach((event) => {
    if (event.event_type.value == "oneday") {
      if (event.event_type_data[0].event_times) {
        dateTimeStart = `${event.event_type_data[0].date_start} ${event.event_type_data[0].event_times[0].time_start}`;
        dateTimeEnd = `${event.event_type_data[0].date_start} ${event.event_type_data[0].event_times[0].time_end}`;
      } else {
        dateTimeStart = event.event_type_data[0].date_start;
        dateTimeEnd = event.event_type_data[0].date_start;
      }

      obj = {
        id: event.ID,
        title: event.post_title,
        url: event.event_permalink,
        type: event.event_type.label,
        localization: event.event_type_data[0].localization,
        latitude: event.event_type_data[0].latitude,
        longitude: event.event_type_data[0].longitude,
        start: dateTimeStart,
        end: dateTimeEnd,
        thumbnail: event.event_thumbnail,
        display: "auto",
      };

      calendarEvents.push(obj);
    }

    if (event.event_type.value == "multiple") {
      const eventDates = event.event_type_data;

      eventDates.forEach((date) => {
        if (date.event_times) {
          dateTimeStart = `${date.date_start} ${date.event_times[0].time_start}`;
          dateTimeEnd = `${date.date_start} ${date.event_times[0].time_end}`;
        } else {
          dateTimeStart = date.date_start;
          dateTimeEnd = date.date_start;
        }

        obj = {
          id: event.ID,
          title: event.post_title,
          url: event.event_permalink,
          type: event.event_type.label,
          localization: event.event_type_data[0].localization,
          latitude: event.event_type_data[0].latitude,
          longitude: event.event_type_data[0].longitude,
          start: dateTimeStart,
          end: dateTimeEnd,
          thumbnail: event.event_thumbnail,
          display: "auto",
        };

        calendarEvents.push(obj);
      });
    }

    if (event.event_type.value == "endless") {
      let dateStartFormated, dateEndFormated;

      if (event.event_type_data[0].event_times) {
        dateStartFormated = new Date(
          `${event.event_type_data[0].date_start}, ${event.event_type_data[0].event_times[0].time_start}`
        );
        dateEndFormated = new Date(
          `${event.event_type_data[0].date_end}, ${event.event_type_data[0].event_times[0].time_end}`
        );
      } else {
        dateStartFormated = new Date(event.event_type_data[0].date_start);
        dateEndFormated = new Date(event.event_type_data[0].date_end);
      }

      const daysBetween = getDates(dateStartFormated, dateEndFormated);

      daysBetween.forEach(function (date, index, array) {
        const startDate = formatDateCustom(date).replace(",", "");
        const endDate = formatDateCustom(dateEndFormated).replace(",", "");

        obj = {
          id: event.ID,
          title: event.post_title,
          url: event.event_permalink,
          type: event.event_type.label,
          localization: event.event_type_data[0].localization,
          latitude: event.event_type_data[0].latitude,
          longitude: event.event_type_data[0].longitude,
          start: startDate,
          end: endDate,
          thumbnail: event.event_thumbnail,
          display: "auto",
        };

        calendarEvents.push(obj);
      });
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
      const localization = document.createElement("span");

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
      localization.className = "event__localization";

      title.textContent = element.event.title;

      localization.textContent = element.event.extendedProps.localization;

      url.href = element.event.url;
      url.title = "Czytaj";
      url.textContent = "Czytaj";

      thumbnail.href = element.event.url;
      thumbnail.title = element.event.title;

      type.textContent = element.event.extendedProps.type;

      let formatedDate = formatDate(element.event.start, {
        month: "numeric",
        year: "numeric",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        locale: "pl",
      });

      formatedDate = formatRange(element.event.start, element.event.end, {
        month: "numeric",
        year: "numeric",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        to: " - ",
        locale: "pl",
      });

      date.textContent = formatedDate;

      eventContent.appendChild(title);
      eventContent.appendChild(localization);
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

  function displayCalendarEvents() {
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
  }

  window.addEventListener("load", displayCalendarEvents);

  document.querySelectorAll(".fc-button").forEach((button) => button.addEventListener("click", displayCalendarEvents));
});
