<template>
    <h5>{{ $t('contracts') }}</h5>
    <div class="row">
        <div class="col-2 offset-10">
            <button class="btn btn-sm btn-success" v-on:click="addContract()">{{ $t('add') }}</button>
        </div>
    </div>

    <div class="row">
        <div class="col-2 offset-10">
            <button class="btn btn-sm btn-success" v-on:click="downloadPdf()">{{ $t('download') }}</button>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <table>
                <thead>
                <tr>
                    <th>{{ $t('id') }}</th>
                    <th>{{ $t('title') }}</th>
                    <th>{{ $t('text') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="contracts.length > 0" v-for="contract in contracts">
                    <td>{{ contract.id }}</td>
                    <td>
                        <span style="cursor: pointer;" v-on:click="editContract(contract)">{{ contract.title }}</span>
                    </td>
                    <td>{{ contract.text.substring(0,25) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-8" v-if="edit_contract">
            <div class="row">
                Name: {{ edit_contract.title }}
            </div>
            <br>
            <div class="row">
                <textarea style="width:100%; border: solid 1px #6a6a6a;" rows="7"
                          v-model="edit_contract.text"></textarea>
            </div>
            <br>
            <div class="row">
                <button class="bth btn-sm btn-success" v-on:click="updateContract()">{{ $t('update') }}</button>
            </div>
        </div>

        <div class="col-8" v-if="new_contract">
            <div class="row">
                <input type="text" v-model="new_contract.title" class="form-control form-control-sm">
            </div>
            <br>
            <div class="row">
                <textarea style="width:100%; border: solid 1px #6a6a6a;" rows="7"
                          v-model="new_contract.text"></textarea>
            </div>
            <br>
            <div class="row">
                <button class="bth btn-sm btn-success" v-on:click="saveContract()">{{ $t('save') }}</button>
            </div>
        </div>

    </div>
</template>

<script>
import Textarea from "../../../../components/Textarea/Textarea";
import Input from "../../../../components/Input/Input";

export default {
    name: "Contracts",
    components: {Input, Textarea},
    data() {
        return {
            contracts: false,
            edit_contract: false,
            new_contract: false,
        }
    },
    mounted() {
        this.getContracts();
    },
    methods: {
        downloadPdf(){
            window.location.href = '/contracts/download-pdf/Test';
        },
        addContract() {
            this.new_contract = {
                title: '',
                text: '',
            }
        },
        saveContract() {
            axios.post('/contracts', {'contract': this.new_contract})
                .then((response) => {
                    if (response.data.success) {
                        this.emitter.emit('response-success-true');
                        this.new_contract = false;
                        this.getContracts();
                    } else {
                        console.log('Errors');
                        console.log(response);
                    }
                }).catch((error) => {
                console.log(error);
            });
        },
        updateContract() {
            axios.put('/contracts/' + this.edit_contract.id, {'contract': this.edit_contract})
                .then((response) => {
                    if (response.data.success) {
                        this.emitter.emit('response-success-true');
                        this.edit_contract = false;
                    } else {
                        console.log('Errors');
                        console.log(response);
                    }
                }).catch((error) => {
                console.log(error);
            });
        },
        editContract(contract) {
            this.edit_contract = contract;
        },
        getContracts() {
            axios.get('/contracts')
                .then((response) => {
                    if (response.data.success) {
                        this.contracts = response.data.contracts;
                    } else {
                        console.log('Errors');
                        console.log(response);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>

</style>
