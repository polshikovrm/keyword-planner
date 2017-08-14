<template>
    <div class="clearfix">
        <a v-on:click="logout()" class="btn btn-logout">Logout</a>
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
