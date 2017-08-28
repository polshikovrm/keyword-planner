<template>
<div id="app">
    <div class="gray-bg">
        <div class="content-holder">
            <div class="title-block">
                <h1>User management</h1>
            </div>
            <form action="#" class="keyword-form add-form" @submit.prevent="validateForm('form-1')" data-vv-scope="form-1" >
                <fieldset class="add-form-holder">
                    <div :class="{ 'input-row': true }">
                        <input v-model="login" v-validate="'required|email'"
                               :class="{'input': true, 'is-danger': errors.has('form-1.login') }" name="login"
                               type="text" placeholder="Login" readonly onfocus="this.removeAttribute('readonly');">
                        <span v-show="errors.has('form-1.login')" class="help is-danger">{{ errors.first('form-1.login') }}</span>
                        <span v-show="responseErrorAddUser" class="help is-danger">{{ responseErrorAddUser }}</span>
                    </div>
                    <div :class="{ 'input-row': true }">
                        <input v-model="password" v-validate="'required|min:6'"
                               :class="{'input': true, 'is-danger': errors.has('form-1.password') }" name="password"
                               type="password" placeholder="Password" readonly onfocus="this.removeAttribute('readonly');">
                        <span v-show="errors.has('form-1.password')" class="help is-danger">{{ errors.first('form-1.password') }}</span>
                    </div>
                    <div class="submit-row buttons-holder">
                        <button class="btn " :class="{ 'no-active': loadingAdd }" type="submit">Add</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="content-holder">
        <table class="table users-table" v-if="userList.length">
            <thead>
                <tr>
                    <th>Login</th>
                    <th>Password</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in userList">
                <td>{{item.email}}</td>
                <td>{{item.password}}</td>
                <td>
                    <span href="#" class="btn" v-if="item.email != 'user@email.com' && item.email != 'clientfloseo@gmail.com'" v-on:click="remove(item, index,$event)">Delete</span>
                </td>
            </tr>
            </tbody>
        </table>
        <p v-if="loadingUserList" ><img src="src/assets/loading.gif" alt="image description" class="loading"></p>
        <p v-if="responseError">{{responseError}}</p>
    </div>
</div>
</template>
<script>
    import VeeValidate from 'vee-validate';
    import axios from 'axios';
    import logout from './components/logout.vue';
    import Vue from 'vue';

    const config = {
        errorBagName: 'errors', // change if property conflicts.
        fieldsBagName: 'fields',
        delay: 0,
        locale: 'en',
        dictionary: null,
        strict: true,
        enableAutoClasses: false,
        classNames: {
            touched: 'touched', // the control has been blurred
            untouched: 'untouched', // the control hasn't been blurred
            valid: 'valid', // model is valid
            invalid: 'invalid', // model is invalid
            pristine: 'pristine', // control has not been interacted with
            dirty: 'dirty' // control has been interacted with
        },
        events: 'input|blur',
        inject: true
    };
    Vue.use(VeeValidate, config);

    export default {
        components: {
            'app-logout': logout
        },
        data(){
            return {
                login: '',
                password: '',
                loadingUserList: true,
                loadingAdd: false,
                responseError: false,
                responseErrorAddUser: false,
                responseErrorRemove: false,
                userList: [],
            }
        },
        methods: {
            validateForm(scope) {
                 console.log(this.password);
                this.$validator.validateAll(scope).then(result => {
                    if (result) {
                        this.addUser();
                    }
                });
            },
            getUserList(){
                this.loadingUserList = true;
                axios.get(this.$config.api + '?action=userManagement&token='+this.$cookie.get('PHPSESSID')).then((response) => {
                    if (response.status == 200 && Array.isArray(response.data) ) {
                        this.userList = response.data;
                    }else{
                        this.responseError = 'Internal error on the server try again later.'
                    }
                    this.loadingUserList = false;
                }).catch(e => {
                    this.$cookie.delete('PHPSESSID');
                    localStorage.removeItem('locations');
                    localStorage.removeItem('addKeyword');
                    window.location.href = '/';
                    this.loadingUserList=false;
                });

            },
            remove(item,index,$event){
                $event.stopPropagation();
                axios.post(this.$config.api + '?action=deleteUser&token='+this.$cookie.get('PHPSESSID'),
                    {id:item.id}
                ).then((response) => {
                    if (response.status == 200) {
                        delete this.userList.splice(index, 1);
                    }else{
                        this.responseErrorRemove = response.data.error;
                    }
                }).catch(e => {
                    this.$cookie.delete('PHPSESSID');
                    localStorage.removeItem('locations');
                    localStorage.removeItem('addKeyword');
                    window.location.href = '/';
                });
            },
            addUser(){
                this.loadingAdd=true;
                axios.post(this.$config.api + '?action=addUser&token='+this.$cookie.get('PHPSESSID'),
                    {email:this.login,password:this.password}
                    ).then((response) => {
                    if (response.status == 200 && response.data.error==undefined) {
                        this.userList.push(response.data);
                        this.email = '';
                        this.password = '';

                    }else{
                        this.responseErrorAddUser = response.data.error;
                    }
                    this.loadingAdd=false;
                }).catch(e => {
                    this.loadingAdd=false;
                    this.$cookie.delete('PHPSESSID');
                    localStorage.removeItem('locations');
                    localStorage.removeItem('addKeyword');
                    window.location.href = '/';
                });
            }
        },
        beforeMount(){
            this.getUserList()
        }
    }
</script>
