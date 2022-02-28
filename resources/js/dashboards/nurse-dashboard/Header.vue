<template>
    <div class="container-fluid nurse-dashboard-header">

        <div class="row">
            <div class="col-2">
                <h1>Nurse Header</h1>
            </div>

            <div class="col-2 offset-5">
                <localization-component></localization-component>
            </div>

            <div class="col-3">

                Name : {{ user.first_name }}
                &nbsp;
                <a href="/">
                    <button class="btn btn-sm btn-success">To main page</button>
                </a>
                &nbsp;
                <logout-component></logout-component>

            </div>
        </div>
    </div>
</template>

<script>
import Localization from "../../pages/components/Localization";
import Logout from "../../pages/components/Logout";

export default {
    name: "Header",
    props: ['user'],
    components : {
        'localization-component' : Localization,
        'logout-component' : Logout,
    }
}
</script>

<style scoped>
.nurse-dashboard-header {
    padding: 5px;
    background: #9dc3fc;
}
</style>
