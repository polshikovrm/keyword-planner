<template>
    <!--<div>-->
        <div v-if="queryResult.length!==0">
            <table class="table result-table">
                <thead>
                <tr>
                    <th class="width1">{{title}}</th>
                    <th class="width2">
                        <span class="text">Average searches</span>
                        <span class="select-holder"  v-bind:class="{ open: selectInterval }" >
                            <button class="select-button" v-on:click="selectInterval=!selectInterval"  type="button" v-click-outside="outsideInterval">{{interval}}</button>
                            <ul class="select-list">
                                <li v-on:click="interval='Month'"><span>Month</span></li>
                                <li v-on:click="interval='Day'"><span>Day</span></li>
                                <li v-on:click="interval='Year'"><span>Year</span></li>
                            </ul>
                        </span>
                    </th>
                    <!--<th class="width3">Add Keyword</th>-->
                </tr>
                </thead>

                <tbody>
                <tr v-for="(item, index) in queryResultPage">
                    <td class="width1">{{item.keyword}}</td>
                    <td class="width2" v-if="interval=='Month'" >{{item.searchVolume | formatNumber}}</td>
                    <td class="width2" v-if="interval=='Day'">{{item.searchVolume / 30 | formatNumber}}</td>
                    <td class="width2" v-if="interval=='Year'">{{item.searchVolume * 12 | formatNumber}}</td>
                    <!--<td class="width3"><span  class="add-btn" v-on:click="toggleKeyword(item)" v-bind:class="{ plus: item.addkeyword }" >+</span></td>-->
                </tr>
                </tbody>
            </table>
            <div class="info-holder clearfix">
                <div class="pagination">
                    <span class="first-page" v-on:click="first()"> | <span class="arrow">&#8249;</span> </span>
                    <span v-on:click="prev()"> <span class="arrow">&#8249;</span>  </span>
                    <span v-on:click="next()"> <span class="arrow">	&#8250;</span>  </span>
                    <span class="last-page" v-on:click="last()"> <span class="arrow">	&#8250;</span>| </span>
                </div>
                <div class="info-block">
                    <span>Show rows </span>
                    <span class="select-holder"  v-bind:class="{ open: selectList }" >
                        <button class="select-button" v-on:click="selectList=!selectList"  type="button" v-click-outside="outside">{{limit}}</button>
                        <ul class="select-list">
                            <li v-on:click="restResult(5)"><span>5</span></li>
                            <li v-on:click="restResult(10)"><span>10</span></li>
                            <li v-on:click="restResult(20)"><span>20</span></li>
                            <li v-on:click="restResult(30)"><span>30</span></li>
                            <li v-on:click="restResult(50)"><span>50</span></li>
                            <li v-on:click="restResult(100)"><span>100</span></li>
                        </ul>
                    </span>
                    <span>{{offsetThisPage+1}} - {{limitThisPage}} of {{queryResult.length}} keywords</span>
                </div>
            </div>
        </div>
    <!--</div>-->
</template>
<script>
export default  {
        props: ['queryResult','title'],
        watch: {
            queryResult: function (newVal) {
                this.queryResul = newVal;
                this.getResult();
            }
        },
        data(){
            return {
                loading: false,
                offset:0,
                limit:30,
                offsetThisPage:0,
                limitThisPage:30,
                page:1,
                queryResultPage: [],
                selectList: false,
                selectInterval: false,
                interval: 'Month'
            }
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
        methods: {
            outside: function(e) {
                this.selectList = false;
            },
            outsideInterval: function(e) {
                this.selectInterval = false;
            },
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
                if(count_page > this.page){
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
                this.selectList = false;
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
            toggleKeyword(item){
                item.addkeyword = !item.addkeyword;
                this.getResult();
            }
        }
    };
</script>