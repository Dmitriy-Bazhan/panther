import template from './template.html';
import './style.css';

// Calendar data
const _daysInMonths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
const _weekdayLabels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
const _weekdayLength = 3;
const _weekdayCasing = 'title';
const _monthLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
const _monthLength = 0;
const _monthCasing = 'title';

// Helper function for label transformation
const _transformLabel = (label, length, casing) => {
    label = length <= 0 ? label : label.substring(0, length);
    if (casing.toLowerCase() === 'lower') return label.toLowerCase();
    if (casing.toLowerCase() === 'upper') return label.toUpperCase();
    return label;
};

// Today's data
const _today = new Date();
const _todayComps = {
    year: _today.getFullYear(),
    month: _today.getMonth() + 1,
    day: _today.getDate(),
};

export default {
    name: "Overview",
    template: template,
    props: ['user', 'data'],
    data() {
        return {
            month: _todayComps.month,
            year: _todayComps.year,
            day: _todayComps.day,
            checkDate: null,
            neededDate: null,
            time_calendar: [],
        }
    },
    created() {
        this.newNeededDate();
    },
    computed: {
        monthIndex() {
            return this.month - 1;
        },
        // State referenced by header (no dependencies yet...)
        months() {
            return _monthLabels.map((ml, i) => ({
                label: _transformLabel(ml, _monthLength, _monthCasing),
                number: i + 1,
            }));
        },
        // State for weekday header (no dependencies yet...)
        weekdays() {
            return _weekdayLabels.map((wl, i) => {
                return {
                    label: _transformLabel(wl, _weekdayLength, _weekdayCasing),
                    number: i + 1,
                };
            });
        },
        // State for calendar header
        header() {
            const month = this.months[this.monthIndex];
            return {
                month,
                year: this.year.toString(),
                shortYear: this.year.toString().substring(2, 4),
                label: month.label + ' ' + this.year,
            };
        },
        // Returns number for first weekday (1-7), starting from Sunday
        firstWeekdayInMonth() {
            return new Date(this.year, this.monthIndex, 1).getDay() + 1;
        },
        // Returns number of days in the current month
        daysInMonth() {
            // Check for February in a leap year
            const isFebruary = this.month === 2;
            const isLeapYear = (this.year % 4 == 0 && this.year % 100 != 0) || this.year % 400 == 0;
            if (isFebruary && isLeapYear) return 29;
            // ...Just a normal month
            return _daysInMonths[this.monthIndex];
        },
        weeks() {
            const weeks = [];
            let monthStarted = false, monthEnded = false;
            let monthDay = 0;
            // Cycle through each week of the month, up to 6 total
            for (let w = 1; w <= 6 && !monthEnded; w++) {
                // Cycle through each weekday
                const week = [];
                for (let d = 1; d <= 7; d++) {
                    // We need to know when to start counting actual month days
                    if (!monthStarted && d >= this.firstWeekdayInMonth) {
                        // Initialize day counter
                        monthDay = 1;
                        // ...and flag we're tracking actual month days
                        monthStarted = true;
                        // Still in the middle of the month (hasn't ended yet)
                    } else if (monthStarted && !monthEnded) {
                        // Increment the day counter
                        monthDay += 1;
                    }
                    // Append day info for the current week
                    // Note: this might or might not be an actual month day
                    //  We don't know how the UI wants to display various days,
                    //  so we'll supply all the data we can

                    let neededDay = String(monthDay).length === 1 ? neededDay = '0' + monthDay : monthDay;
                    let neededMonth = String(this.month).length === 1 ? neededMonth = '0' + this.month : this.month;
                    week.push({
                        label: monthDay ? monthDay.toString() : '',
                        number: monthDay,
                        weekdayNumber: d,
                        weekNumber: w,
                        beforeMonth: !monthStarted,
                        afterMonth: monthEnded,
                        inMonth: monthStarted && !monthEnded,
                        isToday: monthDay === _todayComps.day && this.month === _todayComps.month && this.year === _todayComps.year,
                        isFirstDay: monthDay === 1,
                        isLastDay: monthDay === this.daysInMonth,
                        neededDate: this.year + '-' + neededMonth + '-' + neededDay,
                    });

                    // Trigger end of month on the last day
                    if (monthStarted && !monthEnded && monthDay >= this.daysInMonth) {
                        monthDay = 0;
                        monthEnded = true;
                    }
                }
                // Append week info for the month
                weeks.push(week);
            }
            return weeks;
        },
    },
    methods: {
        formatDate(date) {
            let a = String(date).split('T');
            return a[0] + ' ' + String(a[1].split('.')[0]);
        },
        selectDate(current_day) {
            this.checkDate = this.year + '-' + this.month + '-' + current_day.number;
        },
        moveThisMonth() {
            this.month = _todayComps.month;
            this.year = _todayComps.year;
            this.newNeededDate();
        },
        moveNextMonth() {
            if (this.month < 12) {
                this.month++;
            } else {
                this.month = 1;
                this.year++;
            }
            this.newNeededDate();
        },
        movePreviousMonth() {
            if (this.month > 1) {
                this.month--;
            } else {
                this.month = 12;
                this.year--;
            }
            this.newNeededDate();
        },
        moveNextYear() {
            this.year++;
            this.newNeededDate();
        },
        movePreviousYear() {
            this.year--;
            this.newNeededDate();
        },
        newNeededDate() {
            let month = String(this.month).length === 1 ? this.month = '0' + this.month : this.month;
            this.neededDate = this.year + '-' + month + '-' + '01';
            console.log(this.neededDate);
            this.getTimeCalendar();
        },
        getTimeCalendar() {
            axios.post('/dashboard/nurse/get-time-calendar', {
                'nurse_id': this.user.id,
                'needed_date': this.neededDate
            })
                .then((response) => {
                    this.time_calendar = response.data.time_calendar;
                    console.log(this.time_calendar);
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
