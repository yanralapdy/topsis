<template>
    <input
        id="pac-input"
        class="controls w-full mb-2 p-2 border rounded-lg border-black-50"
        placeholder="Search Place Name"
        v-if="showSearchBox"
    />
    <div class="map" ref="mapDivRef"></div>
</template>

<script>
import { ref, onMounted } from "vue";
import InputText from "primevue/inputtext";
import { usePage } from "@inertiajs/vue3";

export default {
    name: "GMap",
    props: {
        center: { lat: Number, lng: Number },
        zoom: Number,
        mapType: String,
        disableUI: Boolean,
        onMapClick: Function,
        searchBoxOnMap: Boolean,
        showSearchBox: {
            type: Boolean,
            default: true,
        },
    },
    components: {
        InputText,
    },
    setup(props) {
        // the google map object
        const map = ref(null);

        // the map element in the templste
        const mapDivRef = ref(null);

        // load in the google script
        onMounted(() => {
            // key is is the .env file
            const key = usePage().props.app.google_maps_api_key;

            // create the script element to load
            const googleMapScript = document.createElement("SCRIPT");
            // with marker
            googleMapScript.setAttribute(
                "src",
                `https://maps.googleapis.com/maps/api/js?key=${key}&callback=initMap&libraries=places&v=weekly`,
            );

            googleMapScript.setAttribute("defer", "");
            googleMapScript.setAttribute("async", "");
            document.head.appendChild(googleMapScript);
        });

        /**
         * this function is called as soon as the map is initialized
         */
        window.initMap = () => {
            map.value = new window.google.maps.Map(mapDivRef.value, {
                mapTypeId: props.mapType || "hybrid",
                zoom: props.zoom || 8,
                disableDefaultUI: props.disableUI || false,
                center:
                    props.center.lat !== 0
                        ? props.center
                        : { lat: -6.175371641294809, lng: 106.82714939117432 },
            });
            // add marker to maps
            const marker = new window.google.maps.Marker({
                position: props.center,
                map: map.value,
            });

            // add event listener set marker on click
            map.value.addListener("click", (e) => {
                marker.setPosition(e.latLng);
                // set value to form
                props.center.lat = e.latLng.lat();
                props.center.lng = e.latLng.lng();
                if (!props.disableUI) {
                    // call function from parent
                    props.onMapClick({
                        lat: e.latLng.lat(),
                        lng: e.latLng.lng(),
                    });
                }
            });

            // add search box
            const input = document.getElementById("pac-input");
            const searchBox = new window.google.maps.places.SearchBox(input);

            // if you want to place the search box on the map
            if (props.searchBoxOnMap) {
                map.value.controls[window.google.maps.ControlPosition.TOP].push(
                    input,
                );
            }

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // For each place, get the icon, name and location.
                const bounds = new window.google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log(
                            "Returned place contains no geometry",
                            place,
                        );
                        return;
                    }
                    // const icon = {
                    //     url: place.icon,
                    //     size: new window.google.maps.Size(71, 71),
                    //     origin: new window.google.maps.Point(0, 0),
                    //     anchor: new window.google.maps.Point(17, 34),
                    //     scaledSize: new window.google.maps.Size(25, 25),
                    // };

                    // // Create a marker for each place.
                    // new window.google.maps.Marker({
                    //     map,
                    //     icon,
                    //     title: place.name,
                    //     position: place.geometry.location,
                    // });
                    marker.setPosition(place.geometry.location);
                    marker.setTitle(place.name);
                    // set value to form
                    props.center.lat = place.geometry.location.lat();
                    props.center.lng = place.geometry.location.lng();
                    // call function from parent
                    props.onMapClick({
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng(),
                    });
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.value.fitBounds(bounds);
            });
        };

        return {
            mapDivRef,
        };
    },
};
</script>

<style lang="css" scoped>
.map {
    width: 100%;
    height: 500px;
    background-color: azure;
}
</style>
