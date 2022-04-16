<template>
    <div class="pt-admin--media">
        <h1>Admin Media</h1>
        <div class="mb-3">
            <label class="form-label">Upload your media</label>
            <input class="form-control" type="file" @change="fileUpload($event)">
        </div>
        <div class="progress mb-3" v-show="loading">
            <div class="progress-bar" role="progressbar" :style="{width: progress +'%'}"

            ></div>
        </div>

        <div class="pt-admin--media-container">
            <div class="pt-admin--media-list">
                <div class="pt-admin--media-list--inner">
                    <div class="pt-admin--media-item" v-for="(item, index) in media">
                        <div class="pt-admin--media-item--inner" @click="openMediaInfo(index, item)">

                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-admin--media-panel" v-show="isMediaInfo !== false">
                <button class="btn btn-sm btn-danger float-end ms-1" @click.prevent="closeMediaInfo">X</button>
                <h3>
                    {{activeMedia.name}}
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

                <button class="btn btn-sm btn-danger" @click.prevent="deleteMedia(activeMedia.id)">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Media",
    data(){
        return {
            progress: 0,
            loading: false,
            mediaFile: false,
            isMediaInfo: false,
            activeMedia: false,
            media: [
                {
                    id: '1',
                    name: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto!',
                    path: 'media path 1',
                    preview: 'preview media path 1',
                    size: '2mb',
                },
                {
                    id: '2',
                    name: 'media 2',
                    path: 'media path 2',
                    preview: 'preview media path 2',
                    size: '2mb',
                },
                {
                    id: '3',
                    name: 'media 3',
                    path: 'media path 3',
                    preview: 'preview media path 3',
                    size: '2mb',
                },
                {
                    id: '4',
                    name: 'media 4',
                    path: 'media path 4',
                    preview: 'preview media path 4',
                    size: '2mb',
                },
                {
                    id: '5',
                    name: 'media 5',
                    path: 'media path 5',
                    preview: 'preview media path 5',
                    size: '2mb',
                },
                {
                    id: '6',
                    name: 'media 6',
                    path: 'media path 6',
                    preview: 'preview media path 6',
                    size: '2mb',
                },
                {
                    id: '7',
                    name: 'media 7',
                    path: 'media path 7',
                    preview: 'preview media path 7',
                    size: '2mb',
                },
            ]
        }
    },
    mounted() {
        this.getMedia()
    },
    methods: {
        openMediaInfo(index, item){
            this.isMediaInfo = index
            this.activeMedia = item
        },
        closeMediaInfo(){
            this.isMediaInfo = false
            this.activeMedia = false
        },
        getMedia() {
            axios.get('/dashboard/admin/get-media')
                .then((response) => {
                    if(response.data.success){
                        console.log(response.data)
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        deleteMedia(mediaId){
            let self = this;
            console.log(mediaId)
            axios({
                method: 'post',
                url: '/dashboard/admin/delete-media',
                data: mediaId,
            })
                .then((response) => {
                    console.log('Media deleted');
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
                    console.log('Media added');
                    self.loader = false;
                    self.progress = 0;
                    self.getMedia()
                })
                .catch((error) => {
                    this.loader = false;
                    console.log(error);
                });
        }
    }
}
</script>

<style lang="scss" scoped>
    $offset: 10px;
    $panel-width: 300px;

    .pt-admin--media{
        &-container{
            display: flex;
            justify-content: flex-start;
        }

        &-panel{
            background-color: #cccccc;
            transition: 0.3s;
            width: $panel-width;
            min-width: $panel-width;
            margin-left: 20px;
            padding: 20px;
        }

        &-list{
            width: 100%;

            &--inner{
                display: flex;
                justify-content: flex-start;
                align-items: flex-start;
                flex-wrap: wrap;
                margin: -$offset;
                //margin-right: -$offset;
            }
        }

        &-item{
            width: 20%;
            padding: $offset;

            &--inner{
                height: 150px;
                background-color: gray;
                cursor: pointer;
                border: 2px solid transparent;
                transition: 0.3s;

                &:hover{
                    border-color: #3a3a3a;
                }
            }
        }
    }
</style>
