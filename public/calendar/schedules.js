"use strict";

/*eslint-disable*/

var ScheduleList = [];

var SCHEDULE_CATEGORY = ["milestone", "task"];

function ScheduleInfo() {
    this.id = null;
    this.calendarId = null;

    this.title = null;
    this.body = null;
    this.isAllday = false;
    this.start = null;
    this.end = null;
    this.category = "";
    this.dueDateClass = "";

    this.color = null;
    this.bgColor = null;
    this.dragBgColor = null;
    this.borderColor = null;
    this.customStyle = "";

    this.isFocused = false;
    this.isPending = false;
    this.isVisible = true;
    this.isReadOnly = false;
    this.goingDuration = 0;
    this.comingDuration = 0;
    this.recurrenceRule = "";
    this.state = "";

    this.raw = {
        memo: "",
        hasToOrCc: false,
        hasRecurrenceRule: false,
        location: null,
        class: "public", // or 'private'
        creator: {
            name: "",
            avatar: "",
            company: "",
            email: "",
            phone: "",
        },
    };
}

function generateTime(schedule, renderStart, renderEnd) {
    var startDate = moment(renderStart.getTime());
    var endDate = moment(renderEnd.getTime());
    var diffDate = endDate.diff(startDate, "days");

    schedule.isAllday = true;
    schedule.category = "allday";

    startDate.add(chance.integer({ min: 0, max: diffDate }), "days");
    startDate.hours(chance.integer({ min: 0, max: 23 }));
    startDate.minutes(chance.bool() ? 0 : 30);
    schedule.start = startDate.toDate();

    endDate = moment(startDate);
    if (schedule.isAllday) {
        endDate.add(chance.integer({ min: 0, max: 3 }), "days");
    }
    schedule.end = schedule.start;
}

function generateNames() {
    var names = [];
    var i = 0;
    var length = chance.integer({ min: 1, max: 10 });

    for (; i < length; i += 1) {
        names.push(chance.name());
    }

    return names;
}

function generateRandomSchedule(calendar, renderStart, renderEnd, jsonData) {
    jsonData.forEach((item) => {
        var schedule = new ScheduleInfo();
        var categorySchedule = calendar.category;
        var time = new Date(item[categorySchedule]);
        time.setHours(0, 0, 0, 0);

        schedule.isAllday = true;
        schedule.category = "allday";
        schedule.start = time;
        schedule.end = schedule.start;

        schedule.id = chance.guid();
        schedule.calendarId = calendar.id;

        schedule.title =
            item.kendaraan.no_polisi +
            " - " +
            item.kendaraan.merk +
            " (" +
            item.kendaraan.tipe +
            ")";
        schedule.isReadOnly = true;
        schedule.isPrivate = false;
        schedule.color = calendar.color;
        schedule.bgColor = calendar.bgColor;
        schedule.dragBgColor = calendar.dragBgColor;
        schedule.borderColor = calendar.borderColor;

        schedule.location = "Kantor Jasa Raharja";
        schedule.attendees = ["Admin"];
        schedule.state = "Busy";

        ScheduleList.push(schedule);
    });
}

async function generateSchedule(viewName, renderStart, renderEnd) {
    ScheduleList = [];
    console.log("render start : " + renderStart);
    console.log("render end : " + renderEnd);

    await CalendarList.forEach(async function (calendar) {
        var data = await fetch(
            urlCalendarApi +
                "?timestart=" +
                renderStart +
                "&timeend=" +
                renderEnd +
                "&category=" +
                calendar.category
        );
        var jsonData = await data.json();
        generateRandomSchedule(calendar, renderStart, renderEnd, jsonData);
        if (CalendarList.indexOf(calendar) === CalendarList.length - 1) {
            cal.createSchedules(ScheduleList);
        }
    });
}
