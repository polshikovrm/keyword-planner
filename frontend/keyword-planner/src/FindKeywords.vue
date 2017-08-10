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
            <div id="chart_div"> </div>
        </div>
        <div v-if="queryResult.length!==0" >
            <table >
                <thead>
                <tr  >
                    <th>Suggested</th>
                    <th>Average searches</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="(item, index) in queryResultPage">
                    <td>{{item.keyword}}</td>
                    <td>{{item.searchVolume | formatNumber}}</td>
                </tr>
                </tbody>
            </table>
            <div>
                <div>
                    Show rows <span>
                    <button class="" type="button" >{{limit}}
                        <span class="caret"></span></button>
                    <ul >
                        <li v-on:click="restResult(5)" ><span>5</span></li>
                        <li v-on:click="restResult(10)"><span>10</span></li>
                        <li v-on:click="restResult(20)"><span>20</span></li>
                        <li v-on:click="restResult(30)"><span>30</span></li>
                        <li v-on:click="restResult(50)"><span>50</span></li>
                        <li v-on:click="restResult(100)"><span>100</span></li>
                    </ul>
                </span> {{offsetThisPage+1}} - {{limitThisPage}} of {{queryResult.length}} keywords
                </div>

            <span v-on:click="first()" > |< </span>
            <span v-on:click="prev()" > <  </span>
            <span v-on:click="next()" > >  </span>
            <span v-on:click="last()" > >| </span>
            </div>
        </div>
    </div>
</template>
<!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
<!--<div id="chart_div"></div>-->
<script>
    import axios from 'axios';
    import Vue from 'vue';
    import VeeValidate from 'vee-validate';
    import numeral from 'numeral';
    import {GoogleCharts} from 'google-charts';

    GoogleCharts.load(drawCharts,'BarChart');

    /*
     * Load a specific type(s) of chart(s). You can call this as many times as you need from anywhere in your app
     * GoogleCharts is a singleton and will not allow the script to be loaded more than once
     */
//    GoogleCharts.load(drawGeoChart, 'geochart');

    function drawCharts() {
        var data = new GoogleCharts.api.visualization.arrayToDataTable([
            ['Move', 'searches'],
            ["1 2016", 44],
            ["2 2016", 31],
            ["3 2016", 12],
            ["4 2016", 10],
            ['5 2016', 3],
            ["6 2016", 44],
            ["7 2016", 31],
            ["8 2016", 12],
            ["9 2016", 10],
            ['10 2016', 3],
            ['11 2016', 3],
            ['12 2016', 3]
        ]);

        var options = {
//            width: 800,
            legend: { position: 'none' },
            chart: {
                title: 'Average monthly searches',
            },
            axes: {
                x: {
                    0: { side: 'foot', label: 'White to move'} // Top x-axis.
                }
            },
            bar: { groupWidth: "90%" }
        };
         console.log(GoogleCharts.api.visualization);
//        debugger

//        var chart = new GoogleCharts.api.visualization.Bar(document.getElementById('chart_div'));
        // Convert the Classic options to Material options.
//        chart.draw(data, GoogleCharts.api.Bar.convertOptions(options));
//        chart.draw(data, options);


//
//        var data = new GoogleCharts.api.visualization.DataTable();
//        data.addColumn('timeofday', 'Time of Day');
//        data.addColumn('number', 'Motivation Level');
//
//        data.addRows([
//            [{v: [8, 0, 0], f: 'Jul 2016'}, 1],
//            [{v: [9, 0, 0], f: 'Jul 2016'}, 2],
//            [{v: [10, 0, 0], f:'Jul 2016'}, 3],
//            [{v: [11, 0, 0], f: 'Jul 2016'}, 4],
//            [{v: [12, 0, 0], f: 'Jul 2016'}, 5],
//            [{v: [13, 0, 0], f: 'Jul 2016'}, 6],
//            [{v: [14, 0, 0], f: 'Jul 2016'}, 7],
//            [{v: [15, 0, 0], f: 'Jul 2016'}, 8],
//            [{v: [16, 0, 0], f: 'Jul 2016'}, 9],
//            [{v: [17, 0, 0], f: 'Jul 2016'}, 10],
//            [{v: [18, 0, 0], f: 'Jul 2016'}, 11],
//            [{v: [19, 0, 0], f: 'Jul 2016'}, 12],
//        ]);
//
//        var options = {
//            title: 'Motivation Level Throughout the Day',
//            hAxis: {
//                title: 'Time of Day',
//                format: 'MM',
//                viewWindow: {
//                    min: [7, 30, 0],
//                    max: [19, 30, 0]
//                }
//            },
////            vAxis: {
////                title: 'Rating (scale of 1-10)'
////            }
//        };
//
//        var chart = new GoogleCharts.api.visualization.ColumnChart(
//            document.getElementById('chart_div'));
//
//        chart.draw(data, options);
    }



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

        components: {},
        data(){
            return {
                loading: false,
                offset:0,
                limit:30,
                offsetThisPage:0,
                limitThisPage:30,
                page:1,
                keyword: '',
                queryResult: [],
                queryResultPage: []
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
                this.page += 1;
                this.getResult();
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
                this.queryResultPage = this.queryResult.slice(offset, limit);
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
                        locations: JSON.parse(localStorage.getItem('locations'))
                    }
                ).then((response) => {
                    if (response.status == 200) {
                        this.queryResult = response.data;
                        this.getResult();
                    }
                    this.loading = false;
                }).catch(e => {
                    this.loading = false;
                });
            }
        }
    }
</script>