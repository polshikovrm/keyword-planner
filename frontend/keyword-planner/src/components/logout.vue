<template>
    <div class="clearfix">
        <a v-on:click="logout()" class="btn btn-logout">Logout</a>
        <a v-if="isVisible()" href="/demand-tool/user-management" class="btn btn-logout">User Management</a>
    </div>
</template>
<script>
    export default  {
        methods: {
            logout(){
                this.$cookie.delete('PHPSESSID');
                localStorage.removeItem('locations');
                localStorage.removeItem('addKeyword');
                window.location.href = '/demand-tool/';
            },
            isVisible(){
                if(
                    (
                        this.$cookie.get('user_email') == 'clientfloseo@gmail.com'
                        || this.$cookie.get('user_email') == 'user@email.com'
                    )
                    && window.location.pathname!='/demand-tool/user-management'){
                    return true;
                }
                return false;
            }
        }
    }
</script>
