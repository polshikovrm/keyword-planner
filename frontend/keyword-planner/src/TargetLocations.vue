<template>
    <div id="app">
        <div>
            target Locations
        </div>
        <autocomplete
                v-bind:url="getUrl()"
                anchor="canonical_name"
                label="target_type"
                :on-select="getData"
        >
        </autocomplete>
        <li v-for="(item, index) in locations">
            <p>{{ item.canonical_name }} -{{ item.target_type }} <b  v-on:click="remove(index)">Remove</b> <b  v-on:click="setCentre(index)">Nearby</b> </p>
        </li>
        <div >
            <gmap-map
                    :center="center"
                    :zoom="5"
                    style="width: 700px; height: 500px"
            >
                <gmap-info-window
                        :key="index"
                        v-for="(m, index) in locations"
                        :position="m.marker.position"
                        :options="infoOptions"
                        :content="m.marker.ifw2text"
                        :opened="m.marker.ifw"
                        @closeclick="m.marker.ifw=false"
                ></gmap-info-window>
                <gmap-marker
                        :key="index"
                        v-for="(m, index) in locations"
                        :position="m.marker.position"
                        :clickable="true"
                        :draggable="false"
                        @click="m.marker.ifw=!m.marker.ifw">
                </gmap-marker>
            </gmap-map>

        </div>
    </div>
</template>
<script src="https://vuejs.org/js/vue.min.js"></script>
<script src="./dist/vue2-autocomplete.js"></script>

<script>

    import Autocomplete from 'vue2-autocomplete-js';
    import axios from 'axios';
    import * as VueGoogleMaps from 'vue2-google-maps';
    import Vue from 'vue';
    Vue.use(VueGoogleMaps, {
        load: {
            key: 'AIzaSyBoV5tHJ4v6pQVp0xSx8NdipvhZe3ECEA8',
            v: '',
            // libraries: 'places', //// If you need to use place input
        }
    });

    export default {

        components: { Autocomplete},
        data(){
            return {
                locations:this.getlocations(),
                center:this.getCentreDefoult(),
                infoOptions: {
                    pixelOffset: {
                        width: 0,
                        height: -35
                    }
                }
            }
        },
        methods: {
            getCentreDefoult(){
                var center = {lat: 10.0, lng: 10.0};
                var location = JSON.parse(localStorage.getItem('locations'));
                if (location[location.length - 1]) {
                    center = location[location.length - 1].marker.position;
                }
                return center;
            },
            setCentre(index){
               this.center = this.locations[index].marker.position;
            },
            getlocations(){
                var locations = [];
                if (JSON.parse(localStorage.getItem('locations'))) {
                        locations = JSON.parse(localStorage.getItem('locations'));
                }
                return locations;
            },
            getData(obj){
                var id = obj.criteria_id;
                var item = this.locations.filter(function (item) {
                    return item.criteria_id == id;
                }).pop();
                if (!item) {
                    axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
                        params: {
                            address: obj.canonical_name,
                            key: 'AIzaSyBoV5tHJ4v6pQVp0xSx8NdipvhZe3ECEA8',
                            sensor: false,
                            language: 'en'
                        }
                    }
                    ).then((response) => {
                        if(response.status==200 && response.data.status=='OK' && response.data.results[0]!== undefined){
                            this.center = response.data.results[0].geometry.location;
                            var marker = {
                                position: response.data.results[0].geometry.location,
                                opacity: 1,
                                draggable: true,
                                enabled: true,
                                clicked: 0,
                                rightClicked: 0,
                                dragended: 0,
                                ifw: false,
                                ifw2text: obj.canonical_name+' ('+obj.target_type+')'
                            };
                            obj.marker = marker;
                            this.locations.push(obj);
                            localStorage.setItem('locations', JSON.stringify(this.locations));
                        }
                    }).catch(e => {
                         console.log('error',e);
                    })
                }
            },
            getUrl(){
                return this.$config.api+'/target_locations.php';
            },
            remove(index){
                delete this.locations.splice(index, 1);
                localStorage.setItem('locations', JSON.stringify(this.locations));
            }
        }
    };

</script>
