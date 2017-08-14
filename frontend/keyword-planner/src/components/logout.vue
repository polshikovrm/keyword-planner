<template>
    <div v-on:click="logout()" >
        logout

    </div>
</template>
<script>
    export default  {
        methods: {
            logout(){
                 console.log('sdfsd');
                this.$cookie.delete('PHPSESSID');
                localStorage.removeItem('locations');
                window.location.href='/';
            }
        }
    }
</script>
