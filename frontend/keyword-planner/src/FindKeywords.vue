<template>
    <div id="app">
        <div>
            find keywords
        </div>
        <div>
            <form  v-on:submit.prevent="showDemand()">

                <input v-model="keyword" type="text" >
                <button type="submit">show demand</button>
                <button type="reset">reset</button>
                {{keyword}}
            </form>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import Vue from 'vue';

    export default {

        components: { },
        data(){
            return {
                keyword:''
            }
        },
        methods: {
            showDemand(){
                axios.post(this.$config.api+'?action=GetKeywordIdeas', {
                        keyword: this.keyword,
                        locations:JSON.parse(localStorage.getItem('locations'))
                    }
                ).then((response) => {
                    if(response.status == 200){

                    }
            }).catch(e => {
                    debugger
                    console.log('error', e);
            })

            }
        }
    }
</script>