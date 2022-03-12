import template from "./template.html";
import './style.css';

export default {
    name: 'listing',
    template: template,
    props: ['data'],
    data() {
        return {
            path: location.origin,
            filterString: '?only_full_info=yes',
            nurses: [],
            showReminder: false,
        }
    },
    watch: {
        showReminder(showReminder) {
            if (showReminder) {
                document.addEventListener('click', this.closeReminderBlock);
            }
        }
    },

    mounted() {
        console.log(this.data);
        this.getNurses();
    },
    methods: {
        getNurses() {
            axios.get('listing/get-nurses-to-listing' + this.filterString)
                .then((response) => {
                    this.nurses = response.data.data;
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
        }
    }
}
