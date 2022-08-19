<template>
    <div>
        <div class="pt-table--head">
            <div class="pt-messages--tabs">
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === ''}"
                        @click.prevent="activateTab('')">
                    <!--                {{ $t('all') }}-->
                    All
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'not_approved'}"
                        @click.prevent="activateTab('not_approved')">
                    <!--                {{ $t('not_approved_bookings') }}-->
                    Not approved
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'approved'}"
                        @click.prevent="activateTab('approved')">
                    <!--                {{ $t('approved_bookings') }}-->
                    Approved
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'in_process'}"
                        @click.prevent="activateTab('in_process')">
                    <!--                {{ $t('in_process_bookings') }}-->
                    In process
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'ended'}"
                        @click.prevent="activateTab('ended')">
                    <!--                {{ $t('ended_bookings') }}-->
                    Ended
                </button>
            </div>

            <pt-search class="pt-ml-a"></pt-search>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Payments",
        data() {
            return {
                status_of_view: false,
                status: false,
                search: '',
                activeTab: '',
            }
        },
        mounted() {
            this.getPayments();
        },
        methods: {
            activateTab(n) {
                this.activeTab = n
                this.search = ''
                this.getBookings()
            },
            getPayments(link) {
                //status = wait, payed ...
                //status_of_view = 'yes' or 'no'; for admin, does he watched this payment or not

                let page = 1
                if (link) {
                    let linkUrl = new URL(link.url);
                    page = linkUrl.searchParams.get('page')
                }

                let url = '/dashboard/admin/get-payments' +
                    +'?page=' + page
                    + '&status=' + this.activeTab
                    + '&search=' + this.search
                let query_string = '?status=' + this.status + '&status_of_view=' + this.status_of_view;

                axios.get(url)
                    .then((response) => {
                        console.log(response);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            getPayment() {
                axios.get('/dashboard/admin/get-payment/' + 4)
                    .then((response) => {
                        console.log(response);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>

<style scoped>
    .pt-messages--tabs-btn{
        width: auto;
        display: inline-flex;
        padding: 0 20px;
        white-space: nowrap;
    }
</style>
