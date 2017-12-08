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
                                <span class="help">(for multiple keywords, please separate each keyword with a comma)</span>
                                <span v-show="errors.has('form-1.keyword')" class="help is-danger">{{ errors.first('form-1.keyword') }}</span>

                            </p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="content-holder">
                <div v-if="columnChart.length">
                    <div class="title-block">
                        <h1><span class="number">3</span>Demand Data</h1>
                        <p>Trend Over The Past 12 Months</p>
                    </div>
                    <div class="chart-holder">
                        <column-chart :data="columnChart"  height="500px"></column-chart>
                    </div>
                    <ul class="results-list" v-if="locations.length!==0">
                        <li class="title">Locations</li>
                        <li v-for="(item, index) in locations">
                            <div class="width1">
                                <p>{{ item.canonical_name }} -{{ item.target_type }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <p v-if="loadingStats"><img src="src/assets/loading.gif" alt="image description" class="loading"></p>
                <p v-if="responseErrorStats">{{responseErrorStats}}</p>
                <div v-if="queryResultStats.length!==0" >
                    <table class="table result-table">
                        <thead>
                        <tr>
                            <th class="width1">{{title0}}</th>
                            <th class="width2">
                                <span class="text">Average searches</span>
                                <span class="select-holder" v-bind:class="{ open: selectInterval }">
                            <button class="select-button" v-on:click="selectInterval=!selectInterval"
                                    type="button" v-click-outside="outsideInterval">{{interval}}</button>
                            <ul class="select-list">
                                <li v-on:click="interval='Month'"><span>Month</span></li>
                                <li v-on:click="interval='Day'"><span>Day</span></li>
                                <li v-on:click="interval='Year'"><span>Year</span></li>
                            </ul>
                        </span>
                            </th>
                            <th class="width3">Average Suggested Bid
                                <span v-on:click="hideSuggested()" class="hide_column">
                        <span v-if="hideSuggestedBid">unhide</span>
                        <span v-if="!hideSuggestedBid">hide</span>
                    </span>
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr >
                            <td class="width1">Your selected keywords</td>
                            <td class="width2" v-if="interval=='Month'">{{averageVolume | formatNumber}}</td>
                            <td class="width2" v-if="interval=='Day'">{{averageVolume / 30 | formatNumber}}</td>
                            <td class="width2" v-if="interval=='Year'">{{averageVolume * 12 | formatNumber}}</td>
                            <td class="width3" v-if="interval=='Month'" ><span v-if="!hideSuggestedBid" >${{averageVolumeSuggestedBid |formatFloat}}</span></td>
                            <td class="width3" v-if="interval=='Day'" ><span v-if="!hideSuggestedBid" >${{averageVolumeSuggestedBid / 30 |formatFloat }}</span></td>
                            <td class="width3" v-if="interval=='Year'" ><span v-if="!hideSuggestedBid" >${{averageVolumeSuggestedBid * 12  |formatFloat}}</span></td>

                        </tr>
                        </tbody>
                    </table>
                </div>
                <p v-if="loadingStats"><img src="src/assets/loading.gif" alt="image description" class="loading"></p>
                <p v-if="responseErrorStats">{{responseErrorStats}}</p>
                <app-table-keyword :queryResult="queryResultStats" :title="title1" :paginationShow="false"
                                   :interval="interval"
                                   :hideSuggestedBid="hideSuggestedBid"
                                   v-on:queryResultPage="changedResultStatsPage"
                ></app-table-keyword>
                <p v-if="loading"><img src="src/assets/loading.gif" width="" height="" alt="image description" class="loading"></p>
                <p v-if="responseError">{{responseError}}</p>
                <app-table-keyword :queryResult="queryResult" :title="title2" :paginationShow="false"
                                   :interval="interval"
                                   :hideSuggestedBid="hideSuggestedBid"
                                   v-on:queryResultPage="changedResultPage"
                ></app-table-keyword>
                <!--to do:  v-on:click="step2()" - go to step 2-->
                <div class="clearfix download-block">
                    <a href="/target-locations" class="btn btn-prev">Back</a>
                    <!--<a href="#" class="btn btn-next">Coming soon...</a>-->
                    <form v-bind:action="downloadAction" method="post" target="_blank" >
                        <div  v-for="(item, index) in resultPage" >
                            <input type="hidden" name="queryResult[keyword][]" v-model="item.keyword" >
                            <input type="hidden" name="queryResult[searchVolume][]" v-model="item.searchVolume" >
                            <input type="hidden" name="queryResult[suggestedBid][]" v-model="item.suggestedBid" >
                        </div>
                        <div  v-for="(item, index) in resultStatsPage" >
                            <input type="hidden" name="queryResultStats[keyword][]" v-model="item.keyword" >
                            <input type="hidden" name="queryResultStats[searchVolume][]" v-model="item.searchVolume" >
                            <input type="hidden" name="queryResultStats[suggestedBid][]" v-model="item.suggestedBid" >
                        </div>
                        <div  v-for="(item, index) in locations" >
                            <input type="hidden" name="locations[]" v-model="item.fullName" >
                        </div>
                        <input type="hidden" name="averageVolume" v-model="averageVolume" >
                        <input type="hidden" name="averageVolumeSuggestedBid" v-model="averageVolumeSuggestedBid" >
                        <input type="hidden" name="suggestedHide" v-model="hideSuggestedBid" >
                        <input type="hidden" name="suggestedStatsHide" v-model="hideSuggestedBid" >
                        <input type="hidden" name="queryResultInterval" v-model="interval" >
                        <input type="hidden" name="queryResultStatsInterval"  v-model="interval">
                        <button type="submit"  v-if="queryResultStats.length!==0 && queryResult.length!==0"  class="btn-simple"><span class="icon-download"></span>Download</button>
                    </form>
                </div>
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
    Vue.filter("formatFloat", function (value) {
        return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
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
        directives: {
            'click-outside': {
                bind: function(el, binding, vNode) {
                    // Provided expression must evaluate to a function.
                    if (typeof binding.value !== 'function') {
                        const compName = vNode.context.name
                        let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
                        if (compName) { warn += `Found in component '${compName}'` }

                        console.warn(warn)
                    }
                    // Define Handler and cache it on the element
                    const bubble = binding.modifiers.bubble
                    const handler = (e) => {
                        if (bubble || (!el.contains(e.target) && el !== e.target)) {
                            binding.value(e)
                        }
                    }
                    el.__vueClickOutside__ = handler

                    // add Event Listeners
                    document.addEventListener('click', handler)
                },

                unbind: function(el, binding) {
                    // Remove Event Listeners
                    document.removeEventListener('click', el.__vueClickOutside__)
                    el.__vueClickOutside__ = null

                }
            }
        },
        data(){
            return {
                columnChart:[],
                locations:this.getLocations(),
                loading: false,
                loadingStats: false,
                keyword: '',
                queryResult: [],
                queryResultStats: [],
                responseError:false,
                responseErrorStats:false,
                title0:'Search Demand',
                title1:'Keyword Breakdown',
                title2:'More Suggested Keywords',
                downloadAction:"",
                queryResultInterval:"Month",
                queryResultStatsInterval:"Month",
                resultPage:[],
                resultStatsPage:[],
                suggestedHide:false,
                suggestedStatsHide:false,

                selectList: false,
                selectInterval: false,
                interval: 'Month',
                hideSuggestedBid: false,
                hideSuggestedBidText:'hide',
                averageVolume: 0,
                averageVolumeSuggestedBid: 0
            }
        },
        methods: {
            outsideInterval: function(e) {
                this.selectInterval = false;
//                this.$emit('interval',this.interval);
            },
            hideSuggested:function () {
                this.hideSuggestedBid=!this.hideSuggestedBid;
//                this.$emit('suggestedhide',this.hideSuggestedBid);
            },
            changedIntervalResult(a){
               this.queryResultInterval=a;
            },
            changedIntervalResultStats(a){
                this.queryResultStatsInterval=a;
            },
            changedSuggestedStatsHide1(a){
                this.suggestedStatsHide=a;
                this.suggestedHide=a;
            },
            changedSuggestedStatsHide(a){
                this.suggestedStatsHide=a;
            },
            changedSuggestedHide(a){
                this.suggestedHide=a;
            },
            changedResultPage(a){
                this.resultPage=a;
            },
            changedResultStatsPage(a){
                this.resultStatsPage=a;
            },
            getLocations(){
                var locations = [];
                if (JSON.parse(localStorage.getItem('locations'))) {
                    locations = JSON.parse(localStorage.getItem('locations'));
                    locations.forEach(function (item,index) {
                        locations[index].fullName=item.canonical_name+' -'+item.target_type;
                    });
                }
                return locations;
            },
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
                        var name = moment(val.year + '-' + month + '-01').format('YYYY-MM');
                        var data = moment(val.year + '-' + month + '-01').format('YYYY-MM');
                        if (columnChart[ind] == undefined) {
                            columnChart.push([name, val.count,data]);
                        } else {
                            columnChart[ind][1] += val.count;
                        }
                    });
                });
                function compare(a, b) {
                    if (a[2] < b[2])
                        return -1;
                    if (a[2] > b[2])
                        return 1;
                    return 0;
                }
                this.columnChart = columnChart.sort(compare);
            },
            setAverage(queryResult){
               let averageVolumeSuggestedBid = this.averageVolumeSuggestedBid;
               let averageVolume = this.averageVolume;
                queryResult.forEach(function (value) {
                    averageVolumeSuggestedBid = averageVolumeSuggestedBid + parseFloat(value.suggestedBidWithOutDollarSign);
                    averageVolume = averageVolume + parseFloat(value.searchVolume);
                });
                this.averageVolumeSuggestedBid =   averageVolumeSuggestedBid /queryResult.length;
                this.averageVolume =  averageVolume /queryResult.length;
            },
            showDemand(){
                this.downloadAction = this.$config.api+'download.php';
                this.loading = true;
                this.responseError=false;
                axios.post(this.$config.api + '?action=GetKeywordIdeas&token='+this.$cookie.get('PHPSESSID'), {
                        keyword: this.keyword,
                        locations: JSON.parse(localStorage.getItem('locations')),
                        requestType: 'IDEAS'
                    }
                ).then((response) => {
                    if (response.status == 200 && Array.isArray(response.data) ) {
                        this.queryResult = response.data.slice(0, 10);
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
                this.loadingStats = true;
                this.responseErrorStats=false;
                axios.post(this.$config.api + '?action=GetKeywordIdeas&&token='+this.$cookie.get('PHPSESSID'), {
                        keyword: this.keyword,
                        locations: JSON.parse(localStorage.getItem('locations')),
                        requestType: 'STATS'
                    }
                ).then((response) => {
                    if (response.status == 200 && Array.isArray(response.data) ) {
                        this.queryResultStats = response.data;
//                         console.log(this.queryResultStats);

                        this.setChart(this.queryResultStats);
                        this.setAverage(response.data);
                    }else{
                         this.responseErrorStats='There was a problem retrieving ideas, please try again.'
                    }
                    this.loadingStats = false;
                }).catch(e => {
                    this.$cookie.delete('PHPSESSID');
                    localStorage.removeItem('locations');
                    localStorage.removeItem('addKeyword');
                    window.location.href = '/';
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