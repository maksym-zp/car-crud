<template>
    <form>
    <tabs :onSelect="onSelect">
        <tab title="Page 1">

                <div class="form-group">
                    <label for="name">Case: </label>
                    <input type="text"
                           class="form-control"
                           name="name"
                           id="name"
                           v-model="carData.name"
                           @blur="handleInputFocusOut($event)"
                    />
                    <small id="emailHelp" class="form-text text-muted">Case is required for saving other fields.</small>
                </div>

                <div class="form-group">
                    <label for="brand">Make: </label>
                    <select v-model="carData.brand_id"
                            @change="onChange($event)"
                            name="brand"
                            class="form-control">
                        <option disabled value="" id="brand">Select brand</option>
                        <option v-for="brand in brands" v-bind:value="brand.id" :key="brand.id">{{brand.name}}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="carModel">Model: </label>
                    <select v-model="carData.model_id"
                            @change="onChange($event)"
                            name="model"
                            class="form-control">
                        <option disabled value="" id="carModel">Select model</option>
                        <option v-for="model in modelsData" v-bind:value="model.id" :key="model.id">{{model.name}}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="milage">Milage: </label>
                    <input type="number"
                           min="0"
                           class="form-control"
                           name="milage"
                           id="milage"
                           v-model="carData.milage"
                           @blur="handleInputFocusOut"
                    />
                </div>
                <div class="form-group">
                    <label for="buying">Buying Date: </label>
                    <datepicker
                            input-class="form-group"
                            wrapper-class="form-group"
                            name="buying"
                            id="buying"
                            v-model="carData.buying"
                            :format="customFormatter"
                            @selected="selectedBuying"
                    ></datepicker>

                </div>



        </tab>
        <tab title="Page 2">
            <div class="form-group">
                <label for="color">Color: </label>
                <select v-model="carData.color_id"
                        @change="onChange($event)"
                        name="color"
                        class="form-control">
                    <option disabled value="" id="color">Select color</option>
                    <option v-for="color in colors" v-bind:value="color.id" :key="color.id">{{color.name}}</option>
                </select>
            </div>
            <div v-if="(this.carData.model_id === this.canHasDriveTrain)" class="form-group">
                <label for="drivetrain">Drivetrain: </label>
                <select v-model="carData.drivetrain"
                        @change="onChange($event)"
                        name="drivetrain"
                        class="form-control">
                    <option disabled value="" id="drivetrain">Select drivetrain</option>
                    <option v-for="drivetrain in driveTrainVariables"  :key="drivetrain">{{drivetrain}}</option>
                </select>
            </div>
            <ImageUploader :image="this.imageUrl" ></ImageUploader>
        </tab>
    </tabs>
        <button type="submit"
                class="btn btn-primary"
                :disabled="buttonDisabled"
                v-on:click="getQuote($event)"
        >Get quote</button>
    </form>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment';
    import { Tabs, Tab } from 'vue-slim-tabs'
    import ImageUploader from './ImageUploader';
    import EventBus from './../event-bus';
    export default {
        name: "CarComponent",
        props: ['user', 'car', 'brands', 'models', 'colors', 'canHasDriveTrain', 'driveTrainVariables', 'carImage'],
        data: function () {
            return {
                carModel: [],
                carData: {...this.car} || {},
                imageUrl: {...this.carImage} || {},
                modelsData: {...this.models} || {},
                buttonDisabled: false
            }
        },
        components: {
            Datepicker, Tabs, Tab, ImageUploader
        },
        methods: {
            handleInputFocusOut(event) {
                if (event.target.name === 'milage' && event.target.value > 100000) {
                    this.buttonDisabled = true;
                    alert('We can insure your car');
                }else if(event.target.name === 'milage' && event.target.value < 100000){
                    this.buttonDisabled = false;
                    this.updatedFormData();
                } else {
                    this.updatedFormData();
                }

            },
            onChange(event) {
                if (event.target.name === 'brand') {
                    this.carData.model_id = null;

                    this.getModelsByBrand(event.target.value)
                } else if(event.target.name === 'model') {

                    if(parseInt(event.target.value) !== this.canHasDriveTrain){
                        this.carData.drivetrain = null;
                    }

                }
                this.updatedFormData();
            },
            updatedFormData() {
                let data = this.checkBuyingFormat();
                if (data.name && data.name.length > 0) {
                    let uri = '/car/update';
                    axios.put(uri, data).then((response) => {
                        console.log('response', response);
                    }).catch((errors) => {
                        console.log('errors', errors);
                    });
                }else{
                    alert('Write case text first !');
                }
            },
            getModelsByBrand(id) {
                let uri = '/brand/' + id;
                axios.get(uri).then((response) => {
                    if (response.data) {
                        this.modelsData = response.data;
                    }
                }).catch((errors) => {
                    console.log('errors', errors);
                });
            },
            getDriveTrainVariables(){
                let uri = '/drive-train';
                axios.get(uri).then((response) => {
                    if (response.data) {
                        this.driveTrainVariablesData = response.data;
                    }
                }).catch((errors) => {
                    console.log('errors', errors);
                });
            },
            customFormatter(date) {
                return moment(date).format('YYYY-MM-DD');
            },
            selectedBuying(date){
                this.carData.buying = moment(date).format('YYYY-MM-DD');
                this.updatedFormData();
            },
            checkBuyingFormat() {
                let data = {...this.carData};
                if (data.buying) {
                    data.buying = moment(this.carData.buying).format('YYYY-MM-DD');
                }
                return data;
            },
            onSelect(e, index) {
                let self = this;
                    EventBus.$on('new-url', function (url) {

                        if(url){
                            self.imageUrl.url = url;
                        }

                    });
            },
            getQuote(e){
                e.preventDefault();
                alert('getQuote');
            }
        }

    }
</script>
<style scoped>
    .tablist {
        list-style: none;
        display: flex;
        padding-left: 0;
        border-bottom: 1px solid #e2e2e2;
    }

    .vue-tab {
        padding: 5px 10px;
        cursor: pointer;
        user-select: none;
        border: 1px solid transparent;
        border-bottom-color: #e2e2e2;
        border-radius: 3px 3px 0 0;
        background-color: white;
        position: relative;
        bottom: -1px;
    }

    .vue-tab[aria-selected="true"] {
        border-color: #e2e2e2;
        border-bottom-color: transparent;
    }

    .vue-tab[aria-disabled="true"] {
        cursor: not-allowed;
        color: #999;
    }

</style>