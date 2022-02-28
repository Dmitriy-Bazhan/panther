<template>
    <div class="container-fluid admin-dashboard-header">

        <div class="row">
            <div class="col-2">
                <h1>Header</h1>
            </div>

            <div class="col-2 offset-6">
                <localization-component></localization-component>
            </div>

            <div class="col-2">
                <a href="/">
                    <button class="btn btn-sm btn-success">To main page</button>
                </a>

            </div>
        </div>
    </div>
</template>

<script>
import Localization from "../../pages/components/Localization";

export default {
    name: "Header",
    components: {
        'localization-component': Localization
    },
}
</script>

<style scoped>
.admin-dashboard-header {
    padding: 5px;
    background: #9dc3fc;
}
</style>
