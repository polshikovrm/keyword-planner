<template>
    <div id="app">
        <div class="login-frame">
            <div class="text-holder">
                <div class="text">
                    <h1>Adwords ROI Calculator</h1>
                    <p>Predictable Growth made easy.</p>
                    <p>Calculate the return on investment you can expect from an Adwords campaign, based on keyword data from Google and conversion data from ClientFlo.</p>
                </div>
                <div class="copyright">
                    <p>powered by <a href="#" class="logo-copyright"><img src="src/assets/copyright-logo.png" alt="ClientFlo"></a></p>
                </div>
            </div>
            <form class="login-form" v-on:submit.prevent="login()">
                <div class="input-group">
                    <div class="input-row">
                        <input autocomplete="off" v-model="email" autofocus="autofocus" class="form-control form-control-lg"
                               placeholder="Username" required="required" type="email">
                    </div>
                    <div class="input-row">
                        <input autocomplete="off" v-model="password" autofocus="autofocus"
                               class="form-control form-control-lg" placeholder="Password" required="required" type="password">
                        <div class="error">

                            <p v-for="(item, index) in errorsLogin" >{{item['emailOrPassword']}}</p>
                        </div>
                    </div>
                    <div class="input-row">
                        <button type="submit" class="btn gray">Login <span class="arrow-left"></span></button>
                    </div>
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
                errorsLogin: [],
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
                        this.loading = false;
                        if (200 === response.status){
                            if(response.data.successfully){
                                this.$cookie.set('PHPSESSID', response.data.successfully.token, 1);
                                window.location.href = '/target-locations';
                            }else if(response.data.errors){
                                this.errorsLogin.push(response.data.errors);
                            }
                        }
                    }).catch(e => {
                            this.loading = false;
                        this.errorsLogin.push(e)
                    })

            }
        }

    }
</script>
