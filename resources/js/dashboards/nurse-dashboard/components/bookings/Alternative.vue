<template>
  <div v-if="booking">
    <div class="pt-finder--form-block">
      <div class="pt-finder--form-group">
        <p class="pt-form--label">
          {{ $t('suggested_price_per_hour') }}
        </p>
        <pt-input type="number" :modelValue="booking.suggested_price_per_hour"
                  icon="user"
                  v-on:change="changeWeek()"
                  @update:modelValue="newValue => booking.suggested_price_per_hour = newValue"
        ></pt-input>
      </div>

      <div class="pt-finder--form-group">
        <p class="pt-form--label">
          {{ $t('additional_email') }}
        </p>
        <pt-input type="text" :modelValue="booking.additional_email"
                  icon="email"
                  @update:modelValue="newValue => booking.additional_email = newValue"
        ></pt-input>
      </div>

      <div class="pt-finder--form-group">
        <p class="pt-form--label">
          {{ $t('start_date') }}
        </p>
        <div class="pt-select">
          <div class="pt-select--icon">
            <pt-icon type="calendar"></pt-icon>
          </div>
          <Datepicker  format="dd.MM.yyyy" v-model="booking.start_date" autoApply></Datepicker>
          <span class="pt-select--caret"></span>
        </div>
      </div>

      <div class="pt-finder--form-group">
        <p class="pt-form--label">
          {{ $t('gender') }}
        </p>
        <div class="pt-select">
          <div class="pt-select--icon">
            <pt-icon type="users"></pt-icon>
          </div>
          <v-select label="title"
                    :options="[$t('one'), $t('regular')]"
                    v-model="booking.one_time_or_regular"
          >

            <template #open-indicator>
              <span class="pt-select--caret"></span>
            </template>
          </v-select>
        </div>
      </div>
    </div>

    <template v-if="show_for_regular">
      <div class="pt-finder--form-group">
        <p class="pt-form--label">
          {{ $t('weeks') }}
        </p>
        <pt-input type="number" :modelValue="booking.weeks"
                  icon="user"
                  v-on:change="changeWeek()"
                  @update:modelValue="newValue => booking.weeks = newValue"
        ></pt-input>
      </div>

      <div class="pt-finder--form-group">
        <p class="pt-form--label">
          {{ $t('days') }}
        </p>
        <div class="">
          <template v-for="(item, key) in weekdayLabels">
            <label class="pt-checkbox" :class="{disabled: !checkWorkWeekDays()}">
              <input type="checkbox" name="work_time_pref"
                     :value="key"
                     @change="addDays(key)">
              <span class="pt-checkbox--body">{{ item }}</span>
            </label>
          </template>
          <template v-for="(item, key) in weekendLabels">
            <label class="pt-checkbox" :class="{disabled: !checkWorkweekEnds()}">
              <input type="checkbox" name="work_time_pref"
                     :value="key"
                     @change="addDays(key)">
              <span class="pt-checkbox--body">{{ item }}</span>
            </label>
          </template>
        </div>
      </div>
    </template>

    <div class="row">
      <div class="col-4">
        {{ $t('total') + ': ' + booking.total }}
      </div>

    </div>

    <div class="pt-finder--form-block" v-if="show_week_days_interval">
      <div class="pt-finder--form-group">
        <p class="pt-form--label">
          verfügbare Zeit:
        </p>
        <div class="">
          <template v-for="item in data.time_intervals">
            <label class="pt-checkbox" v-if="item.type === 'weekdays'">
              <input type="checkbox" name="work_time_pref"
                     true-value="1" false-value="0"
                     @change="setIntervals"
                     v-model="booking.time_interval[item.id]">
              <span class="pt-checkbox--body">{{ item.interval }}</span>
            </label>
          </template>
        </div>
      </div>

      <div class="pt-finder--form-group">
        <p class="pt-form--label">
          Geben Sie die Anzahl der Stunden ein:
        </p>
        <div class="">
          <template v-for="(item, index) in intervals">
            <label class="pt-checkbox">
              <input type="checkbox" name="work_time_pref"
                     :value="item"
                     v-model="booking.week_days_checked"
                     v-on:change="getTotalPrice()">
              <span class="pt-checkbox--body">{{ item.val }}</span>
            </label>
          </template>
        </div>
      </div>
    </div>

    <div class="pt-finder--form-block" v-if="show_week_ends_interval">
      <div class="pt-finder--form-group">
        <p class="pt-form--label">
          verfügbare Zeit: (weekends)
        </p>
        <div class="">
          <template v-for="item in data.time_intervals">
            <label class="pt-checkbox" v-if="item.type === 'weekends'">
              <input type="checkbox" name="work_time_pref"
                     true-value="1" false-value="0"
                     @change="setIntervals"
                     v-model="booking.time_interval[item.id]">
              <span class="pt-checkbox--body">{{ item.interval }}</span>
            </label>
          </template>
        </div>
      </div>
      <div class="pt-finder--form-group">
        <p class="pt-form--label">
          Geben Sie die Anzahl der Stunden ein: (weekends)
        </p>
        <div class="">
          <template v-for="item in weekends_intervals">
            <label class="pt-checkbox">
              <input type="checkbox" name="work_time_pref"
                     :value="item"
                     v-model="booking.week_ends_checked" v-on:change="getTotalPrice()">
              <span class="pt-checkbox--body">{{ item.val }}</span>
            </label>
          </template>
        </div>
      </div>
    </div>

    <div class="pt-finder--form-block">
      <div class="pt-finder--form-group">
        <button class="pt-btn--primary pt-md pt-mr-a pt-ml-a" @click="sendAlternativeBooking()">
          {{ $t('send') }}
        </button>
      </div>
    </div>
  </div>


  <div class="row" v-if="false">
    <div class="col-8">
      <div class="row">
        <div class="col-3">
          <label for="suggested_price_per_hour" class="form-label col-form-label-sm">{{
              $t('suggested_price_per_hour')
            }}</label>
          <input id="suggested_price_per_hour" class="form-control form-control-sm"
                 type="number" v-model="booking.suggested_price_per_hour" v-on:change="changeWeek()">
        </div>
        <div class="col-3">
          <label for="additional_email" class="form-label col-form-label-sm">{{
              $t('additional_email')
            }}</label>
          <input type="email" class="form-control form-control-sm"
                 id="additional_email"
                 v-model="booking.additional_email">
        </div>
        <div class="col-3">
          <label for="start_date" class="form-label col-form-label-sm">{{
              $t('start_date')
            }}</label>
          <input type="date" class="form-control form-control-sm"
                 id="start_date"
                 v-model="booking.start_date">
        </div>
        <div class="col-3">
          <label for="one_time_or_regular" class="form-label col-form-label-sm">{{
              $t('one_time_or_regular')
            }}</label>
          <select id="one_time_or_regular" class="form-control form-control-sm"
                  v-model="booking.one_time_or_regular" v-on:change="changeRegularOrOne()">
            <option value="one">{{ $t('one') }}</option>
            <option value="regular">{{ $t('regular') }}</option>
          </select>
        </div>
      </div>

      <br>
      <div class="row" v-if="show_for_regular">
        <div class="col-4">
          <label class="form-label col-form-label-sm">{{ $t('weeks') }}</label>
          <input type="number" min="1" class="form-control form-control-sm"
                 v-model="booking.weeks" v-on:change="changeWeek()">
        </div>

        <div class="col-8">
          <label class="form-label col-form-label-sm">{{ $t('days') }}</label>
          <div class='weekdays'>
            <div class='weekday' v-for='(weekday, index) in weekdayLabels'>
                                    <span v-if="checkWorkWeekDays()" class="work-day" v-on:click="addDays(index)">
                                    <span v-if="in_array(index, booking.days)">+</span>
                                         {{ weekday }}
                                      </span>
              <span v-else>{{ weekday }}</span>
            </div>

            <div class='weekday' v-for='(weekend, index) in weekendLabels'>
                                  <span v-if="checkWorkweekEnds()" class="work-day" v-on:click="addDays(index)">
                                    <span v-if="in_array(index, booking.days)">+</span>
                                            {{ weekend }}
                                     </span>
              <span v-else>{{ weekend }}</span>
            </div>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col-4">
          {{ $t('total') + ': ' + booking.total }}
        </div>

      </div>
    </div>

    <div class="pt-finder--form-block" v-if="show_week_days_interval">
      <div class="pt-finder--form-label">
        <div class="pt-finder--form-label--number">3</div>
        verfügbare Zeit:
      </div>
      <div class="pt-finder--form-block--inner">
        <div class="pt-finder--form-group">
          <div class="">
            <div class="pt-finder--form-group">
              <div class="">
                <template v-for="item in data.time_intervals">
                  <label class="pt-checkbox" v-if="item.type === 'weekdays'">
                    <input type="checkbox" name="work_time_pref"
                           true-value="1" false-value="0"
                           @change="setIntervals"
                           v-model="booking.time_interval[item.id]">
                    <span class="pt-checkbox--body">{{ item.interval }}</span>
                  </label>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="pt-finder--form-block" v-if="show_week_days_interval">
      <div class="pt-finder--form-label">
        <div class="pt-finder--form-label--number">4</div>
        Geben Sie die Anzahl der Stunden ein:
      </div>
      <div class="pt-finder--form-block--inner">
        <div class="pt-finder--form-group">
          <div class="">
            <template v-for="(item, index) in intervals">
              <label class="pt-checkbox">
                <input type="checkbox" name="work_time_pref"
                       :value="item"
                       v-model="booking.week_days_checked"
                       v-on:change="getTotalPrice()">
                <span class="pt-checkbox--body">{{ item.val }}</span>
              </label>
            </template>
          </div>
        </div>
      </div>
    </div>

    <div class="pt-finder--form-block" v-if="show_week_ends_interval">
      <div class="pt-finder--form-label">
        <div class="pt-finder--form-label--number">3</div>
        verfügbare Zeit: (weekends)
      </div>
      <div class="pt-finder--form-block--inner">
        <div class="pt-finder--form-group">
          <div class="">
            <div class="pt-finder--form-group">
              <div class="">
                <template v-for="item in data.time_intervals">
                  <label class="pt-checkbox" v-if="item.type === 'weekends'">
                    <input type="checkbox" name="work_time_pref"
                           true-value="1" false-value="0"
                           @change="setIntervals"
                           v-model="booking.time_interval[item.id]">
                    <span class="pt-checkbox--body">{{ item.interval }}</span>
                  </label>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="pt-finder--form-block" v-if="show_week_ends_interval">
      <div class="pt-finder--form-label">
        <div class="pt-finder--form-label--number">4</div>
        Geben Sie die Anzahl der Stunden ein: (weekends)
      </div>
      <div class="pt-finder--form-block--inner">
        <div class="pt-finder--form-group">
          <div class="">
            <template v-for="item in weekends_intervals">
              <label class="pt-checkbox">
                <input type="checkbox" name="work_time_pref"
                       :value="item"
                       v-model="booking.week_ends_checked" v-on:change="getTotalPrice()">
                <span class="pt-checkbox--body">{{ item.val }}</span>
              </label>
            </template>
          </div>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-6 offset-3">
        <button class="btn btn-sm btn-success" v-on:click="sendAlternativeBooking()">{{ $t('send') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BookingEdit",
  props: ['data', 'booking_id'],
  data() {
    return {
      weekdayLabels: {
        1: 'Monday',
        2: 'Tuesday',
        3: 'Wednesday',
        4: 'Thursday',
        5: 'Friday'
      },
      weekendLabels: {
        6: 'Saturday',
        0: 'Sunday'
      },
      show_for_regular: false,
      intervals: false,
      weekends_intervals: false,
      show_week_days_interval: true,
      show_week_ends_interval: true,
      booking: false,

    }
  },
  mounted() {
    this.getBooking();
  },
  methods: {
    getBooking() {
      axios.get('/dashboard/nurse-bookings/' + this.booking_id)
          .then((response) => {
            if (response.data.success) {
              this.booking = response.data.booking;
              this.mountedProcess();
            }
          })
          .catch((error) => {
            console.log(error);
          });
    },
    setIntervals() {
      let self = this
      self.intervals = []
      self.weekends_intervals = []
      for (let key in self.booking.time_interval) {
        if (self.booking.time_interval[key] === '1') {
          let interval = self.data.time_intervals.find(function (int) {
            return int.id === key
          })
          if (interval.type === 'weekdays') {
            self.intervals.push(interval)
          } else {
            self.weekends_intervals.push(interval)
          }
        }
      }
      let timeIntervals = []
      self.intervals.forEach(function (item) {
        for (let i = item.start; i < item.end; i++) {
          timeIntervals.push({
            id: item.id,
            val: i + ':00 - ' + Number(i + 1) + ':00'
          })
        }
      })
      self.intervals = timeIntervals

      timeIntervals = []
      self.weekends_intervals.forEach(function (item) {
        for (let i = item.start; i < item.end; i++) {
          timeIntervals.push({
            id: item.id,
            val: i + ':00 - ' + Number(i + 1) + ':00'
          })
        }
      })
      self.weekends_intervals = timeIntervals;
    },
    getTotalPrice() {
      let self = this;
      if (self.booking.start_date) {
        let year = dayjs(self.booking.start_date).get('year');
        let month = dayjs(self.booking.start_date).get('month');
        let date = dayjs(self.booking.start_date).get('date');
        let workDays = 0;
        let workWeekendDays = 0;
        for (let i = date; i < (date + (7 * self.booking.weeks)); i++) {
          let day = dayjs(year + '-' + (month + 1) + '-' + i).get('day');
          if (day === 6 || day === 0) {
            if (self.booking.days.indexOf(day) !== -1) {
              workWeekendDays++;
            }
          } else {
            if (self.booking.days.indexOf(day) !== -1) {
              workDays++;
            }
          }
        }

        let total = 0;
        if (this.booking.one_time_or_regular == 'regular') {
          total = self.booking.suggested_price_per_hour * self.booking.week_days_checked.length * workDays
          if (workDays) {
            total += self.booking.suggested_price_per_hour * self.booking.week_ends_checked.length * workWeekendDays
          }
        } else {
          total = self.booking.suggested_price_per_hour * self.booking.week_days_checked.length;
          if (self.booking.week_days_checked.length === 0) {
            total += self.booking.suggested_price_per_hour * self.booking.week_ends_checked.length;
          }
        }

        this.booking.total = total.toFixed(2);
        return total.toFixed(2);
      }
    },
    changeRegularOrOne() {
      if (this.booking.one_time_or_regular == 'regular') {
        this.show_for_regular = true;
      } else {
        this.show_for_regular = false;
      }
      this.getTotalPrice();
    },
    changeWeek() {
      this.getTotalPrice();
    },
    addDays(day) {
      if (this.in_array(day, this.booking.days)) {
        let evens = _.remove(this.booking.days,
            function (n) {
              return n === day;
            });
        this.booking.days = evens;
      } else {
        this.booking.days.push(Number(day));
      }
      this.checkWeekDaysOrEnds();
      this.getTotalPrice();
    },
    checkWorkWeekDays() {
      if (this.booking.nurse.entity.work_time_pref.weekdays_7_11 === "1" ||
          this.booking.nurse.entity.work_time_pref.weekdays_11_14 === "1" ||
          this.booking.nurse.entity.work_time_pref.weekdays_14_17 === "1" ||
          this.booking.nurse.entity.work_time_pref.weekdays_17_21 === "1") {
        return true;
      }
    },
    checkWorkweekEnds() {
      if (this.booking.nurse.entity.work_time_pref.weekends_7_11 === "1" ||
          this.booking.nurse.entity.work_time_pref.weekends_11_14 === "1" ||
          this.booking.nurse.entity.work_time_pref.weekends_14_17 === "1" ||
          this.booking.nurse.entity.work_time_pref.weekends_17_21 === "1") {
        return true;
      }
    },
    in_array(needle, haystack, strict) {
      var found = false, key, strict = !!strict;
      for (key in haystack) {
        if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
          found = true;
          break;
        }
      }
      return found;
    },
    checkMultySelect(index) {
      if (this.booking.nurse.entity.multiple_bookings === 'no') {
        this.time.time_interval = {};
        this.time.time = {};
        this.time.time_interval[index] = "1";
      }

      if (this.time.time[index] !== undefined) {
        this.time.time[index] = "0";
      }

      if (this.time.time[index] !== undefined && this.time.time_interval[index] === "1") {
        this.time.time[index] = "1";
      }

      if (this.time.time[index] === undefined) {
        this.time.time[index] = "1";
      }
    },

    checkWeekDaysOrEnds() {
      if (this.booking.days.indexOf(1) === -1 && this.booking.days.indexOf(2) === -1 && this.booking.days.indexOf(3) === -1 &&
          this.booking.days.indexOf(4) === -1 && this.booking.days.indexOf(5) === -1) {
        this.show_week_days_interval = false;
        this.booking.week_days_checked = [];
      } else {
        this.show_week_days_interval = true;
      }

      if (this.booking.days.indexOf(0) === -1 && this.booking.days.indexOf(6) === -1) {
        this.show_week_ends_interval = false;
        this.booking.week_ends_checked = [];
      } else {
        this.show_week_ends_interval = true;
      }
    },
    sendAlternativeBooking() {
      axios.post('/dashboard/nurse-bookings', {'alternative': this.booking})
          .then((response) => {
            if (response.data.success) {
              this.emitter.emit('close-alternative-booking-modal');
              this.emitter.emit('response-success-true');
            }
          })
          .catch((error) => {
            console.log(error);
          });
    },
    mountedProcess() {
      if (this.booking.one_time_or_regular == 'regular') {
        this.show_for_regular = true;
      }
      if (typeof this.booking.nurse.entity.work_time_pref === 'string') {
        this.booking.nurse.entity.work_time_pref = JSON.parse(this.booking.nurse.entity.work_time_pref);
      }

      this.booking.time_interval = this.booking.nurse.entity.work_time_pref;
      this.setIntervals();

      this.booking.week_days_checked = [];
      this.booking.week_ends_checked = [];
      for (let i in this.intervals) {
        let time = this.booking.time.filter(($value) => {
          if ($value.time == this.intervals[i].val && $value.time_interval == this.intervals[i].id) {
            return true;
          }
        });
        if (time.length > 0) {
          let obj = {
            id: this.intervals[i].id,
            val: this.intervals[i].val
          }
          this.booking.week_days_checked.push(obj);
        }
      }

      for (let i in this.weekends_intervals) {
        let time = this.booking.time.filter(($value) => {
          if ($value.time == this.weekends_intervals[i].val && $value.time_interval == this.weekends_intervals[i].id) {
            return true;
          }
        });
        let obj = {
          id: this.weekends_intervals[i].id,
          val: this.weekends_intervals[i].val
        }

        if (time.length > 0) {
          this.booking.week_ends_checked.push(obj);
        }
      }
      if (this.booking.one_time_or_regular == 'regular') {
        this.checkWeekDaysOrEnds();
      }
    }
  }
}
</script>

<style scoped>
.weekdays {
  display: flex;
  flex: auto;
}

.weekday {
  width: 14.2857%;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0.2rem 0;
  color: #aaaaaa;
  border: 1px solid #aaaaaa;
  background-color: #eaeaea;
}

.work-day {
  cursor: pointer;
  color: #0a58ca;
}
</style>
