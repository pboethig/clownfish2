<style lang="scss">
    @import "../../../node_modules/ag-grid-community/dist/styles/ag-grid.css";
    @import "../../../node_modules/ag-grid-community/dist/styles/ag-theme-material.css";
</style>
<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <ul class="navbar-nav">
                    <router-link :to="{ name: 'templates' }" class="nav-link">Templates</router-link>
                    <router-link :to="{ name: 'page' }" class="nav-link" >Spa-Page</router-link>
                    <router-link :to="{ name: 'contact' }" class="nav-link" >Contact</router-link>
                </ul>
            </div>
        </nav>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>
<script>;
    export default {}
</script>