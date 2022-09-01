<template>
    <h5>{{ $t('mail_templates') }}</h5>
    <div class="row">
        <div class="col-4">
            <table>
                <thead>
                <tr>
                    <th>{{ $t('id') }}</th>
                    <th>{{ $t('name') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="templates.length > 0" v-for="template in templates">
                    <td>{{ template.id }}</td>
                    <td>
                        <span style="cursor: pointer;" v-on:click="editTemplate(template)">{{ template.name }}</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-8" v-if="edit_template">
            <div class="row">
                Name: {{ edit_template.name }}
            </div>
            <br>
            <div class="row">
                <textarea style="width:100%; border: solid 1px #6a6a6a;" rows="7"
                          v-model="edit_template.content"></textarea>
            </div>
            <br>
            <div class="row">
                <button class="bth btn-sm btn-success" v-on:click="updateTemplate()">{{ $t('update') }}</button>
            </div>
        </div>
    </div>


</template>

<script>
    import Textarea from "../../../../components/Textarea/Textarea";

    export default {
        name: "MailTemplate",
        components: {Textarea},
        data() {
            return {
                templates: [],
                edit_template: null,
            }
        },
        mounted() {
            this.getTemplates();
        },
        methods: {
            updateTemplate() {
                axios.post('update-template', {'template': this.edit_template})
                    .then((response) => {
                        if (response.data.success) {
                            this.emitter.emit('response-success-true');
                        } else {
                            console.log('Errors');
                            console.log(response);
                        }
                    }).catch((error) => {
                    console.log(error);
                });
            },
            editTemplate(template) {
                this.edit_template = template;
            },
            getTemplates() {
                axios.get('get-templates')
                    .then((response) => {
                        if (response.data.success) {
                            this.templates = response.data.templates;
                        } else {
                            console.log('Errors');
                            console.log(response);
                        }
                    }).catch((error) => {
                    console.log(error);
                });
            }
        }
    }
</script>

<style scoped>

</style>
