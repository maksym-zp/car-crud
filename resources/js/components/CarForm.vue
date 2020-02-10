<template>
    <form>
        <div class="form-group">
            <label for="name">Case: </label>
            <input type="text"
                   class="form-control"
                   name="name"
                   id="name"
                   v-model="carData.name"
                   @blur="handleInputFocusOut($event)"
            />
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
        <button type="submit" class="btn btn-primary" :disabled="buttonDisabled">Get quote</button>
    </form>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment';

    export default {
        name: "CarComponent",
        props: ['user', 'car', 'brands', 'models'],
        data: function () {
            return {
                carModel: [],
                carData: {...this.car} || {},
                modelsData: {...this.models} || {},
                buttonDisabled: false
            }
        },
        components: {
            Datepicker
        },
        methods: {
            handleInputFocusOut(event) {
                if (event.target.name === 'milage' && event.target.value > 100000) {
                    this.buttonDisabled = true;
                    alert('We can insure your car');
                }else if(event.target.name === 'milage' && event.target.value < 100000){
                    this.buttonDisabled = false;
                    this.updated();
                } else {
                    this.updated();
                }

            },
            onChange(event) {
                if (event.target.name === 'brand') {
                    this.carData.model_id = null;

                    this.updated();

                    this.getModelsByBrand(event.target.value)
                } else if (event.target.name === 'model') {
                    this.updated();
                }

            },
            updated() {
                let data = this.checkBuyingFormat();
                if (data.name && data.name.length > 0) {
                    let uri = '/car/update';
                    axios.put(uri, data).then((response) => {
                        console.log('response', response);
                    }).catch((errors) => {
                        console.log('errors', errors);
                    });
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
            customFormatter(date) {
                return moment(date).format('YYYY-MM-DD');
            },
            selectedBuying(date){
                this.carData.buying = moment(date).format('YYYY-MM-DD');
                this.updated();
            },
            checkBuyingFormat() {
                let data = {...this.carData};
                if (data.buying) {
                    data.buying = moment(this.carData.buying).format('YYYY-MM-DD');
                }
                return data;
            }
        }
    }
</script>