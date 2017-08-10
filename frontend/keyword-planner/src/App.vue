<template>
    <div id="app">
        <div class="wrapper">
            home
            <form class="form-inline" v-on:submit.prevent="login()">
                <div class="input-group col-12">
                    <input autocomplete="off" v-model="email" autofocus="autofocus" class="form-control form-control-lg"
                           placeholder="email@company.com" required="required" type="email">
                    <input autocomplete="off" v-model="password" autofocus="autofocus"
                           class="form-control form-control-lg" placeholder="password" required="required"
                           type="password">
                    <span class="input-group-btn">
                                <button type="submit" class="btn  btn-success">
                                    <i v-if="loading" class="fa fa-spinner fa-spin"> </i> login</button>
                            </span>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                loading: false,
                email: '',
                password: '',
                data: {},
                errors: [],
            }
        },
        methods: {
            login() {
                this.data = {};
                this.risky = {
                    score: 0,
                    message: ''
                };
                this.loading = true;
                    axios.post(this.$config.api+'?action=login',
                        {email: this.email, password: this.password},
                    ).then((response) => {
                         console.log('response',response.data);
                        this.loading = false;
                        if (200 === response.status){
                            if(response.data.successfully){
                                this.$cookie.set('PHPSESSID', response.data.successfully.token, 1);
                                window.location.href = '/targetLocations';
                            }
                        }
                    }).catch(e => {
                            this.loading = false;
                        this.errors.push(e)
                    })

            }
        }

    }
</script>
