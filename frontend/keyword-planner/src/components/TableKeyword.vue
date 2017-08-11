<template>
    <div>
        <div v-if="queryResult.length!==0">
            <table>
                <thead>
                <tr>
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
                        <button class="" type="button">{{limit}}
                            <span class="caret"></span></button>
                        <ul>
                            <li v-on:click="restResult(5)"><span>5</span></li>
                            <li v-on:click="restResult(10)"><span>10</span></li>
                            <li v-on:click="restResult(20)"><span>20</span></li>
                            <li v-on:click="restResult(30)"><span>30</span></li>
                            <li v-on:click="restResult(50)"><span>50</span></li>
                            <li v-on:click="restResult(100)"><span>100</span></li>
                        </ul>
                    </span> {{offsetThisPage+1}} - {{limitThisPage}} of {{queryResult.length}} keywords
                </div>

                <span v-on:click="first()"> |< </span>
                <span v-on:click="prev()"> <  </span>
                <span v-on:click="next()"> >  </span>
                <span v-on:click="last()"> >| </span>
            </div>
        </div>
    </div>
</template>
<script>
export default  {
        props: ['queryResult'],
        watch: {
            queryResult: function (newVal) {
                this.queryResul=newVal
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
            }
        }
    };
</script>