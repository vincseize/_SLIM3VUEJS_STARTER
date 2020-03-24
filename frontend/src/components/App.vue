<template>
    <main>
        <Navbar />
        <router-view></router-view>
    </main>
</template>

<script>
import Navbar from 'components/Navbar';

export default {
    name: 'App',
    components: { Navbar }
};
</script>

<style scoped>
    main {
        position: relative;
        height: 100%;
    }
</style>
