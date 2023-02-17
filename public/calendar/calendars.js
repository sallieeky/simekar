"use strict";

/* eslint-disable require-jsdoc, no-unused-vars */

var CalendarList = [];

function CalendarInfo() {
    this.id = null;
    this.name = null;
    this.category = null;
    this.checked = true;
    this.color = null;
    this.bgColor = null;
    this.borderColor = null;
    this.dragBgColor = null;
}

function addCalendar(calendar) {
    CalendarList.push(calendar);
}

function findCalendar(id) {
    var found;

    CalendarList.forEach(function (calendar) {
        if (calendar.id === id) {
            found = calendar;
        }
    });

    return found || CalendarList[0];
}

function hexToRGBA(hex) {
    var radix = 16;
    var r = parseInt(hex.slice(1, 3), radix),
        g = parseInt(hex.slice(3, 5), radix),
        b = parseInt(hex.slice(5, 7), radix),
        a = parseInt(hex.slice(7, 9), radix) / 255 || 1;
    var rgba = "rgba(" + r + ", " + g + ", " + b + ", " + a + ")";

    return rgba;
}

(function () {
    var calendar;
    var id = 0;

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = "Masa Berlaku Pajak";
    calendar.category = "masa_pajak";
    calendar.color = "#ffffff";
    calendar.bgColor = "#24695c";
    calendar.dragBgColor = "#24695c";
    calendar.borderColor = "#24695c";
    addCalendar(calendar);

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = "Masa Berlaku STNK";
    calendar.category = "masa_stnk";
    calendar.color = "#ffffff";
    calendar.bgColor = "#ba895d";
    calendar.dragBgColor = "#ba895d";
    calendar.borderColor = "#ba895d";
    addCalendar(calendar);

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = "Masa Berlaku Asuransi";
    calendar.category = "masa_asuransi";
    calendar.color = "#ffffff";
    calendar.bgColor = "#ff5583";
    calendar.dragBgColor = "#ff5583";
    calendar.borderColor = "#ff5583";
    addCalendar(calendar);
})();
