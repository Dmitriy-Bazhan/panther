<template>
    <div>
        <h1>Nurses</h1>

        <table rules="all">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Is</th>
            </tr>
            </thead>
            <tbody>
                <tr v-if="data.nurses.data.length > 0" v-for="nurse in data.nurses.data">

                    <td>{{ nurse.id }}</td>
                    <td>{{ nurse.last_name + ' ' + nurse.first_name }}</td>
                    <td>{{ nurse.entity.age }}</td>
                    <td>{{ nurse.is_nurse }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "Nurses",
    props: ['data'],
    mounted() {
        console.log(this.data);
        console.log(this.data.nurses);
    }
}
</script>

<style scoped>
table , th, td{
    border: solid 1px gray;
}
th, td {
    padding: 10px;
}
</style>
