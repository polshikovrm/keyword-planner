<template>
    <div id="app">
        <app-logout></app-logout>
        <div>
            find keywords
        </div>
        <div>
            <form   @submit.prevent="validateForm('form-1')" data-vv-scope="form-1">

                <!--<input v-model="keyword" type="text" >-->
                <div class="column is-12">
                    <label class="label" for="keyword">keyword</label>
                    <p :class="{ 'control': true }">
                        <input v-model="keyword" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('form-1.keyword') }" name="keyword" type="text" placeholder="keyword">
                        <span v-show="errors.has('form-1.keyword')" class="help is-danger">{{ errors.first('form-1.keyword') }}</span>
                    </p>
                </div>
                <button type="submit">show demand</button>
                <button type="reset">reset</button>
            </form>
        </div>
        <div v-if="columnChart.length">
            <column-chart :data="columnChart" width="800px" height="500px"    ></column-chart>
        </div>
        <p v-if="loadingStats">loading Stats</p>
        <app-table-keyword :queryResult="queryResultStats"   ></app-table-keyword>
        <p v-if="loading">loading</p>
        <app-table-keyword :queryResult="queryResult"   ></app-table-keyword>

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
                        this.queryResultStats= response.data;
                        this.setChart(this.queryResultStats)
                    }
                    this.loadingStats = false;
                }).catch(e => {
                    this.loadingStats = false;
                });
            }
        }
    }
</script>