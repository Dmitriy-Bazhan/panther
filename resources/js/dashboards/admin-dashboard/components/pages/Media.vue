<template>
    <div class="pt-admin--media">
        <h1>
            Admin Media

            <button class="btn btn-sm btn-danger float-end ms-1"
                    v-if="isPopup"
                    @click.prevent="closeMedia">
                X
            </button>
        </h1>
        <div class="mb-3">
            <label class="form-label">Upload your media</label>
            <input class="form-control" type="file" ref="file" @change="fileUpload($event)">
        </div>
        <div class="progress mb-3" v-show="loading">
            <div class="progress-bar" role="progressbar" :style="{width: progress +'%'}"

            ></div>
        </div>

        <div class="pt-admin--media-container">
            <div class="pt-admin--media-list">
                <div class="pt-admin--media-list--inner">
                    <div class="pt-admin--media-item" v-for="(item, index) in media">
                        <div class="pt-admin--media-item--inner"
                             @click="openMediaInfo(index, item)"
                        >
                            <img :src="item.path" alt="pic">
                        </div>
                    </div>
                </div>
                <nav class="mt-4">
                    <ul class="pagination">
                        <li class="page-item"
                            v-for="link in pagination.links"
                            :class="{active: link.active, disabled: !link.url}"
                        >
                            <a class="page-link" href="" @click.prevent="getMedia(link.url)">{{link.label}}</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="pt-admin--media-panel" v-show="isMediaInfo !== false">
                <button class="btn btn-sm btn-danger float-end ms-1" @click.prevent="closeMediaInfo">X</button>
                <h3>
                    {{activeMedia.file_name}}
                </h3>
                <ul>
                    <li>
                        Id - {{activeMedia.id}}
                    </li>
                    <li>
                        URL - {{activeMedia.path}}
                    </li>
                    <li>
                        size - {{activeMedia.size}}
                    </li>
                </ul>

                <button class="btn btn-success float-end ms-1"
                        v-if="isPopup"
                        @click.prevent="selectMedia(activeMedia)">
                    Select image
                </button>
                <button class="btn btn-sm btn-danger" @click.prevent="deleteMedia(activeMedia.id)">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MediaPage",
    props: ['is-popup'],
    data(){
        return {
            progress: 0,
            loading: false,
            mediaFile: false,
            isMediaInfo: false,
            activeMedia: false,
            media: [],
            pagination: {
                from: false,
                to: false,
                perPage: false,
                page: false,
            }
        }
    },
    mounted() {
        this.getMedia()
    },
    methods: {
        closeMedia(){
            this.$emit('close-media')
        },
        selectMedia(media){
            this.$emit('select-media', media)
            this.closeMedia()
        },
        openMediaInfo(index, item){
            this.isMediaInfo = index
            this.activeMedia = item
        },
        closeMediaInfo(){
            this.isMediaInfo = false
            this.activeMedia = false
        },
        getMedia(link) {
            let self = this;
            let url = link?link:'/dashboard/admin/get-media';
            axios.get(url)
                .then((response) => {
                    if(response.data.success){
                        self.media = response.data.media.data
                        self.pagination.from = response.data.media.from
                        self.pagination.last_page = response.data.media.last_page
                        self.pagination.perPage = response.data.media.per_page
                        self.pagination.links = response.data.media.links
                        self.pagination.total = response.data.media.total
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        deleteMedia(mediaId){
            let self = this;
            axios({
                method: 'post',
                url: '/dashboard/admin/delete-media',
                data: mediaId,
            })
                .then((response) => {
                    self.getMedia()
                    self.closeMediaInfo()
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        fileUpload(e){
            this.mediaFile = e.target.files[0]
            this.upload()
        },
        upload(){
            let self = this;
            self.loading = true;
            let data = new FormData();
            data.append('file', self.mediaFile);

            axios({
                method: 'post',
                url: '/dashboard/admin/save-media',
                data: data,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                onUploadProgress: function(progressEvent) {
                    self.progress = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                }
            })
                .then((response) => {
                    self.loading = false;
                    self.progress = 0;
                    this.$refs.file.value = ''
                    self.getMedia()
                })
                .catch((error) => {
                    this.loading = false;
                    console.log(error);
                });
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
