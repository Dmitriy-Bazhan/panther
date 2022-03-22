import template from "./template.html";
import NursesListing from "./NursesListing";
import NurseProfile from "./NurseProfile";
import './style.css';

export default {
    name: 'listing',
    template: template,
    components: {
        'nurses-listing': NursesListing,
        'nurses-profile': NurseProfile,
    },
    props: ['data', 'user'],
    data() {
        return {
            path: location.origin,
            nurses: [],
            nurse: null,
            errors: null,
            showReminder: false,
            showModalNursesListing: false,
            showModalNurseProfile: false,
            showOneTimeCalendar: false,
            showRegularCalendar: false,
            url: 'listing/get-nurses-to-listing',
            clientSearchInfo: {
                for_whom: 'for_a_relative',
                name: '',
                last_name: '',
                age_range: '40-60',
                provider_supports: [],
                disease: [],
                other_disease: '',
                degree_of_care_available: 3,
                language: 'no_matter',
                language_level: 'no_matter',
                do_you_need_help_moving: 'unknown',
                additional_transportation: 'unknown',
                memory: 'unknown',
                incontinence: 'unknown',
                preference_for_the_nurse: 'no_matter',
                hearing: 'unknown',
                vision: 'unknown',
                areas_help: 'hygiene',
                other_areas: '',
                one_or_regular: '',
                one_time_date: null,
                regular_time_start_date: null,
                regular_time_finish_date: null,
                work_time_pref: {
                    weekdays_7_11: "0",
                    weekends_7_11: "0",
                    weekdays_11_14: "0",
                    weekends_11_14: "0",
                    weekdays_14_17: "0",
                    weekends_14_17: "0",
                    weekdays_17_21: "0",
                    weekends_17_21: "0",
                },
            }
        }
    },
    watch: {
        showReminder(showReminder) {
            if (showReminder) {
                document.addEventListener('click', this.closeReminderBlock);
            }
        },
    },
    mounted() {
        this.getClientSearchInfo();
        this.emitter.on('close-modal-nurse-listing', e => {
            this.showModalNursesListing = false;
        });

        this.emitter.on('close-modal-nurse-profile', e => {
            this.nurse = null;
            this.showModalNurseProfile = false;
        });

        this.emitter.on('get-nurses-new-page', url => {
            if (url !== null) {
                this.url = url;
                this.findNeedNurses();
            }

        });

        this.emitter.on('show-nurse-profile', nurse => {
            if (nurse !== null) {
                this.nurse = nurse;
                this.showModalNurseProfile = true;
            }
        });
    },
    methods: {
        getClientSearchInfo() {
            axios.get('listing/get-client-search-info')
                .then((response) => {
                    if (response.data.success) {
                        this.clientSearchInfo = response.data.clientSearchInfo;
                        this.clientSearchInfo.provider_supports = JSON.parse(this.clientSearchInfo.provider_supports);
                        this.clientSearchInfo.work_time_pref = JSON.parse(this.clientSearchInfo.work_time_pref);
                        this.clientSearchInfo.disease = JSON.parse(this.clientSearchInfo.disease);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        findNeedNurses() {
            this.closeCalendars();
            axios.post(this.url, {'clientSearchInfo': this.clientSearchInfo})
                .then((response) => {
                    if (response.data.success) {
                        console.log(response);
                        this.emitter.emit('response-success-true');
                        this.errors = null;
                        this.nurses = response.data.nurses;
                        this.showModalNursesListing = true;
                    } else {
                        this.errors = response.data.errors;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        showReminderBlock() {
            this.showReminder === true ? this.showReminder = false : this.showReminder = true;
        },
        closeReminderBlock(event) {
            if (!document.getElementById('listing-reminder-end').contains(event.target)) {
                this.showReminder = false;
                document.removeEventListener('click', this.closeReminderBlock);
            }
        },
        ForMeOrForRelative() {
            if (this.clientSearchInfo.for_whom == 'to_me') {
                this.clientSearchInfo.name = this.user.first_name;
                this.clientSearchInfo.last_name = this.user.last_name;
            }

            if (this.clientSearchInfo.for_whom == 'for_a_relative') {
                this.clientSearchInfo.name = '';
                this.clientSearchInfo.last_name = '';
            }
        },
        OneOrRegularCalendar(item) {
            if (item == 'one') {
                this.showOneTimeCalendar = true;
                this.showRegularCalendar = false;
            }

            if (item == 'regular') {
                this.showOneTimeCalendar = false;
                this.showRegularCalendar = true;
            }
        },
        closeCalendars() {
            this.showOneTimeCalendar = false;
            this.showRegularCalendar = false;
        }
    }
}
