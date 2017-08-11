<template>
    <div id="app">
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
                {{keyword}}
            </form>
        </div>
        <p v-if="loading">loading</p>
        <div>
            <column-chart :data="columnChart" width="800px" height="500px"    ></column-chart>
        </div>
        <app-table-keyword  :queryResult="STATSqueryResult" :queryResultPage="STATSqueryResultPage"  ></app-table-keyword>
        <app-table-keyword  :queryResult="queryResult"  :queryResultPage="queryResultPage" ></app-table-keyword>
        <!--<div v-if="queryResult.length!==0" >-->
            <!--<table >-->
                <!--<thead>-->
                <!--<tr >-->
                    <!--<th>Suggested</th>-->
                    <!--<th>Average searches</th>-->
                <!--</tr>-->
                <!--</thead>-->

                <!--<tbody>-->
                <!--<tr v-for="(item, index) in queryResultPage">-->
                    <!--<td>{{item.keyword}}</td>-->
                    <!--<td>{{item.searchVolume | formatNumber}}</td>-->
                <!--</tr>-->
                <!--</tbody>-->
            <!--</table>-->
            <!--<div>-->
                <!--<div>-->
                    <!--Show rows <span>-->
                    <!--<button class="" type="button" >{{limit}}-->
                        <!--<span class="caret"></span></button>-->
                    <!--<ul >-->
                        <!--<li v-on:click="restResult(5)" ><span>5</span></li>-->
                        <!--<li v-on:click="restResult(10)"><span>10</span></li>-->
                        <!--<li v-on:click="restResult(20)"><span>20</span></li>-->
                        <!--<li v-on:click="restResult(30)"><span>30</span></li>-->
                        <!--<li v-on:click="restResult(50)"><span>50</span></li>-->
                        <!--<li v-on:click="restResult(100)"><span>100</span></li>-->
                    <!--</ul>-->
                <!--</span> {{offsetThisPage+1}} - {{limitThisPage}} of {{queryResult.length}} keywords-->
                <!--</div>-->

                <!--<span v-on:click="first()" > |< </span>-->
                <!--<span v-on:click="prev()" > <  </span>-->
                <!--<span v-on:click="next()" > >  </span>-->
                <!--<span v-on:click="last()" > >| </span>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div v-if="queryResult.length!==0" >-->

            <!--<table >-->
                <!--<thead>-->
                <!--<tr  >-->
                    <!--<th>Suggested</th>-->
                    <!--<th>Average searches</th>-->
                <!--</tr>-->
                <!--</thead>-->

                <!--<tbody>-->
                <!--<tr v-for="(item, index) in queryResultPage">-->
                    <!--<td>{{item.keyword}}</td>-->
                    <!--<td>{{item.searchVolume | formatNumber}}</td>-->
                <!--</tr>-->
                <!--</tbody>-->
            <!--</table>-->
            <!--<div>-->
                <!--<div>-->
                    <!--Show rows <span>-->
                    <!--<button class="" type="button" >{{limit}}-->
                        <!--<span class="caret"></span></button>-->
                    <!--<ul >-->
                        <!--<li v-on:click="restResult(5)" ><span>5</span></li>-->
                        <!--<li v-on:click="restResult(10)"><span>10</span></li>-->
                        <!--<li v-on:click="restResult(20)"><span>20</span></li>-->
                        <!--<li v-on:click="restResult(30)"><span>30</span></li>-->
                        <!--<li v-on:click="restResult(50)"><span>50</span></li>-->
                        <!--<li v-on:click="restResult(100)"><span>100</span></li>-->
                    <!--</ul>-->
                <!--</span> {{offsetThisPage+1}} - {{limitThisPage}} of {{queryResult.length}} keywords-->
                <!--</div>-->

            <!--<span v-on:click="first()" > |< </span>-->
            <!--<span v-on:click="prev()" > <  </span>-->
            <!--<span v-on:click="next()" > >  </span>-->
            <!--<span v-on:click="last()" > >| </span>-->
            <!--</div>-->
        <!--</div>-->

    </div>
</template>
<!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
<!--<div id="chart_div"></div>-->

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
    Chartkick.options = {colors: ["rgb(66, 133, 244)"]};

    Vue.use(VueChartkick, { Chartkick })



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
        },
        data(){
            return {
                columnChart:[['2050', 28], ['aug1 2016', 32], ['aug2 2016', 32],['aug3 2016', 32],['aug4 2016', 32],['aug5 2016', 32],['aug6 2016', 32],['aug7 2016', 32],['aug8 2016', 32],['aug9 2016', 32],['aug10 2016', 32],['aug11 2016', 32]],
                loading: false,
                offset:0,
                limit:30,
                offsetThisPage:0,
                limitThisPage:30,
                page:1,
                keyword: '',
                queryResult: [],
                STATSqueryResult: [],
                queryResultPage: [],
                STATSqueryResultPage: []
            }
        },
        methods: {
            first(){
                this.page = 1;
                this.getResult();
            },
            prev(){
                if(1<this.page){
                    this.page -= 1;
                    this.getResult();
                }
            },
            next(){
                var count_page = Math.ceil((this.queryResult.length - 1) / this.limit);
                if(count_page < this.page){
                    this.page += 1;
                    this.getResult();
                }
            },
            last(){
                this.page = Math.ceil((this.queryResult.length - 1) / this.limit);
                this.getResult();
            },
            restResult(limit){
                this.limit = limit;
                this.offset = 0;
                this.getResult();
            },
            getResult: function () {
                var offset = this.page * this.offset;
                if (this.page >= 2) {
                    offset = (this.page - 1) * this.limit;
                }
                var limit = offset + this.limit;
                this.offsetThisPage = offset;
                this.limitThisPage = limit;
               return this.queryResultPage = this.queryResult.slice(offset, limit);
            },
            validateForm(scope) {
                this.$validator.validateAll(scope).then(result => {
                    if (result) {
                        // eslint-disable-next-line
                        this.showDemand();
                    }
                });
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
                        this.getResult();
                        this.queryResultPage = this.getResult();
                    }
                    this.loading = false;
                }).catch(e => {
                    this.loading = false;
                });
                axios.post(this.$config.api + '?action=GetKeywordIdeas', {
                        keyword: this.keyword,
                        locations: JSON.parse(localStorage.getItem('locations')),
                        requestType: 'STATS'
                    }
                ).then((response) => {
                    if (response.status == 200) {
                        this.STATSqueryResult = response.data;
                        this.getResult();
                        this.STATSqueryResultPage = this.getResult();
                    }
                    this.loading = false;
                }).catch(e => {
                    this.loading = false;
                });
            }
        }
    }
</script>