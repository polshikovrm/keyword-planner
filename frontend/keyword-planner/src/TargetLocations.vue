<template>
    <div id="app">
        <div class="content-holder">
            <app-logout></app-logout>
            <div class="title-block">
                <h1><span class="number">1</span>Target Locations</h1>
            </div>
            <div class="clearfix location-content">
                <div class="location-holder">
                    <form action="#" class="search-form">
                        <fieldset>
                            <div class="search-input">
                                <autocomplete class="input" ref="autocomplete" placeholder="Enter a location to target"
                                        v-bind:url="getUrl()"
                                        anchor="canonical_name"
                                        label="target_type"
                                        :min="1"
                                        model="search"
                                        :on-select="getData"
                                >
                                </autocomplete>
                            </div>
                            <input type="submit" value="Search">
                        </fieldset>
                    </form>

                    <ul class="results-list" v-if="locations.length!==0">
                        <li class="title">Locations</li>
                        <li v-for="(item, index) in locations">
                            <div class="width1">
                                <p>{{ item.canonical_name }} -{{ item.target_type }}</p>
                            </div>
                            <div class="width2">
                                <span v-on:click="remove(index)" class="func">Remove</span>
                                <span v-on:click="setCentre(index)" class="func">Nearby</span>
                            </div>
                        </li>
                    </ul>
                    <div class="clearfix"><a href="/find-keywords" class="btn btn-next">Next</a></div>
                </div>
                <div class="map-holder">
                    <gmap-map
                            :center="center"
                            :zoom="5"
                            style="width: 100%; height: 100%"
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
    import logout from './components/logout.vue';
    Vue.use(VueGoogleMaps, {
        load: {
            key: 'AIzaSyBoV5tHJ4v6pQVp0xSx8NdipvhZe3ECEA8',
            v: '3',
            // libraries: 'places', //// If you need to use place input
        }
    });

    export default {

        components: {
            'Autocomplete':Autocomplete,
            'app-logout': logout
        },
        data(){
            return {
                loading: false,
                locations:this.getLocations(),
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
                var center = {lat: 37.4737414, lng: -101.8170633};
                var location = JSON.parse(localStorage.getItem('locations'));
                if (location !== null && location[location.length - 1]) {
                    var position = JSON.parse(JSON.stringify(location[location.length - 1].marker.position));
                    center = position;
                }
                return center;
            },
            setCentre(index){
                var position = JSON.parse(JSON.stringify(this.locations[index].marker.position));
                if (this.center.lat == this.locations[index].marker.position.lat && this.center.lng == this.locations[index].marker.position.lng) {
                    this.center.lat = position.lat - 0.00000001;
                    this.center.lng = position.lng - 0.00000001;
                } else {
                    this.center = position;
                }
            },
            getLocations(){
                var locations = [];
                if (JSON.parse(localStorage.getItem('locations'))) {
                        locations = JSON.parse(localStorage.getItem('locations'));
                }
                return locations;
            },
            clear(){
                this.$refs.autocomplete.clearInput();
            },
            getData(obj){
                var id = obj.criteria_id;
                var item = this.locations.filter(function (item) {
                    return item.criteria_id == id;
                }).pop();
                if (!item) {
                    this.loading=true;
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
                            this.loading = true;
                        }
                    }).catch(e => {
                        this.loading=true;
                    })
                }
                this.clear();
            },
            getUrl(){
                return this.$config.api+'/targetLocations.php';
            },
            remove(index){
                delete this.locations.splice(index, 1);
                localStorage.setItem('locations', JSON.stringify(this.locations));
            }
        }
    };

</script>
