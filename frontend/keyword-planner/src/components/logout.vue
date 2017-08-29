<template>
    <div class="clearfix">
        <a v-on:click="logout()" class="btn btn-logout">Logout</a>
        <a v-if="isVisible()" href="/user-management" class="btn btn-logout">User Management</a>
    </div>
</template>
<script>
    export default  {
        methods: {
            logout(){
                this.$cookie.delete('PHPSESSID');
                localStorage.removeItem('locations');
                localStorage.removeItem('addKeyword');
                window.location.href = '/';
            },
            isVisible(){
                if(
                    (
                        this.$cookie.get('user_email') == 'clientfloseo@gmail.com'
                        || this.$cookie.get('user_email') == 'user@email.com'
                    )
                    && window.location.pathname!='/user-management'){
                    return true;
                }
                return false;
            }
        }
    }
</script>
