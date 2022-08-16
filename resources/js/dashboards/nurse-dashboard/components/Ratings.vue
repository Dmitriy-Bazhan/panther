<template>
    <div v-if="feedbacks">
        <div class="pt-testimonials">
            <div class="pt-testimonial" v-for="feedback in feedbacks">
                <div class="pt-testimonial--avatar">
                    <img :src="path + '/storage/' + feedback.creator.entity.thumbnail_photo" alt="pic" v-if="feedback.creator.entity.thumbnail_photo">
                </div>
                <div class="pt-testimonial--container">
                    <div class="pt-testimonial--info">
                        <div class="pt-testimonial--name">
                            {{feedback.creator.full_name}}

                            <pt-rate :rate="feedback.rate"></pt-rate>
                        </div>
                        <div class="pt-testimonial--date">
                            {{serializeDate(feedback.created_at)}}
                        </div>
                    </div>
                    <div class="pt-testimonial--text">
                        <pt-icon type="quotes"></pt-icon>
                        <p>
                            {{feedback.description}}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-pagination">
            <a href="" class="pt-pagination--link"
               v-for="(link, index) in pagination"
               @click.prevent="getFeedbackAndRatings(link)"
               :class="{active: link.active}"
            >
                <i class="fa-solid fa-angle-left" v-if="index === 0"></i>
                <i class="fa-solid fa-angle-right" v-else-if="index === pagination.length-1"></i>
                <template v-else>{{ link.label }}</template>
            </a>
        </div>
    </div>
</template>

<script>
export default {
    name: "Ratings",
    props: ['user', 'data'],
    data() {
        return {
            path: location.origin,
            feedbacks: false,
            pagination: false
        }
    },
    mounted() {
        this.getFeedbackAndRatings();

    },
    methods: {
        getFeedbackAndRatings(link){
            let self = this
            let url = link&&link.url?link.url:'/dashboard/nurse-ratings/get-feedback-and-ratings'
            axios.get(url)
                .then((response) => {
                    if(response.data.success){
                        self.feedbacks = response.data.feedbacks.data
                        self.pagination = response.data.feedbacks.meta.links
                        console.log(self.pagination);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        serializeDate(date) {
            return dayjs(date).format('YYYY-MM-DD')
        },
    }
}
</script>

<style scoped>

</style>
