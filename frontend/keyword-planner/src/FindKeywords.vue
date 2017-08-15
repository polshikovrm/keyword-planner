<template>
    <div id="app">
        <div class="find-keywords">
            <div class="gray-bg">
                <div class="content-holder">
                    <app-logout></app-logout>
                    <div class="title-block">
                        <h1><span class="number">2</span>Enter Product or Service</h1>
                    </div>

                    <form @submit.prevent="validateForm('form-1')" data-vv-scope="form-1" class="keyword-form claerfix">
                        <div class="buttons-holder">
                            <button type="submit" class="btn">show demand</button>
                            <button type="reset" class="btn reset">reset</button>
                        </div>
                        <div class="search-field">
                            <p :class="{ 'control': true }">
                                <input v-model="keyword" v-validate="'required'"
                                       :class="{'input': true, 'is-danger': errors.has('form-1.keyword') }" name="keyword"
                                       type="text" placeholder="keyword">
                                <span v-show="errors.has('form-1.keyword')" class="help is-danger">{{ errors.first('form-1.keyword') }}</span>
                            </p>
                        </div>

                    </form>

                </div>
            </div>
            <div class="content-holder">
                <div v-if="columnChart.length">
                    <div class="title-block">
                        <h1><span class="number">3</span>Results</h1>
                    </div>
                    <div class="chart-holder">
                        <column-chart :data="columnChart"  height="500px"></column-chart>

                    </div>

                    <!--<div class="clearfix download-block">-->
                        <!--<a href="#" class="btn-simple"><span class="icon-download"></span>Download</a>-->
                    <!--</div>-->
                </div>
                <p v-if="loadingStats"><img src="src/assets/loading.gif" alt="image description" class="loading"></p>
                <app-table-keyword :queryResult="queryResultStats"></app-table-keyword>
                <p v-if="loading"><img src="src/assets/loading.gif" width="" height="" alt="image description" class="loading"></p>
                <app-table-keyword :queryResult="queryResult"></app-table-keyword>
                <!--to do:  v-on:click="step2()" - go to step 2-->
                <div class="clearfix"><a href="#" class="btn btn-next">Coming soon...</a></div>
                <div class="clearfix"><a href="/target-locations" class="btn btn-next">Back</a></div>
            </div>
        </div>
    </div>
</template>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://unpkg.com/chartkick@2.2.3"></script>
<script src="https://unpkg.com/vue-chartkick@0.2.0/dist/vue-chartkick.js"></script>
<script>
    import axios from 'axios';
    import Vue from 'vue';
    import VeeValidate from 'vee-validate';
    import numeral from 'numeral';
    import Chartkick from 'chartkick';
    import VueChartkick from 'vue-chartkick';
    import Chart from 'chart.js';
    import tableKeyword from './components/TableKeyword.vue';
    import logout from './components/logout.vue';
    import moment from "moment";
    import VueMomentJS from "vue-momentjs";

    Vue.use(VueMomentJS, moment);

    Chartkick.options = {colors: ["rgb(66, 133, 244)"]};

    Vue.use(VueChartkick, { Chartkick });



    Vue.filter("formatNumber", function (value) {
        return numeral(value).format("0,0"); // displaying other groupings/separators is possible, look at the docs
    });

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
            'app-table-keyword': tableKeyword,
            'app-logout': logout,
        },
        data(){
            return {
                columnChart:[],
                loading: false,
                loadingStats: false,
                keyword: '',
                queryResult: [],
                queryResultStats: [],
            }
        },
        methods: {
            validateForm(scope) {
                this.$validator.validateAll(scope).then(result => {
                    if (result) {
                        // eslint-disable-next-line
                        this.showDemand();
                    }
                });
            },
            setChart(queryResult){
                var columnChart = [];
                queryResult.forEach(function (value) {
                    value.targetedMonthlySearches.forEach(function (val, ind) {
                        var month  = val.month.toString().length==1?'0'+val.month : val.month;
                        var name = moment(val.year + '-' + month + '-01').format('MMMM YYYY');
                        if (columnChart[ind] == undefined) {
                            columnChart.push([name, val.count]);
                        } else {
                            columnChart[ind][1] += val.count;
                        }
                    });
                });
                this.columnChart = columnChart;
            },
            showDemand(){
                this.loading = true;
                axios.post(this.$config.api + '?action=GetKeywordIdeas', {
                        keyword: this.keyword,
                        locations: JSON.parse(localStorage.getItem('locations')),
                        requestType: 'IDEAS'
                    }
                ).then((response) => {
                    if (response.status == 200) {
                        this.queryResult = response.data;

                    }
                    this.loading = false;
                }).catch(e => {
                    this.loading = false;
                });
                this.loadingStats = true;
                axios.post(this.$config.api + '?action=GetKeywordIdeas', {
                        keyword: this.keyword,
                        locations: JSON.parse(localStorage.getItem('locations')),
                        requestType: 'STATS'
                    }
                ).then((response) => {
                    if (response.status == 200) {
                        this.queryResultStats = response.data;
                        this.setChart(this.queryResultStats)
                    }
                    this.loadingStats = false;
                }).catch(e => {
                    this.loadingStats = false;
                });
            },
            step2(){
                var addkeywordStats = this.queryResultStats.filter(function (elem) {
                    if (elem.addkeyword == true) return elem;
                });
                var addkeyword = this.queryResult.filter(function (elem) {
                    if (elem.addkeyword == true) return elem;
                });
                var allAddKeyword = addkeywordStats.concat(addkeyword);
                localStorage.setItem('addKeyword', JSON.stringify(allAddKeyword));
                window.location.href='/roi-calculator';
            }
        }
    }
</script>