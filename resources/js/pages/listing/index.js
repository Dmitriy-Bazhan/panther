import template from "./template.html";

export default {
    name: 'listing',
    template: template,
    data(){
        return  {
            path: location.origin,
            filterString: '?only_full_info=yes',
            nurses: [],
        }
    },
    mounted() {
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
    }
}
