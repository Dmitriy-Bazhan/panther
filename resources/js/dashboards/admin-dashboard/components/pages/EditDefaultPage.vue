<template>
    <div class="row mt-2">
        <div class="col-6">
            <h1>Edit Page - {{ $route.params.id }}</h1>
        </div>
        <div class="col-6">
            <button class="btn btn-success" @click.prevent="savePage">Save</button>
        </div>
    </div>
    <ckeditor :editor="editor" v-model="pageData.data" :config="editorConfig"></ckeditor>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        name: "EditDefaultPage",
        data() {
            return {
                pageData: {
                    page: '',
                    data: false
                },
                editor: ClassicEditor,
                editorConfig: {
                    toolbar:
                        [
                            'heading', '|',
                            'fontfamily', 'fontsize', '|',
                            'alignment', '|',
                            'fontColor', 'fontBackgroundColor', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                            'link', '|',
                            'outdent', 'indent', '|',
                            'bulletedList', 'numberedList', 'todoList', '|',
                            'code', 'codeBlock', '|',
                            'insertTable', '|',
                            'blockQuote', '|',
                            'undo', 'redo'],
                },
            }
        },
        mounted() {
            this.getPage();
        },
        methods: {
            savePage() {
                axios.post('/dashboard/admin/save-page/' + this.$route.params.id, {
                    'pageData': this.pageData,
                    'lang': window.locale,
                })
                    .then((response) => {
                        if (response.data.success) {
                            this.emitter.emit('response-success-true');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            getPage() {
                axios.get('/dashboard/admin/get-page/' + this.$route.params.id + '?lang=' + window.locale)
                    .then((response) => {
                        if (response.data.success) {
                            this.pageData = response.data.page;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>

<style lang="scss">
    .ck-editor{
        ul {
            padding: 5px 0 5px 20px;
            li{
                list-style-type: disc;
            }
        }
        ol {
            padding: 5px 0 5px 20px;
            li{
                list-style-type: decimal;
            }
        }

        a{
            text-decoration: underline;
        }
    }
</style>
