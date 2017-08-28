<template>
<div id="app">
    <div class="gray-bg">
        <div class="content-holder">
            <div class="title-block">
                <h1>User management</h1>
            </div>
            <form action="#" class="keyword-form add-form" >
                <fieldset class="add-form-holder">
                    <div class="input-row">
                        <input type="text" placeholder="Login" readonly onfocus="this.removeAttribute('readonly');">
                    </div>
                    <div class="input-row">
                        <input type="password" placeholder="Password" readonly onfocus="this.removeAttribute('readonly');">
                    </div>
                    <div class="submit-row buttons-holder">
                        <button class="btn no-active" type="submit">Add</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="content-holder">
        <table class="table users-table">
            <thead>
                <tr>
                    <th>Login</th>
                    <th>Password</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>Logindfjhgckcccccccccc@mdxg</td>
                <td>PasswordPasswordPassword</td>
                <td><a href="#" class="btn">Delete</a></td>
            </tr>
            <tr>
                <td>Login2</td>
                <td>Password2sdtgdhfdj</td>
                <td><a href="#" class="btn">Delete</a></td>
            </tr>
            <tr>
                <td>Login3</td>
                <td>Password3</td>
                <td><a href="#" class="btn">Delete</a></td>
            </tr>
            <tr>
                <td>Login4</td>
                <td>Password4</td>
                <td><a href="#" class="btn">Delete</a></td>
            </tr>
            </tbody>
        </table>
        <p><img src="src/assets/loading.gif" alt="image description" class="loading"></p>
    </div>
</div>
</template>
<script>
    import axios from 'axios';
    import logout from './components/logout.vue';
    export default {
        components: {
            'app-logout': logout
        },
        data(){
            return {
                loading: false,
                responseError: false,
                userList: [],
            }
        },
        methods: {
            getUserList(){
                this.loading=true;
                axios.get(this.$config.api + '?action=userManagement&token='+this.$cookie.get('PHPSESSID')                          ).then((response) => {
                    if (response.status == 200 && Array.isArray(response.data) ) {
                        this.queryResult = response.data;

                    }else{
                        this.responseError='There was a problem retrieving ideas, please try again.'
                    }
                    this.loading = false;
                }).catch(e => {
                    this.$cookie.delete('PHPSESSID');
                    localStorage.removeItem('locations');
                    localStorage.removeItem('addKeyword');
                    window.location.href = '/';
                    this.loading = false;
                });

            }
        },
        beforeMount(){
            this.getUserList()
        }
    }
</script>
